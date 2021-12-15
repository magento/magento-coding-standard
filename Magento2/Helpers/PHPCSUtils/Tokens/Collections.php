<?php
/**
 * PHPCSUtils, utility functions and classes for PHP_CodeSniffer sniff developers.
 *
 * @package   PHPCSUtils
 * @copyright 2019-2020 PHPCSUtils Contributors
 * @license   https://opensource.org/licenses/LGPL-3.0 LGPL3
 * @link      https://github.com/PHPCSStandards/PHPCSUtils
 */

namespace Magento2\Helpers\PHPCSUtils\Tokens;

/**
 * Collections of related tokens as often used and needed for sniffs.
 *
 * These are additional "token groups" to compliment the ones available through the PHPCS
 * native {@see \PHP_CodeSniffer\Util\Tokens} class.
 *
 * @see \PHP_CodeSniffer\Util\Tokens    PHPCS native token groups.
 * @see \PHPCSUtils\BackCompat\BCTokens Backward compatible version of the PHPCS native token groups.
 *
 * @since 1.0.0
 */
class Collections
{
    /**
     * Tokens for the PHP magic constants.
     *
     * @link https://www.php.net/language.constants.predefined PHP Manual on magic constants
     *
     * @since 1.0.0-alpha3
     *
     * @var array <int|string> => <int|string>
     */
    public static $magicConstants = [
        \T_CLASS_C  => \T_CLASS_C,
        \T_DIR      => \T_DIR,
        \T_FILE     => \T_FILE,
        \T_FUNC_C   => \T_FUNC_C,
        \T_LINE     => \T_LINE,
        \T_METHOD_C => \T_METHOD_C,
        \T_NS_C     => \T_NS_C,
        \T_TRAIT_C  => \T_TRAIT_C,
    ];

    /**
     * Object operators.
     *
     * @since 1.0.0-alpha3
     *
     * @var array <int> => <int>
     */
    public static $objectOperators = [
        \T_OBJECT_OPERATOR => \T_OBJECT_OPERATOR,
        \T_DOUBLE_COLON    => \T_DOUBLE_COLON,
    ];

    /**
     * Tokens types used for "forwarding" calls within OO structures.
     *
     * @link https://www.php.net/language.oop5.paamayim-nekudotayim PHP Manual on OO forwarding calls
     *
     * @since 1.0.0-alpha3
     *
     * @var array <int|string> => <int|string>
     */
    public static $OOHierarchyKeywords = [
        \T_PARENT => \T_PARENT,
        \T_SELF   => \T_SELF,
        \T_STATIC => \T_STATIC,
    ];

    /**
     * List of tokens which represent "closed" scopes.
     *
     * I.e. anything declared within that scope - except for other closed scopes - is
     * outside of the global namespace.
     *
     * This list doesn't contain the `T_NAMESPACE` token on purpose as variables declared
     * within a namespace scope are still global and not limited to that namespace.
     *
     * @since 1.0.0
     *
     * @var array <int|string> => <int|string>
     */
    public static $closedScopes = [
        \T_CLASS      => \T_CLASS,
        \T_ANON_CLASS => \T_ANON_CLASS,
        \T_INTERFACE  => \T_INTERFACE,
        \T_TRAIT      => \T_TRAIT,
        \T_FUNCTION   => \T_FUNCTION,
        \T_CLOSURE    => \T_CLOSURE,
    ];

    /**
     * OO structures which can use the "extends" keyword.
     *
     * @since 1.0.0
     *
     * @var array <int|string> => <int|string>
     */
    public static $OOCanExtend = [
        \T_CLASS      => \T_CLASS,
        \T_ANON_CLASS => \T_ANON_CLASS,
        \T_INTERFACE  => \T_INTERFACE,
    ];

    /**
     * Tokens which can start a - potentially multi-line - text string.
     *
     * @since 1.0.0
     *
     * @var array <int|string> => <int|string>
     */
    public static $textStingStartTokens = [
        \T_START_HEREDOC            => \T_START_HEREDOC,
        \T_START_NOWDOC             => \T_START_NOWDOC,
        \T_CONSTANT_ENCAPSED_STRING => \T_CONSTANT_ENCAPSED_STRING,
        \T_DOUBLE_QUOTED_STRING     => \T_DOUBLE_QUOTED_STRING,
    ];

    /**
     * Tokens which can represent the arrow function keyword.
     *
     * Note: this is a method, not a property as the `T_FN` token for arrow functions may not exist.
     *
     * @since 1.0.0-alpha2
     *
     * @return array <int|string> => <int|string>
     */
    public static function arrowFunctionTokensBC()
    {
        $tokens = [
            \T_STRING => \T_STRING,
        ];

        if (\defined('T_FN') === true) {
            // PHP 7.4 or PHPCS 3.5.3+.
            $tokens[\T_FN] = \T_FN;
        }

        return $tokens;
    }

