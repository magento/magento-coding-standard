<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\Sniffs\Annotation;

use PHP_CodeSniffer\Sniffs\Sniff;
use PHP_CodeSniffer\Files\File;

/**
 * Sniff to validate structure of class, interface annotations
 */
class ClassAnnotationStructureSniff implements Sniff
{
    /**
     * @var AnnotationFormatValidator
     */
    private $annotationFormatValidator;

    /**
     * @inheritdoc
     */
    public function register()
    {
        return [
            T_CLASS
        ];
    }

    /**
     * AnnotationStructureSniff constructor.
     */
    public function __construct()
    {
        // phpcs:ignore Magento.Classes.ObjectInstantiation.FoundDirectInstantiation
        $this->annotationFormatValidator = new AnnotationFormatValidator();
    }

    /**
     * Validates whether annotation block exists for interface, abstract or final classes
     *
     * @param File $phpcsFile
     * @param int $previousCommentClosePtr
     * @param int $stackPtr
     */
    private function validateInterfaceOrAbstractOrFinalClassAnnotationBlockExists(
        File $phpcsFile,
        $previousCommentClosePtr,
        $stackPtr
    ) {
        $tokens = $phpcsFile->getTokens();
        if ($tokens[$stackPtr]['type'] === 'T_CLASS') {
            if ($tokens[$stackPtr - 2]['type'] === 'T_ABSTRACT' &&
                $tokens[$stackPtr - 4]['content'] != $tokens[$previousCommentClosePtr]['content']
            ) {
                $error = 'Interface or abstract class is missing annotation block';
                $phpcsFile->addWarning($error, $stackPtr, 'ClassAnnotation');
            }
            if ($tokens[$stackPtr - 2]['type'] === 'T_FINAL' &&
                $tokens[$stackPtr - 4]['content'] != $tokens[$previousCommentClosePtr]['content']
            ) {
                $error = 'Final class is missing annotation block';
                $phpcsFile->addWarning($error, $stackPtr, 'ClassAnnotation');
            }
        }
    }

    /**
     * Validates whether annotation block exists
     *
     * @param File $phpcsFile
     * @param int $previousCommentClosePtr
     * @param int $stackPtr
     */
    private function validateAnnotationBlockExists(File $phpcsFile, $previousCommentClosePtr, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();
        $this->validateInterfaceOrAbstractOrFinalClassAnnotationBlockExists(
            $phpcsFile,
            $previousCommentClosePtr,
            $stackPtr
        );
        if ($tokens[$stackPtr - 2]['content'] != 'class' && $tokens[$stackPtr - 2]['content'] != 'abstract'
            && $tokens[$stackPtr - 2]['content'] != 'final'
            && $tokens[$stackPtr - 2]['content'] !== $tokens[$previousCommentClosePtr]['content']
        ) {
            $error = 'Class is missing annotation block';
            $phpcsFile->addWarning($error, $stackPtr, 'ClassAnnotation');
        }
    }

    /**
     * @inheritdoc
     */
    public function process(File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();
        $previousCommentClosePtr = $phpcsFile->findPrevious(T_DOC_COMMENT_CLOSE_TAG, $stackPtr - 1, 0);
        $this->validateAnnotationBlockExists($phpcsFile, $previousCommentClosePtr, $stackPtr);
        $commentStartPtr = $phpcsFile->findPrevious(T_DOC_COMMENT_OPEN_TAG, $stackPtr - 1, 0);
        if ($commentStartPtr === false) {
            return;
        }
        $commentCloserPtr = $tokens[$commentStartPtr]['comment_closer'];
        $emptyTypeTokens = [
            T_DOC_COMMENT_WHITESPACE,
            T_DOC_COMMENT_STAR
        ];
        $shortPtr = $phpcsFile->findNext($emptyTypeTokens, $commentStartPtr +1, $commentCloserPtr, true);
        if ($shortPtr === false) {
            $error = 'Annotation block is empty';
            $phpcsFile->addWarning($error, $commentStartPtr, 'MethodAnnotation');
        } else {
            $this->annotationFormatValidator->validateDescriptionFormatStructure(
                $phpcsFile,
                $commentStartPtr,
                (int) $shortPtr,
                $previousCommentClosePtr,
                $emptyTypeTokens
            );
        }
    }
}
