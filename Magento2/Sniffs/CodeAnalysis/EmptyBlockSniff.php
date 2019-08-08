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
        $posOfFunction = $phpcsFile->findNext([T_FUNCTION], $stackPtr);
        $functionName = $phpcsFile->getDeclarationName($posOfFunction);
        // Skip for around function
        if (strpos($functionName, 'around') !== false) {
            return;
        }

        parent::process($phpcsFile, $stackPtr);

    }//end process()
}
