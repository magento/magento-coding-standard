<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento2\Tests\Commenting;

use PHP_CodeSniffer\Tests\Standards\AbstractSniffUnitTest;

class ConstantsPHPDocFormattingUnitTest extends AbstractSniffUnitTest
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
        if ($testFile !== 'ConstantsPHPDocFormattingUnitTest.2.inc') {
            return [];
        }

        return [
            6 => 1,
            9 => 1,
            14 => 1,
            19 => 1,
            25 => 1,
            31 => 1,
            38 => 1,
            43 => 1,
            48 => 1,
            53 => 1,
            59 => 1,
            65 => 1
        ];
    }
}
