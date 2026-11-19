<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento2\Tests\Legacy;

use DirectoryIterator;
use PHP_CodeSniffer\Files\LocalFile;
use PHP_CodeSniffer\Tests\Standards\AbstractSniffUnitTest;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class InstallUpgradeUnitTest extends AbstractSniffUnitTest
{
    /**
     * @var string[]
     */
    private $wrongFileNames = [
        'data-install-.inc',
        'data-upgrade-.inc',
        'install-sample.inc',
        'InstallData.inc',
        'InstallSchema.inc',
        'recurring.inc',
        'upgrade-.inc',
        'UpgradeData.inc',
        'UpgradeSchema.inc',
        'file.inc',
        'file2.inc',
    ];

    /**
     * @var string
     */
    private $currentFile = '';

    /**
     * @inheritdoc
     */
    public function generateFailureMessages(LocalFile $file)
    {
        // getErrorList() only receives the base name, which is not enough to tell patches from obsolete scripts.
        $this->currentFile = $file->getFilename();

        return parent::generateFailureMessages($file);
    }

    /**
     * @inheritdoc
     */
    protected function getTestFiles($testFileBase): array
    {
        $testFiles = [];

        $dir = __DIR__.'/_files/InstallUpgradeUnitTest';
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
    public function getErrorList($testFile = '')
    {
        if (preg_match('#[/\\\\]Setup[/\\\\]Patch[/\\\\](Data|Schema)$#', dirname($this->currentFile)) === 1) {
            return [];
        }
        if (in_array($testFile, $this->wrongFileNames)) {
            return [
                1 => 1
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
