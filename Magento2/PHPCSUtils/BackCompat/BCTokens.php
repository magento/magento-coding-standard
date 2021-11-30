<?php
/**
 * PHPCSUtils, utility functions and classes for PHP_CodeSniffer sniff developers.
 *
 * @package   PHPCSUtils
 * @copyright 2019-2020 PHPCSUtils Contributors
 * @license   https://opensource.org/licenses/LGPL-3.0 LGPL3
 * @link      https://github.com/PHPCSStandards/PHPCSUtils
 */

namespace PHPCSUtils\BackCompat;

use PHP_CodeSniffer\Util\Tokens;

/**
 * Token arrays related utility methods.
 *
 * PHPCS provides a number of static token arrays in the {@see \PHP_CodeSniffer\Util\Tokens}
 * class.
 * Some of these token arrays will not be available in older PHPCS versions.
 * Some will not contain the same set of tokens across PHPCS versions.
 *
 * This class is a compatibility layer to allow for retrieving these token arrays
 * with a consistent token content across PHPCS versions.
 * The one caveat is that the token constants do need to be available.
 *
 * Recommended usage:
 * Only use the methods in this class when needed. I.e. when your sniff unit tests indicate
 * a PHPCS cross-version compatibility issue related to inconsistent token arrays.
 *
 * All PHPCS token arrays are supported, though only a limited number of them are different
 * across PHPCS versions.
 *
 * The names of the PHPCS native token arrays translate one-on-one to the methods in this class:
 * - `PHP_CodeSniffer\Util\Tokens::$emptyTokens` => `PHPCSUtils\BackCompat\BCTokens::emptyTokens()`
 * - `PHP_CodeSniffer\Util\Tokens::$operators`   => `PHPCSUtils\BackCompat\BCTokens::operators()`
 * - ... etc
 *
 * The order of the tokens in the arrays may differ between the PHPCS native token arrays and
 * the token arrays returned by this class.
 *
 * @since 1.0.0
 *
 * @method static array blockOpeners()     Tokens that open code blocks.
 * @method static array booleanOperators() Tokens that perform boolean operations.
 * @method static array bracketTokens()    Tokens that represent brackets and parenthesis.
 * @method static array castTokens()       Tokens that represent type casting.
 * @method static array commentTokens()    Tokens that are comments.
 * @method static array emptyTokens()      Tokens that don't represent code.
 * @method static array equalityTokens()   Tokens that represent equality comparisons.
 * @method static array heredocTokens()    Tokens that make up a heredoc string.
 * @method static array includeTokens()    Tokens that include files.
 * @method static array methodPrefixes()   Tokens that can prefix a method name.
 * @method static array scopeModifiers()   Tokens that represent scope modifiers.
 * @method static array scopeOpeners()     Tokens that are allowed to open scopes.
 * @method static array stringTokens()     Tokens that represent strings.
 *                                         Note that `T_STRINGS` are NOT represented in this list as this list
 *                                         is about _text_ strings.
 */
class BCTokens
{

    /**
     * Token types that are comments containing PHPCS instructions.
     *
     * @since 1.0.0
     * @since 1.0.0-alpha3 Visibility changed from `protected` to `private`.
     *
     * @var string[]
     */
    private static $phpcsCommentTokensTypes = [
        'T_PHPCS_ENABLE',
        'T_PHPCS_DISABLE',
        'T_PHPCS_SET',
        'T_PHPCS_IGNORE',
        'T_PHPCS_IGNORE_FILE',
    ];

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
     * Tokens that represent text strings.
     *
     * @since 1.0.0
     * @since 1.0.0-alpha3 Visibility changed from `protected` to `private`.
     *
     * @var array <int|string> => <int|string>
     */
    private static $textStringTokens = [
        \T_CONSTANT_ENCAPSED_STRING => \T_CONSTANT_ENCAPSED_STRING,
        \T_DOUBLE_QUOTED_STRING     => \T_DOUBLE_QUOTED_STRING,
        \T_INLINE_HTML              => \T_INLINE_HTML,
        \T_HEREDOC                  => \T_HEREDOC,
        \T_NOWDOC                   => \T_NOWDOC,
    ];

