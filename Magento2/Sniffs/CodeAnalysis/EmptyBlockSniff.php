<?php
/**
 * Copyright © Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento2\Sniffs\CodeAnalysis;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Standards\Generic\Sniffs\CodeAnalysis\EmptyStatementSniff;

/**
 * Detects possible empty blocks.
 */
class EmptyBlockSniff extends EmptyStatementSniff
{
    /**
     * @inheritdoc
     */
    public function register()
    {
        return array_merge(
            parent::register(),
            [
                T_FUNCTION,
                T_TRAIT
            ]
        );
    }
    /**
     * @inheritDoc
     */
    public function process(File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();
        $posOfString = $phpcsFile->findNext(T_STRING, $stackPtr);
        $stringContent = $tokens[$posOfString]['content'];
        /** Check if function starts with around and also checked if string length
          * greater than 6 so that exact blank function name 'around()' give us warning
          */
        if (substr($stringContent, 0, 6) === "around" && strlen($stringContent) > 6) {
            return;
        }

        parent::process($phpcsFile, $stackPtr);

    }//end process()
}
