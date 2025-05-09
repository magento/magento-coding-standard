<?php
/**
 * Copyright 2021 Adobe
 * All Rights Reserved.
 */
namespace Magento2\Sniffs\Less;

use PHP_CodeSniffer\Sniffs\Sniff;
use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Util\Tokens;

/**
 * Class ColonSpacingSniff
 *
 * Ensure that colon spacing is right
 *
 * @link https://devdocs.magento.com/guides/v2.4/coding-standards/code-standard-less.html#properties-colon-indents
 */
class ColonSpacingSniff implements Sniff
{
    /**
     * A list of tokenizers this sniff supports.
     *
     * @var array
     */
    public $supportedTokenizers = [TokenizerSymbolsInterface::TOKENIZER_CSS];

    /**
     * @inheritdoc
     */
    public function register()
    {
        return [T_COLON];
    }

    /**
     * @inheritdoc
     */
    public function process(File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();

        if ($this->needValidateSpaces($phpcsFile, $stackPtr, $tokens)) {
            $this->validateSpaces($phpcsFile, $stackPtr, $tokens);
        }
    }

    /**
     * Check is it need to check spaces
     *
     * @param File $phpcsFile
     * @param int $stackPtr
     * @param array $tokens
     *
     * @return bool
     */
    private function needValidateSpaces(File $phpcsFile, $stackPtr, $tokens)
    {
        if (TokenizerSymbolsInterface::BITWISE_AND === $tokens[$stackPtr - 1]['content']) {
            return false;
        }

        // Avoid false positives when parsing pseudo-classes
        $next = $phpcsFile->findNext([T_SEMICOLON, T_OPEN_CURLY_BRACKET], $stackPtr + 1);
        if ($tokens[$next]['code'] === T_OPEN_CURLY_BRACKET) {
            return false;
        }

        $prev = $phpcsFile->findPrevious(Tokens::$emptyTokens, ($stackPtr - 1), null, true);
        if ($tokens[$prev]['content'] === 'progid') {
            // Special case for IE filters.
            return false;
        }

        return true;
    }

    /**
     * Validate Colon Spacing according to requirements:
     * - No spaces before colon
     * - Exactly 1 space after colon
     * - No property definition scattered among several lines
     *
     * @param File $phpcsFile
     * @param int $stackPtr
     * @param array $tokens
     *
     * @return void
     */
    private function validateSpaces(File $phpcsFile, $stackPtr, array $tokens)
    {
        if (T_WHITESPACE === $tokens[($stackPtr - 1)]['code']) {
            $phpcsFile->addError('There must be no space before a colon in a style definition', $stackPtr, 'Before');
        }

        $nextSemicolon = $phpcsFile->findNext(T_SEMICOLON, $stackPtr);
        if (false !== $nextSemicolon && ($tokens[$nextSemicolon]['line'] !== $tokens[$stackPtr]['line'])) {
            $error = 'Expected 1 space after colon in style definition; newline found';
            $phpcsFile->addError($error, $stackPtr, 'AfterNewline');
        }

        if (T_WHITESPACE !== $tokens[($stackPtr + 1)]['code']) {
            $phpcsFile->addError('Expected 1 space after colon in style definition; 0 found', $stackPtr, 'NoneAfter');
        } else {
            $content = $tokens[($stackPtr + 1)]['content'];
            if (false !== strpos($content, ' ')) {
                $length  = strlen($content);
                if ($length !== 1) {
                    $error = sprintf('Expected 1 space after colon in style definition; %s found', $length);
                    $phpcsFile->addError($error, $stackPtr, 'After');
                }
            }
        }
    }
}
