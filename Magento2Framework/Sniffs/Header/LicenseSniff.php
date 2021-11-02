<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types = 1);

namespace Magento2Framework\Sniffs\Header;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

class LicenseSniff implements Sniff
{
    /**
     * A list of tokenizers this sniff supports.
     *
     * @var array
     */
    public $supportedTokenizers = ['CSS', 'PHP'];

    private const WARNING_CODE = 'FoundLegacyTextInCopyright';

    private const LEGACY_TEXTS = ['Irubin Consulting Inc', 'DBA Varien', 'Magento Inc'];

    /**
     * @inheritdoc
     */
    public function register()
    {
        return [
            T_DOC_COMMENT_STRING,
            T_INLINE_HTML
        ];
    }

    /**
     * @inheritDoc
     */
    public function process(File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();
        $content = null;

        if ($tokens[$stackPtr]['code'] === T_DOC_COMMENT_STRING) {
            $content = $tokens[$stackPtr]['content'];
        }
        if ($tokens[$stackPtr]['code'] === T_INLINE_HTML) {
            $content = $phpcsFile->getTokensAsString($stackPtr, 1);
        }
        if ($content !== null) {
            $this->checkLicense($content, $stackPtr, $phpcsFile);
        }
    }

    /**
     * Check that the copyright license does not contain legacy text
     *
     * @param string $content
     * @param int $stackPtr
     * @param File $phpcsFile
     */
    private function checkLicense(string $content, int $stackPtr, File $phpcsFile): void
    {
        $commentContent = $content;
        if (stripos($commentContent, 'copyright') === false) {
            return;
        }
        foreach (self::LEGACY_TEXTS as $legacyText) {
            if (stripos($commentContent, $legacyText) !== false) {
                $phpcsFile->addWarning(
                    sprintf("The copyright license contains legacy text: %s.", $legacyText),
                    $stackPtr,
                    self::WARNING_CODE
                );
            }
        }
    }
}
