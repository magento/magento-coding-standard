<?php
/**
 * Copyright © Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento2\Tests\Commenting;

use PHP_CodeSniffer\Tests\Standards\AbstractSniffUnitTest;

/**
 * Class ConstantsPHPDocFormattingUnitTest
 */
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
        if ($testFile === 'ConstantsPHPDocFormattingUnitTest.1.inc') {
            return [];
        }

        return [
            5 => 1,
            8 => 1,
            15 => 1,
            20 => 1
        ];
    }
}
