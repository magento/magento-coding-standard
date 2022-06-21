<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
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
        if ($tokens[$stackPtr]['code'] === T_FUNCTION &&
            strpos($phpcsFile->getDeclarationName($stackPtr), 'around') === 0) {
            return;
        }

        // Ignore empty constructor function blocks when using property promotion
        if ($tokens[$stackPtr]['code'] === T_FUNCTION &&
            strpos($phpcsFile->getDeclarationName($stackPtr), '__construct') === 0 &&
            count($phpcsFile->getMethodParameters($stackPtr)) > 0 &&
            array_reduce($phpcsFile->getMethodParameters($stackPtr), static function ($result, $methodParam) {
                return $result && isset($methodParam['property_visibility']);
            }, true)) {

            return;
        }

        parent::process($phpcsFile, $stackPtr);
    }//end process()
}
