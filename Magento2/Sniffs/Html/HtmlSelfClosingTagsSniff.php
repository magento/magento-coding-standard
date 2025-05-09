<?php
/**
 * Copyright 2021 Adobe
 * All Rights Reserved.
 */
declare(strict_types=1);

namespace Magento2\Sniffs\Html;

use PHP_CodeSniffer\Sniffs\Sniff;
use PHP_CodeSniffer\Files\File;

/**
 * Sniff for self-closing tags
 */
class HtmlSelfClosingTagsSniff implements Sniff
{
    /**
     * List of void elements
     *
     * https://www.w3.org/TR/html51/syntax.html#writing-html-documents-elements
     *
     * @var string[]
     */
    private $voidElements = [
        'area',
        'base',
        'br',
        'col',
        'embed',
        'hr',
        'img',
        'input',
        'keygen',
        'link',
        'menuitem',
        'meta',
        'param',
        'source',
        'track',
        'wbr',
    ];

    /**
     * @inheritDoc
     */
    public function register()
    {
        return [T_INLINE_HTML];
    }

    /**
     * Detect use of self-closing tag with non-void html element
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

        if (preg_match_all('$<(\w{2,})\s?[^<]*\/>$', $html, $matches, PREG_SET_ORDER)) {
            foreach ($matches as $match) {
                if (!in_array($match[1], $this->voidElements)) {
                    $phpcsFile->addError(
                        'Avoid using self-closing tag with non-void html element'
                        . ' - "' . $match[0]  . PHP_EOL,
                        null,
                        'HtmlSelfClosingNonVoidTag'
                    );
                }
            }
        }
    }
}
