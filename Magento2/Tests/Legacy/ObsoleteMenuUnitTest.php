<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento2\Tests\Legacy;

use PHP_CodeSniffer\Tests\Standards\AbstractSniffUnitTest;

class ObsoleteMenuUnitTest extends AbstractSniffUnitTest
{
    /**
     * @inheritdoc
     */
    public function getErrorList(): array
    {
        return [];
    }

    /**
     * @inheritdoc
     */
    public function getWarningList(): array
    {
        return [
            17 => 1,
            20 => 1,
            23 => 1,
            28 => 1,
            31 => 1,
            34 => 1,
            39 => 1,
            42 => 1,
            45 => 1,
            49 => 1
        ];
    }
}
