<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento2\Tests\Legacy;

use PHP_CodeSniffer\Tests\Standards\AbstractSniffUnitTest;

class ClassReferencesInConfigurationFilesUnitTest extends AbstractSniffUnitTest
{
    /**
     * @inheritdoc
     */
    public function getErrorList($testFile = '')
    {
        if ($testFile === 'ClassReferencesInConfigurationFilesUnitTest.1.xml') {
            return [
                22 => 1,
                40 => 1,
            ];
        }
        if ($testFile === 'ClassReferencesInConfigurationFilesUnitTest.2.xml') {
            return [
                22 => 1,
                42 => 1,
            ];
        }
        if ($testFile === 'ClassReferencesInConfigurationFilesUnitTest.3.xml') {
            return [
                10 => 1,
            ];
        }
        if ($testFile === 'ClassReferencesInConfigurationFilesUnitTest.4.xml') {
            return [
                10 => 1,
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
