<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento2\Tests\Legacy;

class CopyrightAnotherExtensionsFilesUnitTest extends AbstractJsSniffUnitTestCase
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
        if ($testFile === 'CopyrightAnotherExtensionsFilesUnitTest.1.xml') {
            return [
                null => 1,
            ];
        }
        if ($testFile === 'CopyrightAnotherExtensionsFilesUnitTest.2.js') {
            return [
                null => 1,
            ];
        }
        if ($testFile === 'CopyrightAnotherExtensionsFilesUnitTest.3.xml') {
            return [];
        }
        if ($testFile === 'CopyrightAnotherExtensionsFilesUnitTest.4.js') {
            return [];
        }
        return [];
    }
}
