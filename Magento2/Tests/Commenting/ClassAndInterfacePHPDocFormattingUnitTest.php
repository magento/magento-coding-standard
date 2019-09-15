<?php

/**
 * Copyright © Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento2\Tests\Commenting;

use PHP_CodeSniffer\Tests\Standards\AbstractSniffUnitTest;

class ClassAndInterfacePHPDocFormattingUnitTest extends AbstractSniffUnitTest
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
    public function getWarningList($testFile = '')
    {
        return [
            19 => 1,
            27 => 1,
            35 => 1,
            44 => 1,
            52 => 1,
            64 => 1,
            65 => 1,
            66 => 1,
            101 => 1,
            118 => 1,
            127 => 1,
        ];
    }
}
