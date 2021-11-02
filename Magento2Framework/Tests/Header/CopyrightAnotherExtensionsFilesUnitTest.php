<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento2Framework\Tests\Header;

use PHP_CodeSniffer\Config;
use PHP_CodeSniffer\Tests\Standards\AbstractSniffUnitTest;

class CopyrightAnotherExtensionsFilesUnitTest extends AbstractSniffUnitTest
{
    /**
     * @inheritDoc
     */
    protected function setUp(): void
    {
        parent::setUp();

        $config = new Config();
        $config->extensions = array_merge(
            $config->extensions,
            [
                'js' => 'PHP'
            ]
        );

        $GLOBALS['PHP_CODESNIFFER_CONFIG'] = $config;
    }

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
        if ($testFile === 'CopyrightAnotherExtensionsFilesUnitTest.5.less') {
            return [
                null => 1,
            ];
        }
        return [];
    }
}
