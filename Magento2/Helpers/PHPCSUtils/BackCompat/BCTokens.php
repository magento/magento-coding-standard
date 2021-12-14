<?php
/**
 * PHPCSUtils, utility functions and classes for PHP_CodeSniffer sniff developers.
 *
 * @package   PHPCSUtils
 * @copyright 2019-2020 PHPCSUtils Contributors
 * @license   https://opensource.org/licenses/LGPL-3.0 LGPL3
 * @link      https://github.com/PHPCSStandards/PHPCSUtils
 */

namespace Magento2\Helpers\PHPCSUtils\BackCompat;

use PHP_CodeSniffer\Util\Tokens;

class BCTokens
{
    /**
     * Tokens that open class and object scopes.
     *
     * @since 1.0.0
     * @since 1.0.0-alpha3 Visibility changed from `protected` to `private`.
     *
     * @var array <int|string> => <int|string>
     */
    private static $ooScopeTokens = [
        \T_CLASS      => \T_CLASS,
        \T_ANON_CLASS => \T_ANON_CLASS,
        \T_INTERFACE  => \T_INTERFACE,
        \T_TRAIT      => \T_TRAIT,
    ];

    /**
     * Tokens that open class and object scopes.
     *
     * Retrieve the OO scope tokens array in a cross-version compatible manner.
     *
     * Changelog for the PHPCS native array:
     * - Introduced in PHPCS 3.1.0.
     *
     * @see \PHP_CodeSniffer\Util\Tokens::$ooScopeTokens Original array.
     *
     * @since 1.0.0
     *
     * @return array <int|string> => <int|string> Token array.
     */
    public static function ooScopeTokens()
    {
        return self::$ooScopeTokens;
    }

    /**
     * Tokens that represent arithmetic operators.
     *
     * Retrieve the PHPCS arithmetic tokens array in a cross-version compatible manner.
     *
     * Changelog for the PHPCS native array:
     * - Introduced in PHPCS 0.5.0.
     * - PHPCS 2.9.0: The PHP 5.6 `T_POW` token was added to the array.
     *                The `T_POW` token was introduced in PHPCS 2.4.0.
     *
     * @see \PHP_CodeSniffer\Util\Tokens::$arithmeticTokens Original array.
     *
     * @since 1.0.0
     *
     * @return array <int|string> => <int|string> Token array or an empty array for PHPCS versions in
     *                         which the PHPCS native comment tokens did not exist yet.
     */
    public static function arithmeticTokens()
    {
        return Tokens::$arithmeticTokens + [\T_POW => \T_POW];
    }

    /**
     * Tokens that represent assignment operators.
     *
     * Retrieve the PHPCS assignment tokens array in a cross-version compatible manner.
     *
     * Changelog for the PHPCS native array:
     * - Introduced in PHPCS 0.0.5.
     * - PHPCS 2.9.0: The PHP 7.4 `T_COALESCE_EQUAL` token was added to the array.
     *                The `T_COALESCE_EQUAL` token was introduced in PHPCS 2.8.1.
     * - PHPCS 3.2.0: The JS `T_ZSR_EQUAL` token was added to the array.
     *                The `T_ZSR_EQUAL` token was introduced in PHPCS 2.8.0.
     *
     * @see \PHP_CodeSniffer\Util\Tokens::$assignmentTokens Original array.
     *
     * @since 1.0.0
     *
     * @return array <int|string> => <int|string> Token array.
     */
    public static function assignmentTokens()
    {
        $tokens = Tokens::$assignmentTokens;

        /*
         * The `T_COALESCE_EQUAL` token may be available pre-PHPCS 2.8.1 depending on
         * the PHP version used to run PHPCS.
         */
        if (\defined('T_COALESCE_EQUAL')) {
            $tokens[\T_COALESCE_EQUAL] = \T_COALESCE_EQUAL;
        }

        if (\defined('T_ZSR_EQUAL')) {
            $tokens[\T_ZSR_EQUAL] = \T_ZSR_EQUAL;
        }

        return $tokens;
    }
}
