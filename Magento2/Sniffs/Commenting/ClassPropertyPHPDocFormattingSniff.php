<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento2\Sniffs\Commenting;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\AbstractVariableSniff;
use PHP_CodeSniffer\Util\Tokens;
use Magento2\Helpers\Commenting\PHPDocFormattingValidator;

/**
 * Class ClassPropertyPHPDocFormattingSniff
 */
class ClassPropertyPHPDocFormattingSniff extends AbstractVariableSniff
{

    /**
     * @var array
     */
    private $ignoreTokens = [
        T_PUBLIC,
        T_PRIVATE,
        T_PROTECTED,
        T_VAR,
        T_STATIC,
        T_WHITESPACE,
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
        $scopes = Tokens::$ooScopeTokens;
        $this->PHPDocFormattingValidator = new PHPDocFormattingValidator();
        $listen = [
            T_VARIABLE,
            T_DOUBLE_QUOTED_STRING,
            T_HEREDOC,
        ];

        parent::__construct($scopes, $listen, true);
    }

    /**
     * @inheritDoc
     */
    public function processMemberVar(File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();

        $commentEnd = $phpcsFile->findPrevious($this->ignoreTokens, ($stackPtr - 1), null, true);
        if ($commentEnd === false
            || ($tokens[$commentEnd]['code'] !== T_DOC_COMMENT_CLOSE_TAG
                && $tokens[$commentEnd]['code'] !== T_COMMENT)
        ) {
            $phpcsFile->addWarning('Missing PHP DocBlock for class property.', $stackPtr, 'Missing');
            return;
        }
        $commentStart = $tokens[$commentEnd]['comment_opener'];
        $foundVar = null;
        foreach ($tokens[$commentStart]['comment_tags'] as $tag) {
            if ($tokens[$tag]['content'] === '@var') {
                if ($foundVar !== null) {
                    $error = 'Only one @var tag is allowed for class property declaration.';
                    $phpcsFile->addWarning($error, $tag, 'DuplicateVar');
                } else {
                    $foundVar = $tag;
                }
            }
        }

        if ($foundVar === null) {
            $error = 'Class properties must have type declaration using @var tag.';
            $phpcsFile->addWarning($error, $stackPtr, 'MissingVar');
            return;
        }

        $string = $phpcsFile->findNext(T_DOC_COMMENT_STRING, $foundVar, $commentEnd);
        if ($string === false || $tokens[$string]['line'] !== $tokens[$foundVar]['line']) {
            $error = 'Content missing for @var tag in class property declaration.';
            $phpcsFile->addWarning($error, $foundVar, 'EmptyVar');
            return;
        }

        // Check if class has already have meaningful description after @var tag
        $isShortDescriptionAfterVar = $phpcsFile->findNext(
            T_DOC_COMMENT_STRING,
            $foundVar + 4,
            $commentEnd,
            false,
            null,
            false
        );
        if ($this->PHPDocFormattingValidator->providesMeaning(
            $isShortDescriptionAfterVar,
            $commentStart,
            $tokens
        ) !== true) {
            preg_match(
                '`^((?:\|?(?:array\([^\)]*\)|[\\\\\[\]]+))*)( .*)?`i',
                $tokens[($foundVar + 2)]['content'],
                $varParts
            );
            if ($varParts[1]) {
                return;
            }
            $error = 'Short description duplicates class property name.';
            $phpcsFile->addWarning($error, $isShortDescriptionAfterVar, 'AlreadyHaveMeaningFulNameVar');
            return;
        }
        // Check if class has already have meaningful description before @var tag
        $isShortDescriptionPreviousVar = $phpcsFile->findPrevious(
            T_DOC_COMMENT_STRING,
            $foundVar,
            $commentStart,
            false,
            null,
            false
        );
        if ($this->PHPDocFormattingValidator->providesMeaning(
            $isShortDescriptionPreviousVar,
            $commentStart,
            $tokens
        ) !== true) {
            preg_match(
                '`^((?:\|?(?:array\([^\)]*\)|[\\\\\[\]]+))*)( .*)?`i',
                $tokens[($foundVar + 2)]['content'],
                $varParts
            );
            if ($varParts[1]) {
                return;
            }
            $error = 'Short description duplicates class property name.';
            $phpcsFile->addWarning($error, $isShortDescriptionPreviousVar, 'AlreadyHaveMeaningFulNameVar');
            return;
        }
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
