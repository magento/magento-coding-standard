<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento2\Tests\Commenting;

use PHP_CodeSniffer\Tests\Standards\AbstractSniffUnitTest;

class ClassPropertyPHPDocFormattingUnitTest extends AbstractSniffUnitTest
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
            13 => 1,
            18 => 1,
            23 => 1,
            30 => 1,
            34 => 1,
            42 => 1,
            49 => 1,
            56 => 1,
            63 => 1,
            68 => 1,
            75 => 1,
            125 => 1,
            150 => 1,
            156 => 1,
            163 => 1,
            170 => 1
        ];
    }
}
