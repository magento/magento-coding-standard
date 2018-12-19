<?php
/**
 * Copyright © Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\Sniffs\CodeAnalysis;

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
                T_CLASS,
                T_ABSTRACT,
                T_FUNCTION,
                T_INTERFACE,
                T_TRAIT
            ]
        );
    }
}
