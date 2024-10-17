<?php
/**
 * Copyright 2021 Adobe
 * All Rights Reserved.
 */
namespace Magento2\Sniffs\Html;

use PHP_CodeSniffer\Sniffs\Sniff;
use PHP_CodeSniffer\Files\File;

/**
 * Sniffing improper HTML bindings.
 */
class HtmlCollapsibleAttributeSniff implements Sniff
{
    /**
     * @inheritDoc
     */
    public function register()
    {
        return [T_INLINE_HTML];
    }

    /**
     * Detect use of data attributes used by older version of bootstrap collapse
     *
     * Use new attributes in https://getbootstrap.com/docs/5.0/components/collapse/
     *
     * @param File $phpcsFile
     * @param int $stackPtr
     * @return int|void
     */
    public function process(File $phpcsFile, $stackPtr)
    {
        if ($stackPtr !== 0) {
            return;
        }
        $html = $phpcsFile->getTokensAsString($stackPtr, count($phpcsFile->getTokens()));

        if (empty($html)) {
            return;
        }

        $pattern = '$<\w+.*?\s*(?=.*?\s*data-toggle="collapse")[^>]*?>.*?$';
        if (preg_match_all($pattern, $html, $matches, PREG_SET_ORDER)) {
            foreach ($matches as $match) {
                $phpcsFile->addError(
                    'Collapsible attributes data-toggle and data-target need to be updated to ' .
                    'data-bs-toggle and data-bs-target'
                    . ' - "' . $match[0]  . PHP_EOL,
                    null,
                    'HtmlCollapsibleAttribute'
                );
            }
        }
    }
}
