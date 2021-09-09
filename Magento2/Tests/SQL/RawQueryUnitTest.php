<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento2\Tests\SQL;

use PHP_CodeSniffer\Tests\Standards\AbstractSniffUnitTest;

class RawQueryUnitTest extends AbstractSniffUnitTest
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
            18 => 1,
            35 => 1,
            44 => 1,
            52 => 1,
            59 => 1,
            65 => 1,
            80 => 1,
            102 => 1,
            106 => 1,
            109 => 1,
        ];
    }
}
