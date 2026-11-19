<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magento2\Tests\Performance;

use PHP_CodeSniffer\Tests\Standards\AbstractSniffUnitTest;

/**
 * Class EmptyCheckUnitTest
 */
class ForeachArrayMergeUnitTest extends AbstractSniffUnitTest
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
            11 => 1,
            19 => 1,
            41 => 1,
            57 => 1,
            63 => 1,
            76 => 1,
            80 => 1,
            86 => 1,
            130 => 1,
            131 => 1,
            147 => 1
        ];
    }
}
