<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento2\Tests\Legacy;

use PHP_CodeSniffer\Tests\Standards\AbstractSniffUnitTest;

class ModuleXMLUnitTest extends AbstractSniffUnitTest
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
    public function getWarningList($testFile = '')
    {
        if ($testFile === 'ModuleXMLUnitTest.1.xml') {
            return [
                9 => 2,
            ];
        }
        if ($testFile === 'ModuleXMLUnitTest.2.xml') {
            return [
                9 => 2,
            ];
        }
        if ($testFile === 'ModuleXMLUnitTest.3.xml') {
            return [];
        }
        if ($testFile === 'ModuleXMLUnitTest.4.xml') {
            return [
                9 => 2,
            ];
        }
        return [];
    }
}