    /**
     * Tokens which can represent a keyword which starts a function declaration.
     *
     * Note: this is a method, not a property as the `T_FN` token for arrow functions may not exist.
     *
     * Sister-method to the {@see Collections::functionDeclarationTokensBC()} method.
     * This  method supports PHPCS 3.5.3 and up.
     * The {@see Collections::functionDeclarationTokensBC()} method supports PHPCS 2.6.0 and up.
     *
     * @see \PHPCSUtils\Tokens\Collections::functionDeclarationTokensBC() Related method (PHPCS 2.6.0+).
     *
     * @since 1.0.0-alpha3
     *
     * @return array <int|string> => <int|string>
     */
    public static function functionDeclarationTokens()
    {
        $tokens = [
            \T_FUNCTION => \T_FUNCTION,
            \T_CLOSURE  => \T_CLOSURE,
        ];

        if (\defined('T_FN') === true) {
            // PHP 7.4 or PHPCS 3.5.3+.
            $tokens[\T_FN] = \T_FN;
        }

        return $tokens;
    }

    /**
     * Tokens which can represent a keyword which starts a function declaration.
     *
     * Note: this is a method, not a property as the `T_FN` token for arrow functions may not exist.
     *
     * Sister-method to the {@see Collections::functionDeclarationTokens()} method.
     * The {@see Collections::functionDeclarationTokens()} method supports PHPCS 3.5.3 and up.
     * This method supports PHPCS 2.6.0 and up.
     *
     * Notable difference:
     * - This method accounts for when the `T_FN` token doesn't exist.
     *
     * Note: if this method is used, the {@see \PHPCSUtils\Utils\FunctionDeclarations::isArrowFunction()}
     * method needs to be used on arrow function tokens to verify whether it really is an arrow function
     * declaration or not.
     *
     * It is recommended to use the {@see Collections::functionDeclarationTokens()} method instead of
     * this method if a standard supports does not need to support PHPCS < 3.5.3.
     *
     * @see \PHPCSUtils\Tokens\Collections::functionDeclarationTokens() Related method (PHPCS 3.5.3+).
     * @see \PHPCSUtils\Utils\FunctionDeclarations::isArrowFunction()   Arrow function verification.
     *
     * @since 1.0.0-alpha3
     *
     * @return array <int|string> => <int|string>
     */
    public static function functionDeclarationTokensBC()
    {
        $tokens = [
            \T_FUNCTION => \T_FUNCTION,
            \T_CLOSURE  => \T_CLOSURE,
        ];

        $tokens += self::arrowFunctionTokensBC();

        return $tokens;
    }

    /**
     * The tokens used for "names", be it namespace, OO, function or constant names.
     *
     * Includes the tokens introduced in PHP 8.0 for "Namespaced names as single token" when available.
     *
     * Note: this is a method, not a property as the PHP 8.0 identifier name tokens may not exist.
     *
     * @link https://wiki.php.net/rfc/namespaced_names_as_token
     *
     * @since 1.0.0-alpha4
     *
     * @return array <int|string> => <int|string>
     */
    public static function nameTokens()
    {
        $tokens = [
            \T_STRING => \T_STRING,
        ];

        /*
         * PHP >= 8.0 in combination with PHPCS < 3.5.7 and all PHP versions in combination
         * with PHPCS >= 3.5.7, though when using PHPCS 3.5.7 < 4.0.0, these tokens are
         * not yet in use, i.e. the PHP 8.0 change is "undone" for PHPCS 3.x.
         */
        if (\defined('T_NAME_QUALIFIED') === true) {
            $tokens[\T_NAME_QUALIFIED] = \T_NAME_QUALIFIED;
        }

        if (\defined('T_NAME_FULLY_QUALIFIED') === true) {
            $tokens[\T_NAME_FULLY_QUALIFIED] = \T_NAME_FULLY_QUALIFIED;
        }

        if (\defined('T_NAME_RELATIVE') === true) {
            $tokens[\T_NAME_RELATIVE] = \T_NAME_RELATIVE;
        }

        return $tokens;
    }

