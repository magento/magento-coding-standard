<?php
/**
 * Copyright © Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento2\Tests\Html;

use PHP_CodeSniffer\Tests\Standards\AbstractSniffUnitTest;

class HtmlClosingVoidTagsUnitTest extends AbstractSniffUnitTest
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
            1 => 2,
            10 => 1,
            11 => 1,
            14 => 1,
            15 => 1,
            18 => 1,
            21 => 1,
            22 => 1,
            23 => 1,
            24 => 1,
            32 => 1,
            33 => 1,
            35 => 1,
            36 => 1,
            38 => 1,
            39 => 1,
            40 => 1,
        ];
    }
}
