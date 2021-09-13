<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento2\Tests\Legacy;

use PHP_CodeSniffer\Tests\Standards\AbstractSniffUnitTest;

class DiConfigUnitTest extends AbstractSniffUnitTest
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
            12 => 1,
            16 => 1,
            17 => 1,
            18 => 1,
            19 => 1
        ];
    }
}
