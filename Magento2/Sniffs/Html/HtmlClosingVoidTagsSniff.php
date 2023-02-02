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
class HtmlClosingVoidTagsSniff implements Sniff
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
     * List of void elements.
     *
     * https://html.spec.whatwg.org/multipage/syntax.html#void-elements
     *
     * @var string[]
     */
    private const HTML_VOID_ELEMENTS = [
        'area',
        'base',
        'br',
        'col',
        'embed',
        'hr',
        'img',
        'input',
        'link',
        'meta',
        'source',
        'track',
        'wbr',
    ];

    /** @var int */
    private int $lastPointer = 0;

    /**
     * @inheritdoc
     */
    public function register(): array
    {
        return [T_INLINE_HTML];
    }

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
                    if ($ptr) {
                        $fix = $phpcsFile->addFixableWarning(
                            sprintf(self::WARNING_MESSAGE, $match[0]),
                            $ptr,
                            self::WARNING_CODE
                        );

                        if ($fix) {
                            $token = $phpcsFile->getTokens()[$ptr];
                            $original = $match[0];
                            $replacement = str_replace(' />', '>', $original);
                            $replacement = str_replace('/>', '>', $replacement);
                            $phpcsFile->fixer->replaceToken(
                                $ptr,
                                str_replace($original, $replacement, $token['content'])
                            );
                        }
                    } else {
                        $phpcsFile->addWarning(
                            sprintf(self::WARNING_MESSAGE, $match[0]),
                            null,
                            self::WARNING_CODE
                        );
                    }
                }
            }
        }
    }

    /**
     * Apply a fix for the detected issue
     *
     * @param File $phpcsFile
     * @param string $needle
     * @return int|null
     */
    public function findPointer(File $phpcsFile, string $needle): ?int
    {
        foreach ($phpcsFile->getTokens() as $ptr => $token) {
            if ($ptr < $this->lastPointer) {
                continue;
            }

            if ($token['code'] !== T_INLINE_HTML) {
                continue;
            }

            if (str_contains($token['content'], $needle)) {
                $this->lastPointer = $ptr;
                return $ptr;
            }
        }

        return null;
    }
}
