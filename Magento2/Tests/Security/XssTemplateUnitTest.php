<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento2\Tests\Security;

use PHP_CodeSniffer\Tests\Standards\AbstractSniffUnitTest;

class XssTemplateUnitTest extends AbstractSniffUnitTest
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
            3 => 2,
            4 => 1,
            5 => 1,
            6 => 1,
            7 => 1,
            8 => 1,
            9 => 1,
            10 => 1,
            13 => 1,
            14 => 1,
            16 => 1,
            17 => 1,
            18 => 1,
            19 => 1,
            20 => 1,
            21 => 1,
            25 => 2,
        ];
    }
}
