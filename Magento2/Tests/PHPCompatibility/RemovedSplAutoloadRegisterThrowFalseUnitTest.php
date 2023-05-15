<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magento2\Tests\PHPCompatibility;

/**
 * Test the RemovedSplAutoloadRegisterThrowFalse sniff.
 *
 * @covers \Magento2\Sniffs\PHPCompatibility\RemovedSplAutoloadRegisterThrowFalseSniff
 */
class RemovedSplAutoloadRegisterThrowFalseUnitTest extends \PHPCompatibility\Tests\ParameterValues\RemovedSplAutoloadRegisterThrowFalseUnitTest
{
    /**
     * @inheritdoc
     */
    protected function getSniffCode()
    {
        return 'Magento2.PHPCompatibility.RemovedSplAutoloadRegisterThrowFalse';
    }
}
