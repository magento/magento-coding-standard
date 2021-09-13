<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento2\Tests\Functions;

use PHP_CodeSniffer\Tests\Standards\AbstractSniffUnitTest;

/**
 * Class StaticFunctionSniffTest
 */
class StaticFunctionUnitTest extends AbstractSniffUnitTest
{
    /**
     * @inheritdoc
     */
    protected function getErrorList()
    {
        return [];
    }

    /**
     * @inheritdoc
     */
    protected function getWarningList()
    {
        return [
            8 => 1,
            17 => 1
        ];
    }
}
