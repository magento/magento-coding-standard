<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magento2\Tests\PHPCompatibility;

/**
 * Test the RemovedDollarBraceStringEmbeds sniff.
 *
 * @covers \Magento2\Sniffs\PHPCompatibility\RemovedDollarBraceStringEmbedsSniff
 */
class RemovedDollarBraceStringEmbedsUnitTest extends \PHPCompatibility\Tests\TextStrings\RemovedDollarBraceStringEmbedsUnitTest
{    /**
 * @inheritdoc
 */
    protected function getSniffCode()
    {
        return 'Magento2.PHPCompatibility.RemovedDollarBraceStringEmbeds';
    }
}
