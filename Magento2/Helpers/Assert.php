<?php
/**
 * Copyright 2023 Adobe
 * All Rights Reserved.
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
     * Checks whether it is a built-in function call.
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
        if ($prevPtr !== false) {
            if (isset(Collections::objectOperators()[$tokens[$prevPtr]['code']])
                || $tokens[$prevPtr]['code'] === \T_NEW
            ) {
                return false;
            }

            if ($tokens[$prevPtr]['code'] === \T_NS_SEPARATOR) {
                $prevPrevPr = $phpcsFile->findPrevious(Tokens::$emptyTokens, ($prevPtr - 1), null, true);
                if ($prevPrevPr !== false && \in_array($tokens[$prevPrevPr]['code'], [\T_STRING, \T_NAMESPACE], true)) {
                    return false;
                }
            }
        }

        return true;
    }
}
