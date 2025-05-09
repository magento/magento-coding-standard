<?php
/**
 * Copyright 2022 Adobe
 * All Rights Reserved.
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
        'input',
        'keygen',
        'link',
        'menuitem',
        'meta',
        'param',
        'source',
        'track',
        'wbr'
    ];

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
