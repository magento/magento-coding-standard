<?php
/**
 * Copyright 2018 Adobe
 * All Rights Reserved.
 */
namespace Magento2\Sniffs\Templates;

use PHP_CodeSniffer\Sniffs\Sniff;
use PHP_CodeSniffer\Files\File;

/**
 * Detects possible usage of $this variable files.
 */
class ThisInTemplateSniff implements Sniff
{
    private const MESSAGE_THIS = 'The use of $this in templates is deprecated. Use $block instead.';
    private const MESSAGE_HELPER = 'The use of helpers in templates is discouraged. Use ViewModel instead.';

    /**
     * @inheritdoc
     */
    public function register()
    {
        return [T_VARIABLE];
    }

    /**
     * @inheritdoc
     */
    public function process(File $phpcsFile, $stackPtr)
    {
        if ($phpcsFile->getTokensAsString($stackPtr, 1) !== '$this') {
            return;
        }
        $isHelperCall = $phpcsFile->findNext(T_STRING, $stackPtr, null, false, 'helper', true);
        if ($isHelperCall) {
            $phpcsFile->addWarning(self::MESSAGE_HELPER, $stackPtr, 'FoundHelper');
        }
        if ($phpcsFile->addFixableWarning(self::MESSAGE_THIS, $stackPtr, 'FoundThis') === true) {
            $phpcsFile->fixer->beginChangeset();
            $phpcsFile->fixer->replaceToken($stackPtr, '$block');
            $phpcsFile->fixer->endChangeset();
        }
    }
}
