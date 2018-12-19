<?php
/**
 * Copyright © Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\Tests\CodeAnalysis;

use PHP_CodeSniffer\Tests\Standards\AbstractSniffUnitTest;

/**
 * Class EmptyBlockUnitTest
 */
class EmptyBlockUnitTest extends AbstractSniffUnitTest
{
    /**
     * @inheritdoc
     */
    public function getErrorList()
    {
        return [
            3 => 1,
            15 => 1,
            17 => 1,
            19 => 1,
            30 => 1,
            35 => 1,
            41 => 1,
            47 => 1,
            52 => 1,
            55 => 1,
            64 => 1,
            68 => 1,
            72 => 2,
            74 => 1,
            81 => 1,
            88 => 1,
            92 => 1,
            98 => 1,
        ];
    }

    /**
     * @inheritdoc
     */
    public function getWarningList()
    {
        return [];
    }
}
