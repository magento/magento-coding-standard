<?php
/**
 * Copyright 2026 Adobe
 * All Rights Reserved.
 */
declare(strict_types=1);

namespace Magento2\Tests\Security;

use Magento2\Helpers\AdminhtmlControllerResolver;
use PHP_CodeSniffer\Tests\Standards\AbstractSniffUnitTest;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class AdminhtmlControllerAuthorizationUnitTest extends AbstractSniffUnitTest
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
            'AbstractInvalidBase.inc' => [4 => 1],
            'CoreFrameworkBase.inc' => [4 => 1],
            'CoreFrameworkBaseChild.inc' => [4 => 1],
            'FrameworkParent.inc' => [8 => 1],
            'FullyQualifiedFrameworkParent.inc' => [4 => 1],
            'InvalidBaseChild.inc' => [4 => 1],
            'MissingParent.inc' => [4 => 1],
            'MultipleClasses.inc' => [25 => 1],
            'MultipleNamespaces.inc' => [12 => 1],
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

    public function testWindowsPathIsDetected(): void
    {
        $resolver = new AdminhtmlControllerResolver();

        $this->assertTrue($resolver->isControllerFile('C:\\app\\code\\Vendor\\Module\\Controller\\Adminhtml\\Index.php'));
        $this->assertFalse($resolver->isControllerFile('C:\\app\\code\\Vendor\\Module\\Controller\\Index\\Index.php'));
    }
}
