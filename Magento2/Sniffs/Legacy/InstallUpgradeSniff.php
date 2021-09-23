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

        if (strpos($fileInfo->getFilename(), 'install-') === 0) {
            $phpcsFile->addError(
                'Install scripts are obsolete. '
                . 'Please use declarative schema approach in module\'s etc/db_schema.xml file',
                0,
                self::ERROR_CODE
            );
        }

        if (strpos($fileInfo->getFilename(), 'InstallSchema') === 0) {
            $phpcsFile->addError(
                'InstallSchema scripts are obsolete. '
                . 'Please use declarative schema approach in module\'s etc/db_schema.xml file',
                0,
                self::ERROR_CODE
            );
        }

        if (strpos($fileInfo->getFilename(), 'InstallData') === 0) {
            $phpcsFile->addError(
                'InstallData scripts are obsolete. '
                . 'Please use data patches approach in module\'s Setup/Patch/Data dir',
                0,
                self::ERROR_CODE
            );
        }

        if (strpos($fileInfo->getFilename(), 'data-install-') === 0) {
            $phpcsFile->addError(
                'Install scripts are obsolete. Please create class InstallData in module\'s Setup folder',
                0,
                self::ERROR_CODE
            );
        }

        if (strpos($fileInfo->getFilename(), 'upgrade-') === 0) {
            $phpcsFile->addError(
                'Upgrade scripts are obsolete. '
                . 'Please use declarative schema approach in module\'s etc/db_schema.xml file',
                0,
                self::ERROR_CODE
            );
        }

        if (strpos($fileInfo->getFilename(), 'UpgradeSchema') === 0) {
            $phpcsFile->addError(
                'UpgradeSchema scripts are obsolete. '
                . 'Please use declarative schema approach in module\'s etc/db_schema.xml file',
                0,
                self::ERROR_CODE
            );
        }

        if (strpos($fileInfo->getFilename(), 'UpgradeData') === 0) {
            $phpcsFile->addError(
                'UpgradeSchema scripts are obsolete. '
                . 'Please use data patches approach in module\'s Setup/Patch/Data dir',
                0,
                self::ERROR_CODE
            );
        }

        if (strpos($fileInfo->getFilename(), 'data-upgrade-') === 0) {
            $phpcsFile->addError(
                'Upgrade scripts are obsolete. '
                . 'Please use data patches approach in module\'s Setup/Patch/Data dir',
                0,
                self::ERROR_CODE
            );
        }

        if (strpos($fileInfo->getFilename(), 'recurring') === 0) {
            $phpcsFile->addError(
                'Recurring scripts are obsolete. Please create class Recurring in module\'s Setup folder',
                0,
                self::ERROR_CODE
            );
        }

        if (preg_match('/(sql|data)/', $fileInfo->getPath()) === 1) {
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
