<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types = 1);

namespace Magento2Framework\Sniffs\Header;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

class CopyrightAnotherExtensionsFilesSniff implements Sniff
{
    private const WARNING_CODE = 'FoundCopyrightMissingOrWrongFormat';

    private const COPYRIGHT_MAGENTO_TEXT = 'Copyright © Magento, Inc. All rights reserved.';
    private const COPYRIGHT_ADOBE = '/Copyright \d+ Adobe/';
    private const COPYRIGHT_ADOBE_TEXT = 'ADOBE CONFIDENTIAL';

    /**
     * Defines the tokenizers that this sniff is using.
     *
     * @var array
     */
    public $supportedTokenizers = ['CSS', 'PHP', 'JS'];

    /**
     * @inheritDoc
     */
    public function register(): array
    {
        return [
            T_INLINE_HTML,
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

        $fileText = $phpcsFile->getTokensAsString($stackPtr, count($phpcsFile->getTokens()));

        if (strpos($fileText, self::COPYRIGHT_MAGENTO_TEXT) !== false
            || preg_match(self::COPYRIGHT_ADOBE, $fileText)
                || strpos($fileText, self::COPYRIGHT_ADOBE_TEXT) !== false
        ) {
            return;
        }

        $phpcsFile->addWarningOnLine(
            'Copyright is missing or has wrong format',
            null,
            self::WARNING_CODE
        );
    }
}
