<?php
/**
 * Copyright © Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento2\Tests\Legacy;

use PHP_CodeSniffer\Tests\Standards\AbstractSniffUnitTest;

class WidgetXMLUnitTest extends AbstractSniffUnitTest
{
    /**
     * @inheritdoc
     */
    public function getErrorList($testFile = '')
    {
        if ($testFile === 'WidgetXMLUnitTest.1.xml') {
            return [
                9 => 1,
                12 => 1,
                14 => 1,
            ];
        }
        if ($testFile === 'WidgetXMLUnitTest.2.xml') {
            return [
                9 => 1,
                17 => 1,
                24 => 1,
            ];
        }
        return [];
    }

    /**
     * @inheritdoc
     */
    public function getWarningList($testFile = '')
    {
        return [];
    }
}
