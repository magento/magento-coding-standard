<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento2\Tests\Strings;

use PHP_CodeSniffer\Tests\Standards\AbstractSniffUnitTest;

class StringConcatUnitTest extends AbstractSniffUnitTest
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
            3 => 1,
            4 => 1,
            6 => 1,
            10 => 1,
            11 => 1,
            15 => 1,
        ];
    }
}
