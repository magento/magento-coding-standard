<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magento2\Tests\Legacy;

use PHP_CodeSniffer\Tests\Standards\AbstractSniffUnitTest;

class ObsoleteResponseUnitTest extends AbstractSniffUnitTest
{
    /**
     * @inheritdoc
     */
    public function getErrorList($testFile = '')
    {
        return [];
    }

    /**
     * @inheritdoc
     */
    public function getWarningList($testFile = '')
    {
        return [
            7 => 1,
            8 => 1,
            10 => 1,
            22 => 1,
            24 => 1,
            26 => 1,
            28 => 1,
            31 => 1,
            32 => 1,
            36 => 1,
            38 => 1
        ];
    }
}
