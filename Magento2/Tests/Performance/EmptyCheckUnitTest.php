<?php
/**
 * Copyright © Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento2\Tests\Performance;

use PHP_CodeSniffer\Tests\Standards\AbstractSniffUnitTest;

/**
 * Class EmptyCheckUnitTest
 */
class EmptyCheckUnitTest extends AbstractSniffUnitTest
{
    /**
     * @inheritdoc
     */
    public function getErrorList()
    {
        return [];
    }

    /**
     * @inheritdoc
     */
    public function getWarningList()
    {
        return [
            3 => 1,
            7 => 1,
            11 => 1,
            15 => 1,
            19 => 1,
            23 => 1,
            27 => 1,
            35 => 1,
            41 => 1,
            45 => 1,
            49 => 1,
            53 => 1,
            57 => 1,
            61 => 1,
            65 => 1,
            69 => 1,
            73 => 1,
            81 => 1,
            85 => 1,
            95 => 1,
        ];
    }
}
