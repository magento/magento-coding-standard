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
class FunctionsPHPDocFormattingUnitTest extends AbstractSniffUnitTest
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

        if($testFile === 'FunctionsPHPDocFormattingUnitTest.2.inc')
        {
            return [
                11,
                19,
                26,
                30,
                40,
                47,
                55,
                62,
                69,
                80
            ];
        }

        return [];
    }
}
