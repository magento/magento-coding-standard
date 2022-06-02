<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento2\Sniffs\Annotation;

use Magento2\Helpers\Commenting\PHPDocFormattingValidator;
use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

/**
 * Sniff to validate structure of public, private, protected method annotations
 */
class MethodAnnotationStructureSniff implements Sniff
{
    /**
     * @var AnnotationFormatValidator
     */
    private $annotationFormatValidator;

    /**
     * @var PHPDocFormattingValidator
     */
    private $PHPDocFormattingValidator;

    /**
     * AnnotationStructureSniff constructor.
     */
    public function __construct()
    {
        $this->annotationFormatValidator = new AnnotationFormatValidator();
        $this->PHPDocFormattingValidator = new PHPDocFormattingValidator();
    }

    /**
     * @inheritdoc
     */
    public function register()
    {
        return [
            T_FUNCTION
        ];
    }

    /**
     * @inheritdoc
     */
    public function process(File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();
        $commentStartPtr = $phpcsFile->findPrevious(T_DOC_COMMENT_OPEN_TAG, ($stackPtr), 0);
        $commentEndPtr = $phpcsFile->findPrevious(T_DOC_COMMENT_CLOSE_TAG, ($stackPtr), 0);
        if (!$commentStartPtr) {
            $phpcsFile->addError('Comment block is missing', $stackPtr, 'MethodArguments');
            return;
        }

        if ($this->PHPDocFormattingValidator->hasDeprecatedWellFormatted($commentStartPtr, $tokens) !== true) {
            $phpcsFile->addWarning(
                'Motivation behind the added @deprecated tag MUST be explained. '
                . '@see tag MUST be used with reference to new implementation when code is deprecated '
                . 'and there is a new alternative.',
                $stackPtr,
                'InvalidDeprecatedTagUsage'
            );
        }

        $commentCloserPtr = $tokens[$commentStartPtr]['comment_closer'];
        $functionPtrContent = $tokens[$stackPtr + 2]['content'];
        if (preg_match('/(?i)__construct/', $functionPtrContent)) {
            return;
        }
        $emptyTypeTokens = [
            T_DOC_COMMENT_WHITESPACE,
            T_DOC_COMMENT_STAR
        ];
        $shortPtr = $phpcsFile->findNext($emptyTypeTokens, $commentStartPtr + 1, $commentCloserPtr, true);
        if ($shortPtr === false) {
            $error = 'Annotation block is empty';
            $phpcsFile->addError($error, $commentStartPtr, 'MethodAnnotation');
        } else {
            $this->annotationFormatValidator->validateDescriptionFormatStructure(
                $phpcsFile,
                $commentStartPtr,
                (int)$shortPtr,
                $commentEndPtr,
                $emptyTypeTokens
            );
            if (empty($tokens[$commentStartPtr]['comment_tags'])) {
                return;
            }
            $this->annotationFormatValidator->validateTagsSpacingFormat(
                $phpcsFile,
                $commentStartPtr,
                $emptyTypeTokens
            );
            $this->annotationFormatValidator->validateTagGroupingFormat($phpcsFile, $commentStartPtr);
            $this->annotationFormatValidator->validateTagAligningFormat($phpcsFile, $commentStartPtr);
        }
    }
}