    /**
     * Tokens types which can be encountered in a fully, partially or unqualified name.
     *
     * Example:
     * ```php
     * echo namespace\Sub\ClassName::method();
     * ```
     *
     * @since 1.0.0-alpha4
     *
     * @return array <int|string> => <int|string>
     */
    public static function namespacedNameTokens()
    {
        $tokens = [
            \T_NS_SEPARATOR => \T_NS_SEPARATOR,
            \T_NAMESPACE    => \T_NAMESPACE,
        ];

        $tokens += self::nameTokens();

        return $tokens;
    }
    /**
     * Token types which can be encountered in a return type declaration.
     *
     * Note: this is a method, not a property as the `T_TYPE_UNION` token for PHP 8.0 union types may not exist.
     *
     * Sister-method to the {@see Collections::returnTypeTokensBC()} method.
     * This method supports PHPCS 3.3.0 and up.
     * The {@see Collections::returnTypeTokensBC()} method supports PHPCS 2.6.0 and up.
     *
     * Notable differences:
     * - The {@see Collections::returnTypeTokensBC()} method will include the `T_ARRAY_HINT`
     *   and the `T_RETURN_TYPE` tokens when used with PHPCS 2.x and 3.x.
     *   These token constants will no longer exist in PHPCS 4.x.
     *
     * It is recommended to use this method instead of the {@see Collections::returnTypeTokensBC()}
     * method if a standard does not need to support PHPCS < 3.3.0.
     *
     * @see \PHPCSUtils\Tokens\Collections::returnTypeTokensBC() Related method (cross-version).
     *
     * @since 1.0.0-alpha4 This method replaces the {@see Collections::$returnTypeTokens} property.
     * @since 1.0.0-alpha4 Added support for PHP 8.0 union types.
     * @since 1.0.0-alpha4 Added support for PHP 8.0 identifier name tokens.
     * @since 1.0.0-alpha4 Added the T_TYPE_UNION token for union type support in PHPCS > 3.6.0.
     *
     * @return array <int|string> => <int|string>
     */
    public static function returnTypeTokens()
    {
        $tokens = [
            \T_CALLABLE   => \T_CALLABLE,
            \T_SELF       => \T_SELF,
            \T_PARENT     => \T_PARENT,
            \T_STATIC     => \T_STATIC,
            \T_FALSE      => \T_FALSE,      // Union types only.
            \T_NULL       => \T_NULL,       // Union types only.
            \T_ARRAY      => \T_ARRAY,      // Arrow functions PHPCS < 3.5.4 + union types.
            \T_BITWISE_OR => \T_BITWISE_OR, // Union types for PHPCS < 3.6.0.
        ];

        $tokens += self::namespacedNameTokens();

        // PHPCS > 3.6.0: a new token was introduced for the union type separator.
        if (\defined('T_TYPE_UNION') === true) {
            $tokens[\T_TYPE_UNION] = \T_TYPE_UNION;
        }

        return $tokens;
    }

    /**
     * Token types which can be encountered in a return type declaration (cross-version).
     *
     * Sister-method to the {@see Collections::returnTypeTokens()} method.
     * The {@see Collections::returnTypeTokens()} method supports PHPCS 3.3.0 and up.
     * This method supports PHPCS 2.6.0 and up.
     *
     * Notable differences:
     * - This method will include the `T_ARRAY_HINT` and the `T_RETURN_TYPE` tokens when
     *   used with PHPCS 2.x and 3.x.
     *   These token constants will no longer exist in PHPCS 4.x.
     *
     * It is recommended to use the {@see Collections::returnTypeTokens()} method instead of
     * this method if a standard does not need to support PHPCS < 3.3.0.
     *
     * @see \PHPCSUtils\Tokens\Collections::returnTypeTokens() Related method (PHPCS 3.3.0+).
     *
     * @since 1.0.0-alpha3
     * @since 1.0.0-alpha4 Added support for PHP 8.0 union types.
     * @since 1.0.0-alpha4 Added support for PHP 8.0 identifier name tokens.
     *
     * @return array <int|string> => <int|string>
     */
    public static function returnTypeTokensBC()
    {
        $tokens = self::returnTypeTokens();

        /*
         * PHPCS < 4.0. Needed for support of PHPCS 2.4.0 < 3.3.0.
         * For PHPCS 3.3.0+ the constant is no longer used.
         */
        if (\defined('T_RETURN_TYPE') === true) {
            $tokens[\T_RETURN_TYPE] = \T_RETURN_TYPE;
        }

        /*
         * PHPCS < 4.0. Needed for support of PHPCS < 2.8.0 / PHPCS < 3.5.3 for arrow functions.
         * For PHPCS 3.5.3+ the constant is no longer used.
         */
        if (\defined('T_ARRAY_HINT') === true) {
            $tokens[\T_ARRAY_HINT] = \T_ARRAY_HINT;
        }

        return $tokens;
    }
}
