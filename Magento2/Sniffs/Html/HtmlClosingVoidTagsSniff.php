<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento2\Sniffs\Html;

use PHP_CodeSniffer\Sniffs\Sniff;
use PHP_CodeSniffer\Files\File;

/**
 * Sniff for void closing tags.
 */
class HtmlClosingVoidTagsSniff extends HtmlSelfClosingTagsSniff implements Sniff
{
    /**
     * String representation of warning.
     *
     * @var string
     */
    private const WARNING_MESSAGE =
        'Avoid using closing slash with void tags, this can lead to unexpected behavior - "%s"';

    /**
     * Warning violation code.
     *
     * @var string
     */
    private const WARNING_CODE = 'HtmlClosingVoidElements';

    /**
     * Detect use of self-closing tag with void html element.
     *
     * @param File $phpcsFile
     * @param int $stackPtr
     * @return void
     */
    public function process(File $phpcsFile, $stackPtr): void
    {
        if ($stackPtr !== 0) {
            return;
        }
        $html = $phpcsFile->getTokensAsString($stackPtr, count($phpcsFile->getTokens()));

        if (empty($html)) {
            return;
        }

        if (preg_match_all('$<(\w{2,})\s?[^<]*\/>$', $html, $matches, PREG_SET_ORDER)) {
            foreach ($matches as $match) {
                if (in_array($match[1], self::HTML_VOID_ELEMENTS)) {
                    $ptr = $this->findPointer($phpcsFile, $match[0]);
                    $fix = $phpcsFile->addFixableWarning(
                        sprintf(self::WARNING_MESSAGE, $match[0]),
                        $ptr,
                        self::WARNING_CODE
                    );

                    if ($fix) {
                        $token = $phpcsFile->getTokens()[$ptr];
                        $original = $token['content'];
                        $replacement = str_replace(' />', '>', $original);
                        $replacement = str_replace('/>', '>', $replacement);

                        if (preg_match('{^\s* />}', $original)) {
                            $replacement = ' ' . $replacement;
                        }

                        $phpcsFile->fixer->replaceToken($ptr, $replacement);
                    }
                }
            }
        }
    }
}
