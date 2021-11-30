<?php
/**
 * PHPCSUtils, utility functions and classes for PHP_CodeSniffer sniff developers.
 *
 * @package   PHPCSUtils
 * @copyright 2019-2020 PHPCSUtils Contributors
 * @license   https://opensource.org/licenses/LGPL-3.0 LGPL3
 * @link      https://github.com/PHPCSStandards/PHPCSUtils
 */

namespace PHPCSUtils\Utils;

use PHP_CodeSniffer\Files\File;
use PHPCSUtils\BackCompat\BCTokens;
use PHPCSUtils\Tokens\Collections;
use PHPCSUtils\Utils\Conditions;
use PHPCSUtils\Utils\Parentheses;

/**
 * Utility functions for use when examining token scopes.
 *
 * @since 1.0.0
 */
class Scopes
{

    /**
     * Check whether the direct wrapping scope of a token is within a limited set of
     * acceptable tokens.
     *
     * @since 1.0.0
     *
     * @param \PHP_CodeSniffer\Files\File $phpcsFile   The file where this token was found.
     * @param int                         $stackPtr    The position in the stack of the
     *                                                 token to verify.
     * @param int|string|array            $validScopes Array of token constants representing
     *                                                 the scopes considered valid.
     *
     * @return int|false Integer stack pointer to the valid direct scope; or `FALSE` if
     *                   no valid direct scope was found.
     */
    public static function validDirectScope(File $phpcsFile, $stackPtr, $validScopes)
    {
        $ptr = Conditions::getLastCondition($phpcsFile, $stackPtr);

        if ($ptr !== false) {
            $tokens      = $phpcsFile->getTokens();
            $validScopes = (array) $validScopes;

            if (\in_array($tokens[$ptr]['code'], $validScopes, true) === true) {
                return $ptr;
            }
        }

        return false;
    }

    /**
     * Check whether a T_CONST token is a class/interface constant declaration.
     *
     * @since 1.0.0
     *
     * @param \PHP_CodeSniffer\Files\File $phpcsFile The file where this token was found.
     * @param int                         $stackPtr  The position in the stack of the
     *                                               `T_CONST` token to verify.
     *
     * @return bool
     */
    public static function isOOConstant(File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();

        if (isset($tokens[$stackPtr]) === false || $tokens[$stackPtr]['code'] !== \T_CONST) {
            return false;
        }

        if (self::validDirectScope($phpcsFile, $stackPtr, Collections::$OOConstantScopes) !== false) {
            return true;
        }

        return false;
    }

    /**
     * Check whether a T_VARIABLE token is a class/trait property declaration.
     *
     * @since 1.0.0
     *
     * @param \PHP_CodeSniffer\Files\File $phpcsFile The file where this token was found.
     * @param int                         $stackPtr  The position in the stack of the
     *                                               `T_VARIABLE` token to verify.
     *
     * @return bool
     */
    public static function isOOProperty(File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();

        if (isset($tokens[$stackPtr]) === false || $tokens[$stackPtr]['code'] !== \T_VARIABLE) {
            return false;
        }

        $scopePtr = self::validDirectScope($phpcsFile, $stackPtr, Collections::$OOPropertyScopes);
        if ($scopePtr !== false) {
            // Make sure it's not a method parameter.
            $deepestOpen = Parentheses::getLastOpener($phpcsFile, $stackPtr);
            if ($deepestOpen === false
                || $deepestOpen < $scopePtr
                || Parentheses::isOwnerIn($phpcsFile, $deepestOpen, \T_FUNCTION) === false
            ) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check whether a T_FUNCTION token is a class/interface/trait method declaration.
     *
     * @since 1.0.0
     *
     * @param \PHP_CodeSniffer\Files\File $phpcsFile The file where this token was found.
     * @param int                         $stackPtr  The position in the stack of the
     *                                               `T_FUNCTION` token to verify.
     *
     * @return bool
     */
    public static function isOOMethod(File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();

        if (isset($tokens[$stackPtr]) === false || $tokens[$stackPtr]['code'] !== \T_FUNCTION) {
            return false;
        }

        if (self::validDirectScope($phpcsFile, $stackPtr, BCTokens::ooScopeTokens()) !== false) {
            return true;
        }

        return false;
    }
}
