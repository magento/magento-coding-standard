<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magento2\Tests\PHPCompatibility;

/**
 * Test the RemovedAssertStringAssertion sniff.
 *
 * @covers \Magento2\Sniffs\PHPCompatibility\RemovedAssertStringAssertionSniff
 */
class RemovedAssertStringAssertionUnitTest extends \PHPCompatibility\Tests\ParameterValues\RemovedAssertStringAssertionUnitTest
{
    /**
     * @inheritdoc
     */
    protected function getSniffCode()
    {
        return 'Magento2.PHPCompatibility.RemovedAssertStringAssertion';
    }
}
