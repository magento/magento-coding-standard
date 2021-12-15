<?php
/**
 * PHPCSUtils, utility functions and classes for PHP_CodeSniffer sniff developers.
 *
 * @package   PHPCSUtils
 * @copyright 2019-2020 PHPCSUtils Contributors
 * @license   https://opensource.org/licenses/LGPL-3.0 LGPL3
 * @link      https://github.com/PHPCSStandards/PHPCSUtils
 */

namespace Magento2\Helpers\PHPCSUtils\Utils;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Util\Tokens;
use Magento2\Helpers\PHPCSUtils\Tokens\Collections;
use Magento2\Helpers\PHPCSUtils\Utils\FunctionDeclarations;

/**
 * Utility functions for use when examining parenthesis tokens and arbitrary tokens wrapped
 * in parentheses.
 *
 * In contrast to PHPCS natively, `isset()`, `unset()`, `empty()`, `exit()`, `die()` and `eval()`
 * will be considered parentheses owners by the functions in this class.
 *
 * @since 1.0.0
 * @since 1.0.0-alpha4 Added support for `isset()`, `unset()`, `empty()`, `exit()`, `die()`
 *                     and `eval()`` as parentheses owners to all applicable functions.
 */
class Parentheses
{

    /**
     * Extra tokens which should be considered parentheses owners.
     *
     * - `T_LIST` and `T_ANON_CLASS` only became parentheses owners in PHPCS 3.5.0.
     * - `T_ISSET`, `T_UNSET`, `T_EMPTY`, `T_EXIT` and `T_EVAL` are not PHPCS native parentheses,
     *    owners, but are considered such for the purposes of this class.
     *    Also {@see https://github.com/squizlabs/PHP_CodeSniffer/issues/3118}.
     *
     * @since 1.0.0-alpha4
     *
     * @var array <int|string> => <int|string>
     */
    private static $extraParenthesesOwners = [
        \T_LIST       => \T_LIST,
        \T_ISSET      => \T_ISSET,
        \T_UNSET      => \T_UNSET,
        \T_EMPTY      => \T_EMPTY,
        \T_EXIT       => \T_EXIT,
        \T_EVAL       => \T_EVAL,
        \T_ANON_CLASS => \T_ANON_CLASS,
        // Work-around: anon classes were, in certain circumstances, tokenized as T_CLASS prior to PHPCS 3.4.0.
        \T_CLASS      => \T_CLASS,
    ];

    /**
     * Get the stack pointer to the parentheses owner of an open/close parenthesis.
     *
     * @since 1.0.0
     * @since 1.0.0-alpha2 Added BC support for PHP 7.4 arrow functions.
     *
     * @param \PHP_CodeSniffer\Files\File $phpcsFile The file where this token was found.
     * @param int                         $stackPtr  The position of `T_OPEN/CLOSE_PARENTHESIS` token.
     *
     * @return int|false Integer stack pointer to the parentheses owner; or `FALSE` if the
     *                   parenthesis does not have a (direct) owner or if the token passed
     *                   was not a parenthesis.
     */
    public static function getOwner(File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();

        if (isset($tokens[$stackPtr]['parenthesis_owner'])) {
            return $tokens[$stackPtr]['parenthesis_owner'];
        }

        /*
         * - `T_FN` was only backfilled in PHPCS 3.5.3/4/5.
         *    - On PHP 7.4 with PHPCS < 3.5.3, T_FN will not yet be a parentheses owner.
         *    - On PHP < 7.4 with PHPCS < 3.5.3, T_FN will be tokenized as T_STRING and not yet be a parentheses owner.
         *
         * {@internal As the 'parenthesis_owner' index is only set on parentheses, we didn't need to do any
         * input validation before, but now we do.}
         */
        if (isset($tokens[$stackPtr]) === false
            || ($tokens[$stackPtr]['code'] !== \T_OPEN_PARENTHESIS
                && $tokens[$stackPtr]['code'] !== \T_CLOSE_PARENTHESIS)
        ) {
            return false;
        }

        if ($tokens[$stackPtr]['code'] === \T_CLOSE_PARENTHESIS) {
            $stackPtr = $tokens[$stackPtr]['parenthesis_opener'];
        }

        $skip                 = Tokens::$emptyTokens;
        $skip[\T_BITWISE_AND] = \T_BITWISE_AND;

        $prevNonEmpty = $phpcsFile->findPrevious($skip, ($stackPtr - 1), null, true);
        if ($prevNonEmpty !== false
            && (isset(self::$extraParenthesesOwners[$tokens[$prevNonEmpty]['code']])
                // Possibly an arrow function.
                || FunctionDeclarations::isArrowFunction($phpcsFile, $prevNonEmpty) === true)
        ) {
            return $prevNonEmpty;
        }

        return false;
    }

    /**
     * Check whether the parenthesis owner of an open/close parenthesis is within a limited
     * set of valid owners.
     *
     * @since 1.0.0
     * @since 1.0.0-alpha2 Added BC support for PHP 7.4 arrow functions.
     *
     * @param \PHP_CodeSniffer\Files\File $phpcsFile   The file where this token was found.
     * @param int                         $stackPtr    The position of `T_OPEN/CLOSE_PARENTHESIS` token.
     * @param int|string|array            $validOwners Array of token constants for the owners
     *                                                 which should be considered valid.
     *
     * @return bool `TRUE` if the owner is within the list of `$validOwners`; `FALSE` if not and
     *              if the parenthesis does not have a (direct) owner.
     */
    public static function isOwnerIn(File $phpcsFile, $stackPtr, $validOwners)
    {
        $owner = self::getOwner($phpcsFile, $stackPtr);
        if ($owner === false) {
            return false;
        }

        $tokens      = $phpcsFile->getTokens();
        $validOwners = (array) $validOwners;

        /*
         * Work around tokenizer bug where anon classes were, in certain circumstances, tokenized
         * as `T_CLASS` prior to PHPCS 3.4.0.
         * As `T_CLASS` is normally not an parenthesis owner, we can safely add it to the array
         * without doing a version check.
         */
        if (\in_array(\T_ANON_CLASS, $validOwners, true)) {
            $validOwners[] = \T_CLASS;
        }

        /*
         * Allow for T_FN token being tokenized as T_STRING before PHPCS 3.5.3.
         */
        if (\defined('T_FN') && \in_array(\T_FN, $validOwners, true)) {
            $validOwners += Collections::arrowFunctionTokensBC();
        }

        return \in_array($tokens[$owner]['code'], $validOwners, true);
    }
}
