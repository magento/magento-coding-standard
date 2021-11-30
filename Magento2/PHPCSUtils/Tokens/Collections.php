<?php
/**
 * PHPCSUtils, utility functions and classes for PHP_CodeSniffer sniff developers.
 *
 * @package   PHPCSUtils
 * @copyright 2019-2020 PHPCSUtils Contributors
 * @license   https://opensource.org/licenses/LGPL-3.0 LGPL3
 * @link      https://github.com/PHPCSStandards/PHPCSUtils
 */

namespace PHPCSUtils\Tokens;

use PHPCSUtils\BackCompat\Helper;

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
     * Control structures which can use the alternative control structure syntax.
     *
     * @since 1.0.0-alpha2
     *
     * @var array <int> => <int>
     */
    public static $alternativeControlStructureSyntaxTokens = [
        \T_IF      => \T_IF,
        \T_ELSEIF  => \T_ELSEIF,
        \T_ELSE    => \T_ELSE,
        \T_FOR     => \T_FOR,
        \T_FOREACH => \T_FOREACH,
        \T_SWITCH  => \T_SWITCH,
        \T_WHILE   => \T_WHILE,
        \T_DECLARE => \T_DECLARE,
    ];

    /**
     * Alternative control structure syntax closer keyword tokens.
     *
     * @since 1.0.0-alpha2
     *
     * @var array <int> => <int>
     */
    public static $alternativeControlStructureSyntaxCloserTokens = [
        \T_ENDIF      => \T_ENDIF,
        \T_ENDFOR     => \T_ENDFOR,
        \T_ENDFOREACH => \T_ENDFOREACH,
        \T_ENDWHILE   => \T_ENDWHILE,
        \T_ENDSWITCH  => \T_ENDSWITCH,
        \T_ENDDECLARE => \T_ENDDECLARE,
    ];

    /**
     * Tokens which are used to create arrays.
     *
     * @see \PHPCSUtils\Tokens\Collections::$shortArrayTokens Related property containing only tokens used
     *                                                        for short arrays.
     *
     * @since 1.0.0
     *
     * @var array <int|string> => <int|string>
     */
    public static $arrayTokens = [
        \T_ARRAY             => \T_ARRAY,
        \T_OPEN_SHORT_ARRAY  => \T_OPEN_SHORT_ARRAY,
        \T_CLOSE_SHORT_ARRAY => \T_CLOSE_SHORT_ARRAY,
    ];

    /**
     * Tokens which are used to create arrays.
     *
     * List which is backward-compatible with PHPCS < 3.3.0.
     * Should only be used selectively.
     *
     * @see \PHPCSUtils\Tokens\Collections::$shortArrayTokensBC Related property containing only tokens used
     *                                                          for short arrays (cross-version).
     *
     * @since 1.0.0
     *
     * @var array <int|string> => <int|string>
     */
    public static $arrayTokensBC = [
        \T_ARRAY                => \T_ARRAY,
        \T_OPEN_SHORT_ARRAY     => \T_OPEN_SHORT_ARRAY,
        \T_CLOSE_SHORT_ARRAY    => \T_CLOSE_SHORT_ARRAY,
        \T_OPEN_SQUARE_BRACKET  => \T_OPEN_SQUARE_BRACKET,
        \T_CLOSE_SQUARE_BRACKET => \T_CLOSE_SQUARE_BRACKET,
    ];

    /**
     * Modifier keywords which can be used for a class declaration.
     *
     * @since 1.0.0
     *
     * @var array <int|string> => <int|string>
     */
    public static $classModifierKeywords = [
        \T_FINAL    => \T_FINAL,
        \T_ABSTRACT => \T_ABSTRACT,
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
     * Control structure tokens.
     *
     * @since 1.0.0-alpha2
     *
     * @var array <int> => <int>
     */
    public static $controlStructureTokens = [
        \T_IF      => \T_IF,
        \T_ELSEIF  => \T_ELSEIF,
        \T_ELSE    => \T_ELSE,
        \T_FOR     => \T_FOR,
        \T_FOREACH => \T_FOREACH,
        \T_SWITCH  => \T_SWITCH,
        \T_DO      => \T_DO,
        \T_WHILE   => \T_WHILE,
        \T_DECLARE => \T_DECLARE,
    ];

    /**
     * Increment/decrement operator tokens.
     *
     * @since 1.0.0-alpha3
     *
     * @var array <int> => <int>
     */
    public static $incrementDecrementOperators = [
        \T_DEC => \T_DEC,
        \T_INC => \T_INC,
    ];

    /**
     * Tokens which are used to create lists.
     *
     * @see \PHPCSUtils\Tokens\Collections::$shortListTokens Related property containing only tokens used
     *                                                       for short lists.
     *
     * @since 1.0.0
     *
     * @var array <int|string> => <int|string>
     */
    public static $listTokens = [
        \T_LIST              => \T_LIST,
        \T_OPEN_SHORT_ARRAY  => \T_OPEN_SHORT_ARRAY,
        \T_CLOSE_SHORT_ARRAY => \T_CLOSE_SHORT_ARRAY,
    ];

    /**
     * Tokens which are used to create lists.
     *
     * List which is backward-compatible with PHPCS < 3.3.0.
     * Should only be used selectively.
     *
     * @see \PHPCSUtils\Tokens\Collections::$shortListTokensBC Related property containing only tokens used
     *                                                         for short lists (cross-version).
     *
     * @since 1.0.0
     *
     * @var array <int|string> => <int|string>
     */
    public static $listTokensBC = [
        \T_LIST                 => \T_LIST,
        \T_OPEN_SHORT_ARRAY     => \T_OPEN_SHORT_ARRAY,
        \T_CLOSE_SHORT_ARRAY    => \T_CLOSE_SHORT_ARRAY,
        \T_OPEN_SQUARE_BRACKET  => \T_OPEN_SQUARE_BRACKET,
        \T_CLOSE_SQUARE_BRACKET => \T_CLOSE_SQUARE_BRACKET,
    ];

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
     * List of tokens which can end a namespace declaration statement.
     *
     * @since 1.0.0
     *
     * @var array <int|string> => <int|string>
     */
    public static $namespaceDeclarationClosers = [
        \T_SEMICOLON          => \T_SEMICOLON,
        \T_OPEN_CURLY_BRACKET => \T_OPEN_CURLY_BRACKET,
        \T_CLOSE_TAG          => \T_CLOSE_TAG,
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
     * OO structures which can use the "implements" keyword.
     *
     * @since 1.0.0
     *
     * @var array <int|string> => <int|string>
     */
    public static $OOCanImplement = [
        \T_CLASS      => \T_CLASS,
        \T_ANON_CLASS => \T_ANON_CLASS,
    ];

    /**
     * OO scopes in which constants can be declared.
     *
     * Note: traits can not declare constants.
     *
     * @since 1.0.0
     *
     * @var array <int|string> => <int|string>
     */
    public static $OOConstantScopes = [
        \T_CLASS      => \T_CLASS,
        \T_ANON_CLASS => \T_ANON_CLASS,
        \T_INTERFACE  => \T_INTERFACE,
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
     * Tokens types which can be encountered in the fully/partially qualified name of an OO structure.
     *
     * Example:
     * ```php
     * echo namespace\Sub\ClassName::method();
     * ```
     *
     * @since 1.0.0-alpha3
     *
     * @var array <int|string> => <int|string>
     */
    public static $OONameTokens = [
        \T_NS_SEPARATOR => \T_NS_SEPARATOR,
        \T_STRING       => \T_STRING,
        \T_NAMESPACE    => \T_NAMESPACE,
    ];

    /**
     * OO scopes in which properties can be declared.
     *
     * Note: interfaces can not declare properties.
     *
     * @since 1.0.0
     *
     * @var array <int|string> => <int|string>
     */
    public static $OOPropertyScopes = [
        \T_CLASS      => \T_CLASS,
        \T_ANON_CLASS => \T_ANON_CLASS,
        \T_TRAIT      => \T_TRAIT,
    ];

    /**
     * Token types which can be encountered in a parameter type declaration.
     *
     * Sister-property to the {@see Collections::parameterTypeTokensBC()} method.
     * The property supports PHPCS 3.3.0 and up.
     * The method supports PHPCS 2.6.0 and up.
     *
     * Notable difference:
     * - The method will include the `T_ARRAY_HINT` token when used with PHPCS 2.x and 3.x.
     *   This token constant will no longer exist in PHPCS 4.x.
     *
     * It is recommended to use the property instead of the method if a standard supports does
     * not need to support PHPCS < 3.3.0.
     *
     * @see \PHPCSUtils\Tokens\Collections::parameterTypeTokensBC() Related method (cross-version).
     *
     * @since 1.0.0
     *
     * @var array <int|string> => <int|string>
     */
    public static $parameterTypeTokens = [
        \T_CALLABLE     => \T_CALLABLE,
        \T_SELF         => \T_SELF,
        \T_PARENT       => \T_PARENT,
        \T_STRING       => \T_STRING,
        \T_NS_SEPARATOR => \T_NS_SEPARATOR,
    ];

    /**
     * Modifier keywords which can be used for a property declaration.
     *
     * @since 1.0.0
     *
     * @var array <int|string> => <int|string>
     */
    public static $propertyModifierKeywords = [
        \T_PUBLIC    => \T_PUBLIC,
        \T_PRIVATE   => \T_PRIVATE,
        \T_PROTECTED => \T_PROTECTED,
        \T_STATIC    => \T_STATIC,
        \T_VAR       => \T_VAR,
    ];

    /**
     * Token types which can be encountered in a property type declaration.
     *
     * Sister-property to the {@see Collections::propertyTypeTokensBC()} method.
     * The property supports PHPCS 3.3.0 and up.
     * The method supports PHPCS 2.6.0 and up.
     *
     * Notable difference:
     * - The method will include the `T_ARRAY_HINT` token when used with PHPCS 2.x and 3.x.
     *   This token constant will no longer exist in PHPCS 4.x.
     *
     * It is recommended to use the property instead of the method if a standard supports does
     * not need to support PHPCS < 3.3.0.
     *
     * @see \PHPCSUtils\Tokens\Collections::propertyTypeTokensBC() Related method (cross-version).
     *
     * @since 1.0.0
     *
     * @var array <int|string> => <int|string>
     */
    public static $propertyTypeTokens = [
        \T_CALLABLE     => \T_CALLABLE,
        \T_SELF         => \T_SELF,
        \T_PARENT       => \T_PARENT,
        \T_STRING       => \T_STRING,
        \T_NS_SEPARATOR => \T_NS_SEPARATOR,
    ];

    /**
     * Token types which can be encountered in a return type declaration.
     *
     * Sister-property to the {@see Collections::returnTypeTokensBC()} method.
     * The property supports PHPCS 3.5.4 and up.
     * The method supports PHPCS 2.6.0 and up.
     *
     * Notable differences:
     * - The method will include the `T_ARRAY_HINT` and the `T_RETURN_TYPE` tokens when used with PHPCS 2.x and 3.x.
     *   These token constants will no longer exist in PHPCS 4.x.
     * - The method will include the `T_ARRAY` token which is needed for select arrow functions in PHPCS < 3.5.4.
     *
     * It is recommended to use the property instead of the method if a standard supports does
     * not need to support PHPCS < 3.5.4.
     *
     * @see \PHPCSUtils\Tokens\Collections::returnTypeTokensBC() Related method (cross-version).
     *
     * @since 1.0.0
     *
     * @var array <int|string> => <int|string>
     */
    public static $returnTypeTokens = [
        \T_STRING       => \T_STRING,
        \T_CALLABLE     => \T_CALLABLE,
        \T_SELF         => \T_SELF,
        \T_PARENT       => \T_PARENT,
        \T_STATIC       => \T_STATIC,
        \T_NS_SEPARATOR => \T_NS_SEPARATOR,
    ];

    /**
     * Tokens which are used for short arrays.
     *
     * @see \PHPCSUtils\Tokens\Collections::$arrayTokens Related property containing all tokens used for arrays.
     *
     * @since 1.0.0
     *
     * @var array <int|string> => <int|string>
     */
    public static $shortArrayTokens = [
        \T_OPEN_SHORT_ARRAY  => \T_OPEN_SHORT_ARRAY,
        \T_CLOSE_SHORT_ARRAY => \T_CLOSE_SHORT_ARRAY,
    ];

    /**
     * Tokens which are used for short arrays.
     *
     * List which is backward-compatible with PHPCS < 3.3.0.
     * Should only be used selectively.
     *
     * @see \PHPCSUtils\Tokens\Collections::$arrayTokensBC Related property containing all tokens used for arrays
     *                                                    (cross-version).
     *
     * @since 1.0.0
     *
     * @var array <int|string> => <int|string>
     */
    public static $shortArrayTokensBC = [
        \T_OPEN_SHORT_ARRAY     => \T_OPEN_SHORT_ARRAY,
        \T_CLOSE_SHORT_ARRAY    => \T_CLOSE_SHORT_ARRAY,
        \T_OPEN_SQUARE_BRACKET  => \T_OPEN_SQUARE_BRACKET,
        \T_CLOSE_SQUARE_BRACKET => \T_CLOSE_SQUARE_BRACKET,
    ];

    /**
     * Tokens which are used for short lists.
     *
     * @see \PHPCSUtils\Tokens\Collections::$listTokens Related property containing all tokens used for lists.
     *
     * @since 1.0.0
     *
     * @var array <int|string> => <int|string>
     */
    public static $shortListTokens = [
        \T_OPEN_SHORT_ARRAY  => \T_OPEN_SHORT_ARRAY,
        \T_CLOSE_SHORT_ARRAY => \T_CLOSE_SHORT_ARRAY,
    ];

    /**
     * Tokens which are used for short lists.
     *
     * List which is backward-compatible with PHPCS < 3.3.0.
     * Should only be used selectively.
     *
     * @see \PHPCSUtils\Tokens\Collections::$listTokensBC Related property containing all tokens used for lists
     *                                                    (cross-version).
     *
     * @since 1.0.0
     *
     * @var array <int|string> => <int|string>
     */
    public static $shortListTokensBC = [
        \T_OPEN_SHORT_ARRAY     => \T_OPEN_SHORT_ARRAY,
        \T_CLOSE_SHORT_ARRAY    => \T_CLOSE_SHORT_ARRAY,
        \T_OPEN_SQUARE_BRACKET  => \T_OPEN_SQUARE_BRACKET,
        \T_CLOSE_SQUARE_BRACKET => \T_CLOSE_SQUARE_BRACKET,
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
     * Token types which can be encountered in a parameter type declaration (cross-version).
     *
     * Sister-method to the {@see Collections::$parameterTypeTokens} property.
     * The property supports PHPCS 3.3.0 and up.
     * The method supports PHPCS 2.6.0 and up.
     *
     * Notable difference:
     * - The method will include the `T_ARRAY_HINT` token when used with PHPCS 2.x and 3.x.
     *   This token constant will no longer exist in PHPCS 4.x.
     *
     * It is recommended to use the property instead of the method if a standard supports does
     * not need to support PHPCS < 3.3.0.
     *
     * @see \PHPCSUtils\Tokens\Collections::$parameterTypeTokens Related property (PHPCS 3.3.0+).
     *
     * @since 1.0.0-alpha3
     *
     * @return array <int|string> => <int|string>
     */
    public static function parameterTypeTokensBC()
    {
        $tokens = self::$parameterTypeTokens;

        // PHPCS < 4.0; Needed for support of PHPCS < 3.3.0. For PHPCS 3.3.0+ the constant is no longer used.
        if (\defined('T_ARRAY_HINT') === true) {
            $tokens[\T_ARRAY_HINT] = \T_ARRAY_HINT;
        }

        return $tokens;
    }

    /**
     * Token types which can be encountered in a property type declaration (cross-version).
     *
     * Sister-method to the {@see Collections::$propertyTypeTokens} property.
     * The property supports PHPCS 3.3.0 and up.
     * The method supports PHPCS 2.6.0 and up.
     *
     * Notable difference:
     * - The method will include the `T_ARRAY_HINT` token when used with PHPCS 2.x and 3.x.
     *   This token constant will no longer exist in PHPCS 4.x.
     *
     * It is recommended to use the property instead of the method if a standard supports does
     * not need to support PHPCS < 3.3.0.
     *
     * @see \PHPCSUtils\Tokens\Collections::$propertyTypeTokens Related property (PHPCS 3.3.0+).
     *
     * @since 1.0.0-alpha3
     *
     * @return array <int|string> => <int|string>
     */
    public static function propertyTypeTokensBC()
    {
        return self::parameterTypeTokensBC();
    }

    /**
     * Token types which can be encountered in a return type declaration (cross-version).
     *
     * Sister-property to the {@see Collections::returnTypeTokensBC()} method.
     * The property supports PHPCS 3.5.4 and up.
     * The method supports PHPCS 2.6.0 and up.
     *
     * Notable differences:
     * - The method will include the `T_ARRAY_HINT` and the `T_RETURN_TYPE` tokens when used with PHPCS 2.x and 3.x.
     *   These token constants will no longer exist in PHPCS 4.x.
     * - The method will include the `T_ARRAY` token which is needed for select arrow functions in PHPCS < 3.5.4.
     *
     * It is recommended to use the property instead of the method if a standard supports does
     * not need to support PHPCS < 3.5.4.
     *
     * @see \PHPCSUtils\Tokens\Collections::$returnTypeTokens Related property (PHPCS 3.5.4+).
     *
     * @since 1.0.0-alpha3
     *
     * @return array <int|string> => <int|string>
     */
    public static function returnTypeTokensBC()
    {
        $tokens = self::$returnTypeTokens;

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

        /*
         * PHPCS < 3.5.4. Needed for support of PHPCS < 3.5.4 for select arrow functions.
         * For PHPCS 3.5.4+ the constant is no longer used in return type tokenization.
         */
        if (\version_compare(Helper::getVersion(), '3.5.4', '<')) {
            $tokens[\T_ARRAY] = \T_ARRAY;
        }

        return $tokens;
    }
}
