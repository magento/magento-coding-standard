<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magento2\Tests\PHPCompatibility;

/**
 * Test the RemovedCallingDestructAfterConstructorExit sniff.
 *
 * @covers \Magento2\Sniffs\PHPCompatibility\RemovedCallingDestructAfterConstructorExitSniff
 */
class RemovedCallingDestructAfterConstructorExitUnitTest extends \PHPCompatibility\Tests\FunctionDeclarations\RemovedCallingDestructAfterConstructorExitUnitTest
{    /**
 * @inheritdoc
 */
    protected function getSniffCode()
    {
        return 'Magento2.PHPCompatibility.RemovedCallingDestructAfterConstructorExit';
    }
}
