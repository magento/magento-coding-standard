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

class AdminhtmlControllerAclUnitTest extends AbstractSniffUnitTest
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
            'AbstractActionParent.inc' => [11 => 1],
            'AdminResource.inc' => [6 => 1, 24 => 1],
            'CoreAbstractWithoutAclChild.inc' => [4 => 1],
            'FullyQualifiedFrameworkParent.inc' => [4 => 1],
            'MissingParent.inc' => [4 => 1],
            'MultipleClasses.inc' => [25 => 1],
            'UnrelatedParent.inc' => [4 => 1, 8 => 1],
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
