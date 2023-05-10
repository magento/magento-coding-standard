<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magento2\Tests\PHPCompatibility;

/**
 * Test the ChangedIntToBoolParamType sniff.
 *
 * @covers \Magento2\Sniffs\PHPCompatibility\ChangedIntToBoolParamTypeSniff
 */
class ChangedIntToBoolParamTypeUnitTest extends \PHPCompatibility\Tests\ParameterValues\ChangedIntToBoolParamTypeUnitTest
{
    /**
     * @inheritdoc
     */
    protected function getSniffCode()
    {
        return 'Magento2.PHPCompatibility.ChangedIntToBoolParamType';
    }
}
