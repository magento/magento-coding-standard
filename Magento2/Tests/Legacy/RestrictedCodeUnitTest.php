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

class RestrictedCodeUnitTest extends AbstractSniffUnitTest
{

    /**
     * @inheritdoc
     */
    protected function getTestFiles($testFileBase): array
    {
        $testFiles = [];

        $dir = __DIR__.'/_files/RestrictedCodeUnitTest';
        $di  = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));

        /**
         * @var DirectoryIterator $file
         */
        foreach ($di as $file) {
            if ($file->isDir()) {
                continue;
            }
            $testFiles[] = $file->getPathname();
        }

        // Put them in order.
        sort($testFiles);

        return $testFiles;
    }

    /**
     * @inheritdoc
     */
    public function getErrorList($testFile = '')
    {
        if ($testFile === 'FileWithRestrictedClass.inc') {
            return [
                5 => 1,
            ];
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
