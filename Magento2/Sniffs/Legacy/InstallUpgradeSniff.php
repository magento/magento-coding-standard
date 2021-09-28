<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types = 1);

namespace Magento2\Sniffs\Legacy;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;
use SplFileInfo;

class InstallUpgradeSniff implements Sniff
{
    private const ERROR_CODE = 'obsoleteScript';

    /**
     * @var string[]
     */
    private $wrongPrefixes = [
        'install-' => 'Install scripts are obsolete. '
            . 'Please use declarative schema approach in module\'s etc/db_schema.xml file',
        'InstallSchema' => 'InstallSchema scripts are obsolete. '
            . 'Please use declarative schema approach in module\'s etc/db_schema.xml file',
        'InstallData' => 'InstallData scripts are obsolete. '
            . 'Please use data patches approach in module\'s Setup/Patch/Data dir',
        'data-install-' => 'Install scripts are obsolete. Please create class InstallData in module\'s Setup folder',
        'upgrade-' => 'Upgrade scripts are obsolete. '
            . 'Please use declarative schema approach in module\'s etc/db_schema.xml file',
        'UpgradeSchema' => 'UpgradeSchema scripts are obsolete. '
            . 'Please use declarative schema approach in module\'s etc/db_schema.xml file',
        'UpgradeData' => 'UpgradeSchema scripts are obsolete. '
            . 'Please use data patches approach in module\'s Setup/Patch/Data dir',
        'data-upgrade-' => 'Upgrade scripts are obsolete. '
            . 'Please use data patches approach in module\'s Setup/Patch/Data dir',
        'recurring' => 'Recurring scripts are obsolete. Please create class Recurring in module\'s Setup folder',
    ];

    /**
     * @inheritdoc
     */
    public function register(): array
    {
        return [
            T_OPEN_TAG
        ];
    }

    /**
     * @inheritDoc
     */
    public function process(File $phpcsFile, $stackPtr)
    {
        if ($stackPtr > 0) {
            return;
        }
        
        $fileInfo = new SplFileInfo($phpcsFile->getFilename());

        foreach ($this->wrongPrefixes as $prefix => $errorMessage) {
            if (strpos($fileInfo->getFilename(), $prefix) === 0) {
                $phpcsFile->addError($errorMessage, 0, self::ERROR_CODE);
            }
        }

        $folderName = basename($fileInfo->getPath());

        if ($folderName === 'data' || $folderName === 'sql') {
            $phpcsFile->addError(
                $fileInfo->getFilename()." is in an invalid directory ".$fileInfo->getPath().":\n"
                . "- Create a data patch within module's Setup/Patch/Data folder for data upgrades.\n"
                . "- Use declarative schema approach in module's etc/db_schema.xml file for schema changes.",
                0,
                self::ERROR_CODE
            );
        }
    }
}
