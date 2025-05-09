<?php
/**
 * Copyright 2021 Adobe
 * All Rights Reserved.
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
        $commentEndPtr = $stackPtr;
        $tokensToFind = [
            \T_SEMICOLON,
            \T_OPEN_CURLY_BRACKET,
            \T_CLOSE_CURLY_BRACKET,
            \T_ATTRIBUTE_END,
            \T_DOC_COMMENT_CLOSE_TAG
        ];

        do {
            $commentEndPtr = $phpcsFile->findPrevious($tokensToFind, $commentEndPtr - 1);
            if ($commentEndPtr !== false
                && $tokens[$commentEndPtr]['code'] === \T_ATTRIBUTE_END
                && isset($tokens[$commentEndPtr]['attribute_opener'])
            ) {
                $commentEndPtr = $tokens[$commentEndPtr]['attribute_opener'];
            }
        } while ($commentEndPtr !== false && !in_array($tokens[$commentEndPtr]['code'], $tokensToFind, true));

        if ($commentEndPtr === false || $tokens[$commentEndPtr]['code'] !== \T_DOC_COMMENT_CLOSE_TAG) {
            $phpcsFile->addError('Comment block is missing', $stackPtr, 'NoCommentBlock');
            return;
        }

        $commentStartPtr = $tokens[$commentEndPtr]['comment_opener']
            ?? $phpcsFile->findPrevious(T_DOC_COMMENT_OPEN_TAG, $commentEndPtr - 1);

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
