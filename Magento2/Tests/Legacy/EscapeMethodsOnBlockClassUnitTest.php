<?php

/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magento2\Tests\Legacy;

use PHP_CodeSniffer\Tests\Standards\AbstractSniffUnitTest;

class EscapeMethodsOnBlockClassUnitTest extends AbstractSniffUnitTest
{
    protected function getErrorList()
    {
        return [];
    }

    protected function getWarningList()
    {
        return [
            19 => 1,
            21 => 1,
            22 => 1,
            23 => 1,
            25 => 1,
            26 => 1,
            27 => 1,
            31 => 1,
            40 => 1,
            45 => 1,
            47 => 1,
            50 => 1,
            57 => 1,
            58 => 1,
            59 => 1,
            61 => 1,
            64 => 1,
            66 => 1,
            68 => 1,
            70 => 1,
            72 => 1,
        ];
    }
}