    /**
     * Handle calls to (undeclared) methods for token arrays which haven't received any
     * changes since PHPCS 2.6.0.
     *
     * @since 1.0.0
     *
     * @param string $name The name of the method which has been called.
     * @param array  $args Any arguments passed to the method.
     *                     Unused as none of the methods take arguments.
     *
     * @return array <int|string> => <int|string> Token array
     */
    public static function __callStatic($name, $args)
    {
        if (isset(Tokens::${$name})) {
            return Tokens::${$name};
        }

        // Default to an empty array.
        return [];
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

    /**
     * Tokens that represent comparison operators.
     *
     * Retrieve the PHPCS comparison tokens array in a cross-version compatible manner.
     *
     * Changelog for the PHPCS native array:
     * - Introduced in PHPCS 0.5.0.
     * - PHPCS 2.9.0: The PHP 7.0 `T_COALESCE` token was added to the array.
     *                The `T_COALESCE` token was introduced in PHPCS 2.6.1.
     * - PHPCS 2.9.0: The PHP 7.0 `T_SPACESHIP` token was added to the array.
     *                The `T_SPACESHIP` token was introduced in PHPCS 2.5.1.
     *
     * @see \PHP_CodeSniffer\Util\Tokens::$comparisonTokens Original array.
     *
     * @since 1.0.0
     *
     * @return array <int|string> => <int|string> Token array.
     */
    public static function comparisonTokens()
    {
        $tokens = Tokens::$comparisonTokens + [\T_SPACESHIP => \T_SPACESHIP];

        if (\defined('T_COALESCE')) {
            $tokens[\T_COALESCE] = \T_COALESCE;
        }

        return $tokens;
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
     * Tokens that perform operations.
     *
     * Retrieve the PHPCS operator tokens array in a cross-version compatible manner.
     *
     * Changelog for the PHPCS native array:
     * - Introduced in PHPCS 0.0.5.
     * - PHPCS 2.6.1: The PHP 7.0 `T_COALESCE` token was backfilled and added to the array.
     * - PHPCS 2.8.1: The PHP 7.4 `T_COALESCE_EQUAL` token was backfilled and (incorrectly)
     *                added to the array.
     * - PHPCS 2.9.0: The `T_COALESCE_EQUAL` token was removed from the array.
     *
     * @see \PHP_CodeSniffer\Util\Tokens::$operators Original array.
     *
     * @since 1.0.0
     *
     * @return array <int|string> => <int|string> Token array.
     */
    public static function operators()
    {
        $tokens = Tokens::$operators;

        /*
         * The `T_COALESCE` token may be available pre-PHPCS 2.6.1 depending on the PHP version
         * used to run PHPCS.
         */
        if (\defined('T_COALESCE')) {
            $tokens[\T_COALESCE] = \T_COALESCE;
        }

        if (\defined('T_COALESCE_EQUAL')) {
            unset($tokens[\T_COALESCE_EQUAL]);
        }

        return $tokens;
    }

    /**
     * Token types that open parentheses.
     *
     * Retrieve the PHPCS parenthesis openers tokens array in a cross-version compatible manner.
     *
     * Changelog for the PHPCS native array:
     * - Introduced in PHPCS 0.0.5.
     * - PHPCS 3.5.0: `T_LIST` and `T_ANON_CLASS` added to the array.
     *
     * Note: While `T_LIST` and `T_ANON_CLASS` will be included in the return value for this
     * method, the associated parentheses will not have the `'parenthesis_owner'` index set
     * until PHPCS 3.5.0. Use the {@see \PHPCSUtils\Utils\Parentheses::getOwner()}
     * or {@see \PHPCSUtils\Utils\Parentheses::hasOwner()} methods if you need to check for
     * a `T_LIST` or `T_ANON_CLASS` parentheses owner.
     *
     * @see \PHP_CodeSniffer\Util\Tokens::$parenthesisOpeners Original array.
     * @see \PHPCSUtils\Utils\Parentheses                     Class holding utility methods for
     *                                                        working with the `'parenthesis_...'`
     *                                                        index keys in a token array.
     *
     * @since 1.0.0
     *
     * @return array <int|string> => <int|string> Token array.
     */
    public static function parenthesisOpeners()
    {
        $tokens                = Tokens::$parenthesisOpeners;
        $tokens[\T_LIST]       = \T_LIST;
        $tokens[\T_ANON_CLASS] = \T_ANON_CLASS;

        return $tokens;
    }

    /**
     * Tokens that are comments containing PHPCS instructions.
     *
     * Retrieve the PHPCS comment tokens array in a cross-version compatible manner.
     *
     * Changelog for the PHPCS native array:
     * - Introduced in PHPCS 3.2.3. The PHPCS comment tokens, however, were introduced in
     *   PHPCS 3.2.0.
     *
     * @see \PHP_CodeSniffer\Util\Tokens::$phpcsCommentTokens Original array.
     *
     * @since 1.0.0
     *
     * @return array <string> => <string> Token array or an empty array for PHPCS
     *                                    versions in which the PHPCS native annotation
     *                                    tokens did not exist yet.
     */
    public static function phpcsCommentTokens()
    {
        static $tokenArray = [];

        if (isset(Tokens::$phpcsCommentTokens)) {
            return Tokens::$phpcsCommentTokens;
        }

        if (\defined('T_PHPCS_IGNORE')) {
            // PHPCS 3.2.0 - 3.2.2.
            if (empty($tokenArray)) {
                foreach (self::$phpcsCommentTokensTypes as $type) {
                    $tokenArray[\constant($type)] = \constant($type);
                }
            }

            return $tokenArray;
        }

        return [];
    }

    /**
     * Tokens that represent text strings.
     *
     * Retrieve the PHPCS text string tokens array in a cross-version compatible manner.
     *
     * Changelog for the PHPCS native array:
     * - Introduced in PHPCS 2.9.0.
     *
     * @see \PHP_CodeSniffer\Util\Tokens::$textStringTokens Original array.
     *
     * @since 1.0.0
     *
     * @return array <int|string> => <int|string> Token array.
     */
    public static function textStringTokens()
    {
        if (isset(Tokens::$textStringTokens)) {
            return Tokens::$textStringTokens;
        }

        return self::$textStringTokens;
    }

    /**
     * Tokens that represent the names of called functions.
     *
     * Retrieve the PHPCS function name tokens array in a cross-version compatible manner.
     *
     * Changelog for the PHPCS native array:
     * - Introduced in PHPCS 2.3.3.
     * - PHPCS 3.1.0: `T_SELF` and `T_STATIC` added to the array.
     *
     * @see \PHP_CodeSniffer\Util\Tokens::$functionNameTokens Original array.
     *
     * @since 1.0.0
     *
     * @return array <int|string> => <int|string> Token array.
     */
    public static function functionNameTokens()
    {
        $tokens            = Tokens::$functionNameTokens;
        $tokens[\T_SELF]   = \T_SELF;
        $tokens[\T_STATIC] = \T_STATIC;

        return $tokens;
    }

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
        if (isset(Tokens::$ooScopeTokens)) {
            return Tokens::$ooScopeTokens;
        }

        return self::$ooScopeTokens;
    }
}
