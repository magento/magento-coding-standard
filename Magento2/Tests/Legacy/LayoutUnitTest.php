<?php
/**
 * Copyright © Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento2\Tests\Legacy;

use PHP_CodeSniffer\Tests\Standards\AbstractSniffUnitTest;

class LayoutUnitTest extends AbstractSniffUnitTest
{
    /**
     * @inheritdoc
     */
    public function getErrorList($testFile = '')
    {
        if ($testFile === 'LayoutUnitTest.1.xml') {
            return [
                13 => 1,
                22 => 1,
                145 => 1,
                148 => 1,
            ];
        }
        if ($testFile === 'LayoutUnitTest.2.xml') {
            return [
                11 => 1,
                28 => 1,
            ];
        }
        if ($testFile === 'LayoutUnitTest.3.xml') {
            return [
                15 => 1,
                18 => 1,
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
