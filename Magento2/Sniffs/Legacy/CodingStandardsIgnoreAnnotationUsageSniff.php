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

    private const WARNING_CODE = 'avoidAnnotation';

    private const WARNING_MESSAGE = '@codingStandardsIgnoreFile annotation must be avoided. '
        . 'Use codingStandardsIgnoreStart/codingStandardsIgnoreEnd to suppress code fragment '
        . 'or use codingStandardsIgnoreLine to suppress line. ';

    /**
     * @inheritDoc
     */
    public function register(): array
    {
        return [
            T_COMMENT
        ];
    }

    /**
     * @inheritDoc
     */
    public function process(File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();

        if (strpos($tokens[$stackPtr - 1]['content'], self::CODING_STANDARDS_IGNORE_FILE) !== false) {
            $phpcsFile->addWarning(
                self::WARNING_MESSAGE . $phpcsFile->getFilename(),
                $stackPtr,
                self::WARNING_CODE
            );
        }
    }
}
