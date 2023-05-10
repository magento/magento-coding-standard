<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magento2\Tests\PHPCompatibility;

/**
 * Test the RemovedOptionalBeforeRequiredParam sniff.
 *
 * @covers \Magento2\Sniffs\PHPCompatibility\RemovedOptionalBeforeRequiredParamSniff
 */
class RemovedOptionalBeforeRequiredParamUnitTest extends \PHPCompatibility\Tests\FunctionDeclarations\RemovedOptionalBeforeRequiredParamUnitTest
{
    /**
     * @inheritdoc
     */
    protected function getSniffCode()
    {
        return 'Magento2.PHPCompatibility.RemovedOptionalBeforeRequiredParam';
    }
}
