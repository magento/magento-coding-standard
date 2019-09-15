<?php
/**
 * Copyright © Magento. All rights reserved.
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
            20 => 1,
            26 => 1,
            33 => 1,
            38 => 1,
            43 => 1,
            49 => 1,
            55 => 1
        ];
    }
}
