<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types = 1);

namespace Magento2\Sniffs\Legacy;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

class CopyrightAnotherExtensionsFilesSniff implements Sniff
{
    private const WARNING_CODE = 'FoundCopyrightMissingOrWrongFormat';

    private const COPYRIGHT_MAGENTO_TEXT = 'Copyright © Magento, Inc. All rights reserved.';
    private const COPYRIGHT_ADOBE = '/Copyright \d+ Adobe/';
    
    /**
     * @inheritDoc
     */
    public function register(): array
    {
        return [
            T_INLINE_HTML
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
        
        $fileText = $phpcsFile->getTokensAsString($stackPtr, count($phpcsFile->getTokens()));
        $adobeCopyrightFound = preg_match(self::COPYRIGHT_ADOBE, $fileText);

        if (strpos($fileText, self::COPYRIGHT_MAGENTO_TEXT) !== false || $adobeCopyrightFound) {
            return;
        }

        $phpcsFile->addWarningOnLine(
            'Copyright is missing or has wrong format',
            null,
            self::WARNING_CODE
        );
    }
}
