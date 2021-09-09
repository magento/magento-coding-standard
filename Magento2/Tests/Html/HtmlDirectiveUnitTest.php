<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento2\Tests\Html;

use PHP_CodeSniffer\Tests\Standards\AbstractSniffUnitTest;

class HtmlDirectiveUnitTest extends AbstractSniffUnitTest
{
    /**
     * @inheritdoc
     */
    public function getErrorList($testFile = '')
    {
        if ($testFile === 'HtmlDirectiveUnitTest.1.inc') {
            return [1 => 20];
        } elseif ($testFile === 'HtmlDirectiveUnitTest.2.inc') {
            return [1 => 1];
        }

        return [];
    }

    /**
     * @inheritdoc
     */
    public function getWarningList()
    {
        return [];
    }
}
