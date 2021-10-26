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
    private const WRONG_PREFIXES = [
        'ObsoleteInstallScript' => [
            'pattern' => 'install-',
            'message' => 'Install scripts are obsolete. '
                . 'Please use declarative schema approach in module\'s etc/db_schema.xml file',
        ],
        'ObsoleteInstallSchemaScript' => [
            'pattern' => 'InstallSchema',
            'message' => 'InstallSchema scripts are obsolete. '
                . 'Please use declarative schema approach in module\'s etc/db_schema.xml file',
        ],
        'ObsoleteInstallDataScript' => [
            'pattern' => 'InstallData',
            'message' => 'InstallData scripts are obsolete. '
                . 'Please use data patches approach in module\'s Setup/Patch/Data dir',
        ],
        'ObsoleteDataInstallScript' => [
            'pattern' => 'data-install-',
            'message' => 'Install scripts are obsolete. Please create class InstallData in module\'s Setup folder',
        ],
        'ObsoleteUpgradeScript' => [
            'pattern' => 'upgrade-',
            'message' => 'Upgrade scripts are obsolete. '
                . 'Please use declarative schema approach in module\'s etc/db_schema.xml file',
        ],
        'ObsoleteUpgradeSchemaScript' => [
            'pattern' => 'UpgradeSchema',
            'message' => 'UpgradeSchema scripts are obsolete. '
                . 'Please use declarative schema approach in module\'s etc/db_schema.xml file',
        ],
        'ObsoleteUpgradeDataScript' => [
            'pattern' => 'UpgradeData',
            'message' => 'UpgradeData scripts are obsolete. '
                . 'Please use data patches approach in module\'s Setup/Patch/Data dir',
        ],
        'ObsoleteDataUpgradeScript' => [
            'pattern' => 'data-upgrade',
            'message' => 'Upgrade scripts are obsolete. '
                . 'Please use data patches approach in module\'s Setup/Patch/Data dir',
        ],
        'ObsoleteRecurringScript' => [
            'pattern' => 'recurring',
            'message' => 'Recurring scripts are obsolete. Please create class Recurring in module\'s Setup folder'
        ]
    ];

    /**
     * @var string[]
     */
    private const INVALID_DIRECTORIES_ERROR_CODES = [
        'data' => 'DataInvalidDirectory',
        'sql' => 'SqlInvalidDirectory'
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

        foreach (self::WRONG_PREFIXES as $code => $data) {
            if (strpos($fileInfo->getFilename(), $data['pattern']) === 0) {
                $phpcsFile->addError($data['message'], 0, $code);
            }
        }

        $folders = array_filter(explode('/', $fileInfo->getPath()));
        $folderName = array_pop($folders);

        if ($folderName === 'data' || $folderName === 'sql') {
            $phpcsFile->addError(
                $fileInfo->getFilename()." is in an invalid directory ".$fileInfo->getPath().":\n"
                . "- Create a data patch within module's Setup/Patch/Data folder for data upgrades.\n"
                . "- Use declarative schema approach in module's etc/db_schema.xml file for schema changes.",
                0,
                self::INVALID_DIRECTORIES_ERROR_CODES[$folderName]
            );
        }
    }
}
