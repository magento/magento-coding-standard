<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento2\Tests\Legacy;

use DirectoryIterator;
use PHP_CodeSniffer\Tests\Standards\AbstractSniffUnitTest;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class PhtmlTemplateUnitTest extends AbstractSniffUnitTest
{
    /**
     * @inheritdoc
     */
    protected function getTestFiles($testFileBase): array
    {
        $testFiles = [];

        $dir = __DIR__.'/_files/PhtmlTemplateUnitTest';
        $di  = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));

        /**
         * @var DirectoryIterator $file
         */
        foreach ($di as $file) {
            if ($file->isDir()) {
                continue;
            }
            $path = $file->getPathname();
            if ($path !== $testFileBase.'php' && substr($path, -5) !== 'fixed' && substr($path, -4) !== '.bak') {
                $testFiles[] = $path;
            }
        }

        // Put them in order.
        sort($testFiles);
        
        return $testFiles;
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
        if ($testFile === 'PhtmlTemplateUnitTest.1.phtml' || $testFile === 'PhtmlTemplateUnitTest.2.phtml') {
            return [
                9 => 1,
                20 => 1,
                23 => 1,
                27 => 1
            ];
        }
        if ($testFile === 'PhtmlTemplateUnitTest.3.phtml') {
            return [
                9 => 1,
                20 => 1,
                23 => 1,
                27 => 1,
            ];
        }
        return [];
    }
}
