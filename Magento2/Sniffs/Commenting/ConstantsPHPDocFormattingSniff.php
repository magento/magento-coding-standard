<?php
/**
 * Copyright © Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento2\Sniffs\Commenting;

use PHP_CodeSniffer\Sniffs\Sniff;
use PHP_CodeSniffer\Files\File;

/**
 * Detects PHPDoc formatting for constants.
 */
class ConstantsPHPDocFormattingSniff implements Sniff
{
    /**
     * @inheritDoc
     */
    public function register()
    {
        return [
            T_CONST,
            T_STRING
        ];
    }

    /**
     * @inheritDoc
     */
    public function process(File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();

        if ($tokens[$stackPtr]['code'] !== T_CONST
            && !($tokens[$stackPtr]['content'] === 'define' && $tokens[$stackPtr + 1]['code'] === T_OPEN_PARENTHESIS)
        ) {
            return;
        }

        $constNamePtr = $phpcsFile->findNext(
            ($tokens[$stackPtr]['code'] === T_CONST) ? T_STRING : T_CONSTANT_ENCAPSED_STRING,
            $stackPtr + 1,
            null,
            false,
            null,
            true
        );
        $constName = strtolower(trim($tokens[$constNamePtr]['content'], " '\""));

        $commentStartPtr = $phpcsFile->findPrevious(T_DOC_COMMENT_OPEN_TAG, $stackPtr - 1, null, false, null, true);
        if ($commentStartPtr === false) {
            return;
        }

        $commentCloserPtr = $tokens[$commentStartPtr]['comment_closer'];
        for ($i = $commentStartPtr; $i <= $commentCloserPtr; $i++) {
            $token = $tokens[$i];

            // Not an interesting string
            if ($token['code'] !== T_DOC_COMMENT_STRING) {
                continue;
            }

            // Comment is the same as constant name
            $docComment = trim(strtolower($token['content']), ',.');
            if ($docComment === $constName) {
                continue;
            }

            // Comment is exactly the same as constant name
            $docComment = str_replace(' ', '_', $docComment);
            if ($docComment === $constName) {
                continue;
            }

            // We have found at lease one meaningful line in comment description
            return;
        }

        $phpcsFile->addWarning(
            'Constants must have short description if they add information beyond what the constant name supplies.',
            $stackPtr,
            'MissingConstantPHPDoc'
        );
    }
}
