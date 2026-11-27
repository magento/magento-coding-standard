<?php
/**
 * Copyright 2026 Adobe
 * All Rights Reserved.
 */
declare(strict_types=1);

namespace Magento2\Tests\Security;

use PHP_CodeSniffer\Tests\Standards\AbstractSniffUnitTest;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class AdminhtmlControllerContextUnitTest extends AbstractSniffUnitTest
{
    /**
     * @inheritdoc
     */
    protected function getTestFiles($testFileBase): array
    {
        $testFiles = [];
        $files = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator(__DIR__ . '/_files/AdminhtmlController', RecursiveDirectoryIterator::SKIP_DOTS)
        );
        foreach ($files as $file) {
            if ($file->getExtension() === 'inc') {
                $testFiles[] = $file->getPathname();
            }
        }
        sort($testFiles);

        return $testFiles;
    }

    /**
     * @inheritdoc
     */
    public function getErrorList($testFile = '')
    {
        $errors = [
            'FrameworkContextFqcn.inc' => [8 => 1],
            'FrameworkContextImport.inc' => [11 => 1],
            'FrameworkParent.inc' => [14 => 1],
            'InvalidContext.inc' => [12 => 1, 22 => 1, 32 => 1],
        ];

        return $errors[$testFile] ?? [];
    }

    /**
     * @inheritdoc
     */
    public function getWarningList($testFile = '')
    {
        return [];
    }
}
