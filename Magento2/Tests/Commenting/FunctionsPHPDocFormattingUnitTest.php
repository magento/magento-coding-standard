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
        if ($testFile !== 'FunctionsPHPDocFormattingUnitTest.2.inc') {
            return [];
        }

        return [
            11 => 1,
            19 => 1,
            26 => 2,
            30 => 1,
            40 => 1,
            47 => 1,
            55 => 2,
            62 => 1,
            69 => 1,
        ];
    }
}
