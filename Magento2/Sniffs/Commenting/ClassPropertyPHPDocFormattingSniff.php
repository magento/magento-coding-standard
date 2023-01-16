<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento2\Sniffs\Commenting;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\AbstractVariableSniff;
use Magento2\Helpers\Commenting\PHPDocFormattingValidator;

/**
 * Class ClassPropertyPHPDocFormattingSniff
 */
class ClassPropertyPHPDocFormattingSniff extends AbstractVariableSniff
{
    /**
     * @var array
     */
    private const TOKENS_ALLOWED_BETWEEN_PHPDOC_AND_PROPERTY_NAME = [
        T_PUBLIC,
        T_PRIVATE,
        T_PROTECTED,
        T_VAR,
        T_STATIC,
        T_WHITESPACE,
        T_NS_SEPARATOR,
        T_STRING,
        T_COMMENT,
        T_NULLABLE,
        T_BITWISE_AND,
        T_TYPE_UNION,
    ];

    /**
     * @var PHPDocFormattingValidator
     */
    private $PHPDocFormattingValidator;

    /**
     * Constructs an ClassPropertyPHPDocFormattingSniff.
     */
    public function __construct()
    {
        $this->PHPDocFormattingValidator = new PHPDocFormattingValidator();

        parent::__construct();
    }

    /**
     * @inheritDoc
     */
    public function processMemberVar(File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();

        $commentEnd = $phpcsFile->findPrevious(
            self::TOKENS_ALLOWED_BETWEEN_PHPDOC_AND_PROPERTY_NAME,
            $stackPtr - 1,
            null,
            true
        );

        if ($commentEnd === false || $tokens[$commentEnd]['code'] !== T_DOC_COMMENT_CLOSE_TAG) {
            $phpcsFile->addWarning('Missing PHP DocBlock for class property.', $stackPtr, 'Missing');
            return;
        }

        $commentStart = $tokens[$commentEnd]['comment_opener'];
        if ($this->PHPDocFormattingValidator->hasDeprecatedWellFormatted($commentStart, $tokens) !== true) {
            $phpcsFile->addWarning(
                'Motivation behind the added @deprecated tag MUST be explained. '
                . '@see tag MUST be used with reference to new implementation when code is deprecated '
                . 'and there is a new alternative.',
                $stackPtr,
                'InvalidDeprecatedTagUsage'
            );
        }
        $varAnnotationPosition = null;
        foreach ($tokens[$commentStart]['comment_tags'] as $tag) {
            if ($tokens[$tag]['content'] === '@var') {
                if ($varAnnotationPosition !== null) {
                    $phpcsFile->addWarning(
                        'Only one @var tag is allowed for class property declaration.',
                        $tag,
                        'DuplicateVar'
                    );
                } else {
                    $varAnnotationPosition = $tag;
                }
            }
        }

        if ($varAnnotationPosition === null) {
            $phpcsFile->addWarning(
                'Class properties must have type declaration using @var tag.',
                $stackPtr,
                'MissingVar'
            );
            return;
        }

        $string = $phpcsFile->findNext(T_DOC_COMMENT_STRING, $varAnnotationPosition, $commentEnd);
        if ($string === false || $tokens[$string]['line'] !== $tokens[$varAnnotationPosition]['line']) {
            $phpcsFile->addWarning(
                'Content missing for @var tag in class property declaration.',
                $varAnnotationPosition,
                'EmptyVar'
            );
            return;
        }

        // Check if class has already have meaningful description after @var tag
        $shortDescriptionAfterVarPosition = $phpcsFile->findNext(
            T_DOC_COMMENT_STRING,
            $varAnnotationPosition + 4,
            $commentEnd,
            false,
            null,
            false
        );

        if ($this->PHPDocFormattingValidator->providesMeaning(
            $shortDescriptionAfterVarPosition,
            $commentStart,
            $tokens
        ) !== true) {
            preg_match(
                '`^((?:\|?(?:array\([^\)]*\)|[\\\\\[\]]+))*)( .*)?`i',
                $tokens[($varAnnotationPosition + 2)]['content'],
                $varParts
            );
            if ($varParts[1]) {
                return;
            }
            $phpcsFile->addWarning(
                'Short description must be before @var tag.',
                $shortDescriptionAfterVarPosition,
                'ShortDescriptionAfterVar'
            );
        }

        $this->processPropertyShortDescription($phpcsFile, $stackPtr, $varAnnotationPosition, $commentStart);
    }

    /**
     * Check if class has already have meaningful description before var tag
     *
     * @param File $phpcsFile
     * @param int $propertyNamePosition
     * @param int $varAnnotationPosition
     * @param int $commentStart
     */
    private function processPropertyShortDescription(
        File $phpcsFile,
        int $propertyNamePosition,
        int $varAnnotationPosition,
        int $commentStart
    ): void {
        $propertyShortDescriptionPosition = $phpcsFile->findPrevious(
            T_DOC_COMMENT_STRING,
            $varAnnotationPosition,
            $commentStart,
            false,
            null,
            false
        );

        if ($propertyShortDescriptionPosition === false) {
            return;
        }

        $tokens = $phpcsFile->getTokens();
        $propertyName = trim($tokens[$propertyNamePosition]['content'], '$');
        $shortDescription = strtolower($tokens[$propertyShortDescriptionPosition]['content']);

        if ($this->isDuplicate($propertyName, $shortDescription)) {
            $phpcsFile->addWarning(
                'Short description duplicates class property name.',
                $propertyShortDescriptionPosition,
                'AlreadyHaveMeaningfulNameVar'
            );
        }
    }

    /**
     * Does short description duplicate the property name
     *
     * @param string $propertyName
     * @param string $shortDescription
     * @return bool
     */
    private function isDuplicate(string $propertyName, string $shortDescription): bool
    {
        return $this->clean($propertyName) === $this->clean($shortDescription);
    }

    /**
     * Return only A-Za-z characters converted to lowercase from the string
     *
     * @param string $string
     * @return string
     */
    private function clean(string $string): string
    {
        return strtolower(preg_replace('/[^A-Za-z]/', '', $string));
    }

    /**
     * @inheritDoc
     * phpcs:disable Magento2.CodeAnalysis.EmptyBlock
     */
    protected function processVariable(File $phpcsFile, $stackPtr)
    {
    }

    /**
     * @inheritDoc
     * phpcs:disable Magento2.CodeAnalysis.EmptyBlock
     */
    protected function processVariableInString(File $phpcsFile, $stackPtr)
    {
    }
}
