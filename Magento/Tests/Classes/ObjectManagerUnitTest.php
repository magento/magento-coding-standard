<?php
/**
 * Copyright © Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\Tests\Classes;

use PHP_CodeSniffer\Tests\Standards\AbstractSniffUnitTest;

/**
 * Class ObjectManagerUnitTest
 */
class ObjectManagerUnitTest extends AbstractSniffUnitTest
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
            5 => 1,
            7 => 1,
            9 => 1,
            12 => 1,
            14 => 1,
            16 => 1,
            20 => 1,
            23 => 1,
        ];
    }
}
