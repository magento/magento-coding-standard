<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types = 1);

namespace Magento2Framework\Sniffs\Header;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

class CopyrightSniff implements Sniff
{
    private const WARNING_CODE = 'FoundCopyrightMissingOrWrongFormat';

    private const COPYRIGHT_MAGENTO_TEXT = 'Copyright © Magento, Inc. All rights reserved.';
    private const COPYRIGHT_ADOBE = '/Copyright \d+ Adobe/';
    private const COPYRIGHT_ADOBE_TEXT = 'ADOBE CONFIDENTIAL';

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

        $positionComment = $phpcsFile->findNext(T_DOC_COMMENT_STRING, $stackPtr);

        if ($positionComment === false) {
            $phpcsFile->addWarning(
                'Copyright is missing',
                $stackPtr,
                self::WARNING_CODE
            );
            return;
        }

        $content = $phpcsFile->getTokens()[$positionComment]['content'];
        $adobeCopyrightFound = preg_match(self::COPYRIGHT_ADOBE, $content);

        if (strpos($content, self::COPYRIGHT_MAGENTO_TEXT) !== false ||
                $adobeCopyrightFound ||
                    strpos($content, self::COPYRIGHT_ADOBE_TEXT) !== false) {
            return;
        }

        $phpcsFile->addWarningOnLine(
            'Copyright is missing or has wrong format',
            $phpcsFile->getTokens()[$positionComment]['line'],
            self::WARNING_CODE
        );
    }
}
