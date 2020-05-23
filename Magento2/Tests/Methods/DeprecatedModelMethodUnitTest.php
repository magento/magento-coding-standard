<?php
/**
 * Copyright © Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento2\Tests\Methods;

use PHP_CodeSniffer\Tests\Standards\AbstractSniffUnitTest;

class DeprecatedModelMethodUnitTest extends AbstractSniffUnitTest
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
    public function getWarningList()
    {
        return [
            2 => 1,
            3 => 1,
            4 => 1
        ];
    }
}
