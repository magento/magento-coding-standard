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
                23 => 1,
                146 => 1,
                149 => 1,
            ];
        }
        if ($testFile === 'LayoutUnitTest.2.xml') {
            return [
                12 => 1,
                29 => 1,
            ];
        }
        if ($testFile === 'LayoutUnitTest.3.xml') {
            return [
                16 => 1,
                19 => 1,
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
