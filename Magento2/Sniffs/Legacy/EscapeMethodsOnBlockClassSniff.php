<?php

/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Magento2\Sniffs\Legacy;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;
use PHP_CodeSniffer\Util\Tokens;

class EscapeMethodsOnBlockClassSniff implements Sniff
{
    private const ESCAPER_METHODS = [
        'escapeCss' => true,
        'escapeHtml' => true,
        'escapeHtmlAttr' => true,
        'escapeJs' => true,
        'escapeJsQuote' => true,
        'escapeQuote' => true,
        'escapeUrl' => true,
        'escapeXssInUrl' => true,
    ];

    /**
     * @inheritDoc
     */
    public function register()
    {
        return [
            T_OBJECT_OPERATOR,
        ];
    }

    /**
     * @inheritDoc
     */
    public function process(File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();

        if ($stackPtr <= 1 || !isset($tokens[$stackPtr + 2])) {
            return;
        }

        $objectPtr = $stackPtr - 1;
        if ($tokens[$objectPtr]['code'] !== T_VARIABLE) {
            $objectPtr = $phpcsFile->findPrevious(Tokens::$emptyTokens, $objectPtr, null, true);

            if (!$objectPtr) {
                return;
            }
        }

        if ($tokens[$objectPtr]['code'] !== T_VARIABLE
            || $tokens[$objectPtr]['content'] !== '$block'
        ) {
            return;
        }

        $methodPtr = $stackPtr + 1;
        if ($tokens[$methodPtr]['code'] !== T_STRING) {
            $methodPtr = $phpcsFile->findNext(Tokens::$emptyTokens, $methodPtr, null, true);

            if (!$methodPtr) {
                return;
            }
        }

        if ($tokens[$methodPtr]['code'] !== T_STRING
            || !isset(self::ESCAPER_METHODS[$tokens[$methodPtr]['content']])
        ) {
            return;
        }

        $openParenPtr = $methodPtr + 1;
        if ($tokens[$openParenPtr]['code'] !== T_OPEN_PARENTHESIS) {
            $openParenPtr = $phpcsFile->findNext(Tokens::$emptyTokens, $openParenPtr, null, true);

            if (!$openParenPtr) {
                return;
            }
        }

        if ($tokens[$openParenPtr]['code'] !== T_OPEN_PARENTHESIS) {
            return;
        }

        $fix = $phpcsFile->addFixableWarning(
            'Using %s on $block is deprecated. Please use equivalent method on $escaper',
            $methodPtr,
            'Found',
            [
                $tokens[$methodPtr]['content'], // method name
            ]
        );

        if ($fix) {
            $phpcsFile->fixer->replaceToken($objectPtr, '$escaper');
        }
    }
}
