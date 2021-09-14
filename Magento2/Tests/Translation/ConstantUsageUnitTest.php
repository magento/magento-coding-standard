<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento2\Tests\Translation;

use PHP_CodeSniffer\Tests\Standards\AbstractSniffUnitTest;

class ConstantUsageUnitTest extends AbstractSniffUnitTest
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
            5 => 1,
            7 => 1,
            9 => 1,
            12 => 1,
            15 => 1,
            17 => 1,
            19 => 1,
            21 => 1,
            24 => 1,
        ];
    }
}
