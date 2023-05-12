<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento2\Helpers;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Util\Tokens;
use PHPCSUtils\Tokens\Collections;

/**
 * phpcs:disable Magento2.Functions.StaticFunction.StaticFunction
 */
class Assert
{
    /**
     * Checks whether the function call is a built-in function call.
     *
     * @param File $phpcsFile
     * @param int $stackPtr
     * @return bool
     */
    public static function isBuiltinFunctionCall(File $phpcsFile, int $stackPtr): bool
    {
        $tokens = $phpcsFile->getTokens();
        $nextPtr = $phpcsFile->findNext(Tokens::$emptyTokens, ($stackPtr + 1), null, true);
        if ($nextPtr === false
            || $tokens[$nextPtr]['code'] !== \T_OPEN_PARENTHESIS
            || isset($tokens[$nextPtr]['parenthesis_owner'])
        ) {
            return false;
        }

        $prevPtr = $phpcsFile->findPrevious(Tokens::$emptyTokens, ($stackPtr - 1), null, true);
        $ignorePrevToken = [\T_NEW => true] + Collections::objectOperators();
        if (isset($ignorePrevToken[$tokens[$prevPtr]['code']])) {
            return false;
        }

        if ($tokens[$prevPtr]['code'] === \T_NS_SEPARATOR) {
            $prevPrevToken = $phpcsFile->findPrevious(Tokens::$emptyTokens, ($prevPtr - 1), null, true);
            if ($tokens[$prevPrevToken]['code'] === \T_STRING || $tokens[$prevPrevToken]['code'] === \T_NAMESPACE
            ) {
                return false;
            }
        }

        return true;
    }
}
