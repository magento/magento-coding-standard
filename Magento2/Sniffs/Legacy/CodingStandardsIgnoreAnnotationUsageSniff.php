<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magento2\Sniffs\Legacy;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

class CodingStandardsIgnoreAnnotationUsageSniff implements Sniff
{
    private const CODING_STANDARDS_IGNORE_FILE = '@codingStandardsIgnoreFile';

    private const WARNING_CODE = self::CODING_STANDARDS_IGNORE_FILE . ' annotation must be avoided. ';

    private const WARNING_MESSAGE =
        self::WARNING_CODE
        . 'Use codingStandardsIgnoreStart/codingStandardsIgnoreEnd to suppress code fragment '
        . 'or use codingStandardsIgnoreLine to suppress line. ';

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
        $content = $phpcsFile->getTokensAsString($stackPtr, 999999);

        if (strpos($content, self::CODING_STANDARDS_IGNORE_FILE) !== false) {
            $phpcsFile->addWarning(
                self::WARNING_MESSAGE . $phpcsFile->getFilename(),
                $stackPtr,
                self::WARNING_CODE
            );
        }
    }
}
