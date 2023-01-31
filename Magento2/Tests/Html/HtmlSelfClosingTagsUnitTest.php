<?php
/**
 * Copyright © Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento2\Tests\Html;

use PHP_CodeSniffer\Tests\Standards\AbstractSniffUnitTest;

class HtmlSelfClosingTagsUnitTest extends AbstractSniffUnitTest
{
    /**
     * @inheritdoc
     */
    public function getErrorList()
    {
        return [
            33 => 1,
            34 => 1,
            35 => 1,
            36 => 1,
            37 => 1,
            38 => 1,
            39 => 1,
            40 => 1,
            41 => 1,
            42 => 1,
        ];
    }

    /**
     * @inheritdoc
     */
    public function getWarningList()
    {
        return [];
    }
}
