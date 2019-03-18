<?php
/**
 * Copyright © Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento2\Tests\NamingConvention;

use PHP_CodeSniffer\Tests\Standards\AbstractSniffUnitTest;

/**
 * Class ReservedWordsUnitTest
 */
class ReservedWordsUnitTest extends AbstractSniffUnitTest
{
    /**
     * @inheritdoc
     */
    public function getErrorList()
    {
        return [
            2 => 1,
            4 => 1,
            6 => 1,
            8 => 1,
            10 => 1,
            12 => 1,
            14 => 1,
            16 => 1,
            18 => 1,
            20 => 1,
            22 => 1,
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
