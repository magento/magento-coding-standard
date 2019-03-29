<?php
/**
 * Copyright © Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento2\Tests\Security;

use PHP_CodeSniffer\Tests\Standards\AbstractSniffUnitTest;

/**
 * Class IncludeFileUnitTest
 */
class IncludeFileUnitTest extends AbstractSniffUnitTest
{
    /**
     * @inheritdoc
     */
    public function getErrorList()
    {
        return [
            3 => 1,
            4 => 1,
            6 => 1,
            7 => 1,
            9 => 1,
            10 => 1,
            12 => 1,
            13 => 1,
            15 => 1,
            17 => 1,
            23 => 1,
            24 => 1,
            28 => 1,
            34 => 1,
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
