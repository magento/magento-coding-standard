<?php
/**
 * Copyright 2018 Adobe
 * All Rights Reserved.
 */
namespace Magento2\Sniffs\Translation;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

/**
 * Make sure that constants are not used as the first argument of translation function.
 */
class ConstantUsageSniff implements Sniff
{
    /**
     * Having previous line content allows to process multi-line declaration.
     *
     * @var string
     */
    protected $previousLineContent = '';

    /**
     * @inheritdoc
     */
    public function register()
    {
        return [T_OPEN_TAG];
    }

    /**
     * Copied from \Generic_Sniffs_Files_LineLengthSniff, minor changes made
     *
     * {@inheritdoc}
     *
     * @param \PHP_CodeSniffer\Files\File $phpcsFile
     * @param int $stackPtr
     * @return void|int
     */
    public function process(File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();

        // Make sure this is the first open tag
        $previousOpenTag = $phpcsFile->findPrevious(T_OPEN_TAG, ($stackPtr - 1));
        if ($previousOpenTag !== false) {
            return;
        }

        $tokenCount = 0;
        $currentLineContent = '';
        $currentLine = 1;

        for (; $tokenCount < $phpcsFile->numTokens; $tokenCount++) {
            if ($tokens[$tokenCount]['line'] === $currentLine) {
                $currentLineContent .= $tokens[$tokenCount]['content'];
            } else {
                $this->checkIfFirstArgumentConstant($phpcsFile, ($tokenCount - 1), $currentLineContent);
                $currentLineContent = $tokens[$tokenCount]['content'];
                $currentLine++;
            }
        }

        $this->checkIfFirstArgumentConstant($phpcsFile, ($tokenCount - 1), $currentLineContent);
    }

    /**
     * Checks if first argument of \Magento2\Framework\Phrase or translation function is a constant
     *
     * @param File $phpcsFile
     * @param int $stackPtr
     * @param string $lineContent
     * @return void
     */
    private function checkIfFirstArgumentConstant(
        File $phpcsFile,
        $stackPtr,
        $lineContent
    ) {
        $previousLineRegexp = '/(__|Phrase)\($/im';
        $currentLineRegexp = '/(__|Phrase)\(.+\)/';
        $currentLineMatch = preg_match($currentLineRegexp, $lineContent) !== 0;
        $previousLineMatch = preg_match($previousLineRegexp, $this->previousLineContent) !== 0;
        $this->previousLineContent = $lineContent;
        $error = 'Constants are not allowed as the first argument of translation function, use string literal instead';
        $constantRegexp = '[^\$\'"]+::[A-Z_0-9]+.*';
        if ($currentLineMatch) {
            $variableRegexp = "/(__|Phrase)\({$constantRegexp}\)/";
            if (preg_match($variableRegexp, $lineContent) !== 0) {
                $phpcsFile->addWarning($error, $stackPtr, 'VariableTranslation');
            }
        } elseif ($previousLineMatch) {
            $variableRegexp = "/^{$constantRegexp}/";
            if (preg_match($variableRegexp, $lineContent) !== 0) {
                $phpcsFile->addWarning($error, $stackPtr, 'VariableTranslation');
            }
        }
    }
}
