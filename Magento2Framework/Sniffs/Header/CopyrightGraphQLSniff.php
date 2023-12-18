<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types = 1);

namespace Magento2Framework\Sniffs\Header;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

class CopyrightGraphQLSniff implements Sniff
{
    private const WARNING_CODE = 'FoundCopyrightMissingOrWrongFormat';

    private const COPYRIGHT_MAGENTO_TEXT = 'Copyright © Magento, Inc. All rights reserved.';
    private const COPYRIGHT_ADOBE = '/Copyright \d+ Adobe/';
    private const COPYRIGHT_ADOBE_TEXT = 'ADOBE CONFIDENTIAL';

    private const FILE_EXTENSION = 'graphqls';

    /**
     * @var string[]
     */
    public $supportedTokenizers = ['GRAPHQL'];

    /**
     * @inheritdoc
     */
    public function register()
    {
        return [T_OPEN_TAG];
    }

    /**
     * @inheritDoc
     */
    public function process(File $phpcsFile, $stackPtr)
    {
        if ($phpcsFile->findPrevious(T_OPEN_TAG, $stackPtr - 1) !== false) {
            return;
        }

        // @phpcs:ignore Magento2.Functions.DiscouragedFunction.Discouraged
        $content = file_get_contents($phpcsFile->getFilename());

        if (strpos($content, self::COPYRIGHT_MAGENTO_TEXT) !== false
            || preg_match(self::COPYRIGHT_ADOBE, $content)
                || strpos($content, self::COPYRIGHT_ADOBE_TEXT) !== false) {
            return;
        }

        $phpcsFile->addWarningOnLine(
            'Copyright is missing or has wrong format',
            null,
            self::WARNING_CODE
        );
    }
}
