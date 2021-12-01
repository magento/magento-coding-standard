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

use PHP_CodeSniffer\Exceptions\RuntimeException;
use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Util\Tokens;
use Magento2\Helpers\PHPCSUtils\BackCompat\Helper;
use Magento2\Helpers\PHPCSUtils\Tokens\Collections;

/**
 * Utility functions for use when examining function declaration statements.
 *
 * @since 1.0.0 The `FunctionDeclarations::getProperties()` and the
 *              `FunctionDeclarations::getParameters()` methods are based on and
 *              inspired by respectively the `getMethodProperties()`
 *              and `getMethodParameters()` methods in the PHPCS native
 *              `PHP_CodeSniffer\Files\File` class.
 *              Also see {@see \PHPCSUtils\BackCompat\BCFile}.
 */
class FunctionDeclarations
{

    /**
     * Retrieves the visibility and implementation properties of a method.
     *
     * Main differences with the PHPCS version:
     * - Bugs fixed:
     *   - Handling of PHPCS annotations.
     *   - `"has_body"` index could be set to `true` for functions without body in the case of
     *      parse errors or live coding.
     * - Defensive coding against incorrect calls to this method.
     * - More efficient checking whether a function has a body.
     * - New `"return_type_end_token"` (int|false) array index.
     * - To allow for backward compatible handling of arrow functions, this method will also accept
     *   `T_STRING` tokens and examine them to check if these are arrow functions.
     *
     * @see \PHP_CodeSniffer\Files\File::getMethodProperties()   Original source.
     * @see \PHPCSUtils\BackCompat\BCFile::getMethodProperties() Cross-version compatible version of the original.
     *
     * @since 1.0.0
     * @since 1.0.0-alpha2 Added BC support for PHP 7.4 arrow functions.
     * @since 1.0.0-alpha3 Added support for PHP 8.0 static return type.
     *
     * @param \PHP_CodeSniffer\Files\File $phpcsFile The file being scanned.
     * @param int                         $stackPtr  The position in the stack of the function token to
     *                                               acquire the properties for.
     *
     * @return array Array with information about a function declaration.
     *               The format of the return value is:
     *               ```php
     *               array(
     *                 'scope'                 => 'public', // Public, private, or protected
     *                 'scope_specified'       => true,     // TRUE if the scope keyword was found.
     *                 'return_type'           => '',       // The return type of the method.
     *                 'return_type_token'     => integer,  // The stack pointer to the start of the return type
     *                                                      // or FALSE if there is no return type.
     *                 'return_type_end_token' => integer,  // The stack pointer to the end of the return type
     *                                                      // or FALSE if there is no return type.
     *                 'nullable_return_type'  => false,    // TRUE if the return type is nullable.
     *                 'is_abstract'           => false,    // TRUE if the abstract keyword was found.
     *                 'is_final'              => false,    // TRUE if the final keyword was found.
     *                 'is_static'             => false,    // TRUE if the static keyword was found.
     *                 'has_body'              => false,    // TRUE if the method has a body
     *               );
     *               ```
     *
     * @throws \PHP_CodeSniffer\Exceptions\RuntimeException If the specified position is not a T_FUNCTION
     *                                                      or T_CLOSURE token, nor an arrow function.
     */
    public static function getProperties(File $phpcsFile, $stackPtr)
    {
        $tokens         = $phpcsFile->getTokens();
        $arrowOpenClose = self::getArrowFunctionOpenClose($phpcsFile, $stackPtr);

        if (isset($tokens[$stackPtr]) === false
            || ($tokens[$stackPtr]['code'] !== \T_FUNCTION
                && $tokens[$stackPtr]['code'] !== \T_CLOSURE
                && $arrowOpenClose === false)
        ) {
            throw new RuntimeException('$stackPtr must be of type T_FUNCTION or T_CLOSURE or an arrow function');
        }

        if ($tokens[$stackPtr]['code'] === \T_FUNCTION) {
            $valid = Tokens::$methodPrefixes;
        } else {
            $valid = [\T_STATIC => \T_STATIC];
        }

        $valid += Tokens::$emptyTokens;

        $scope          = 'public';
        $scopeSpecified = false;
        $isAbstract     = false;
        $isFinal        = false;
        $isStatic       = false;

        for ($i = ($stackPtr - 1); $i > 0; $i--) {
            if (isset($valid[$tokens[$i]['code']]) === false) {
                break;
            }

            switch ($tokens[$i]['code']) {
                case \T_PUBLIC:
                    $scope          = 'public';
                    $scopeSpecified = true;
                    break;
                case \T_PRIVATE:
                    $scope          = 'private';
                    $scopeSpecified = true;
                    break;
                case \T_PROTECTED:
                    $scope          = 'protected';
                    $scopeSpecified = true;
                    break;
                case \T_ABSTRACT:
                    $isAbstract = true;
                    break;
                case \T_FINAL:
                    $isFinal = true;
                    break;
                case \T_STATIC:
                    $isStatic = true;
                    break;
            }
        }

        $returnType         = '';
        $returnTypeToken    = false;
        $returnTypeEndToken = false;
        $nullableReturnType = false;
        $hasBody            = false;
        $returnTypeTokens   = Collections::returnTypeTokensBC();

        $parenthesisCloser = null;
        if (isset($tokens[$stackPtr]['parenthesis_closer']) === true) {
            $parenthesisCloser = $tokens[$stackPtr]['parenthesis_closer'];
        } elseif ($arrowOpenClose !== false) {
            // Arrow function in combination with PHP < 7.4 or PHPCS < 3.5.3.
            $parenthesisCloser = $arrowOpenClose['parenthesis_closer'];
        }

        if (isset($parenthesisCloser) === true) {
            $scopeOpener = null;
            if (isset($tokens[$stackPtr]['scope_opener']) === true) {
                $scopeOpener = $tokens[$stackPtr]['scope_opener'];
            } elseif ($arrowOpenClose !== false) {
                // Arrow function in combination with PHP < 7.4 or PHPCS < 3.5.3.
                $scopeOpener = $arrowOpenClose['scope_opener'];
            }

            for ($i = $parenthesisCloser; $i < $phpcsFile->numTokens; $i++) {
                if ($i === $scopeOpener) {
                    // End of function definition.
                    $hasBody = true;
                    break;
                }

                if ($scopeOpener === null && $tokens[$i]['code'] === \T_SEMICOLON) {
                    // End of abstract/interface function definition.
                    break;
                }

                if ($tokens[$i]['type'] === 'T_NULLABLE'
                    // Handle nullable tokens in PHPCS < 2.8.0.
                    || (\defined('T_NULLABLE') === false && $tokens[$i]['code'] === \T_INLINE_THEN)
                    // Handle nullable tokens with arrow functions in PHPCS 2.8.0 - 2.9.0.
                    || ($arrowOpenClose !== false && $tokens[$i]['code'] === \T_INLINE_THEN
                        && \version_compare(Helper::getVersion(), '2.9.1', '<') === true)
                ) {
                    $nullableReturnType = true;
                }

                if (isset($returnTypeTokens[$tokens[$i]['code']]) === true) {
                    if ($returnTypeToken === false) {
                        $returnTypeToken = $i;
                    }

                    $returnType        .= $tokens[$i]['content'];
                    $returnTypeEndToken = $i;
                }
            }
        }

        if ($returnType !== '' && $nullableReturnType === true) {
            $returnType = '?' . $returnType;
        }

        return [
            'scope'                 => $scope,
            'scope_specified'       => $scopeSpecified,
            'return_type'           => $returnType,
            'return_type_token'     => $returnTypeToken,
            'return_type_end_token' => $returnTypeEndToken,
            'nullable_return_type'  => $nullableReturnType,
            'is_abstract'           => $isAbstract,
            'is_final'              => $isFinal,
            'is_static'             => $isStatic,
            'has_body'              => $hasBody,
        ];
    }

    /**
     * Retrieve the parenthesis opener, parenthesis closer, the scope opener and the scope closer
     * for an arrow function.
     *
     * Helper function for cross-version compatibility with both PHP as well as PHPCS.
     * In PHPCS versions prior to PHPCS 3.5.3/3.5.4, the `T_FN` token is not yet backfilled
     * and does not have parenthesis opener/closer nor scope opener/closer indexes assigned
     * in the `$tokens` array.
     *
     * @see \PHPCSUtils\Utils\FunctionDeclarations::isArrowFunction() Related function.
     *
     * @since 1.0.0
     * @since 1.0.0-alpha4 Handling of PHP 8.0 identifier name tokens in return types, cross-version PHP & PHPCS.
     *
     * @param \PHP_CodeSniffer\Files\File $phpcsFile The file where this token was found.
     * @param int                         $stackPtr  The token to retrieve the openers/closers for.
     *                                               Typically a `T_FN` or `T_STRING` token as those are the
     *                                               only two tokens which can be the arrow function keyword.
     *
     * @return array|false An array with the token pointers or `FALSE` if this is not an arrow function.
     *                     The format of the return value is:
     *                     ```php
     *                     array(
     *                       'parenthesis_opener' => integer, // Stack pointer to the parenthesis opener.
     *                       'parenthesis_closer' => integer, // Stack pointer to the parenthesis closer.
     *                       'scope_opener'       => integer, // Stack pointer to the scope opener (arrow).
     *                       'scope_closer'       => integer, // Stack pointer to the scope closer.
     *                     )
     *                     ```
     */
    public static function getArrowFunctionOpenClose(File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();

        if (isset($tokens[$stackPtr]) === false
            || isset(Collections::arrowFunctionTokensBC()[$tokens[$stackPtr]['code']]) === false
            || \strtolower($tokens[$stackPtr]['content']) !== 'fn'
        ) {
            return false;
        }

        if ($tokens[$stackPtr]['type'] === 'T_FN'
            && isset($tokens[$stackPtr]['scope_closer']) === true
            && \version_compare(Helper::getVersion(), '3.5.4', '>') === true
        ) {
            // The keys will either all be set or none will be set, so no additional checks needed.
            return [
                'parenthesis_opener' => $tokens[$stackPtr]['parenthesis_opener'],
                'parenthesis_closer' => $tokens[$stackPtr]['parenthesis_closer'],
                'scope_opener'       => $tokens[$stackPtr]['scope_opener'],
                'scope_closer'       => $tokens[$stackPtr]['scope_closer'],
            ];
        }

        /*
         * This is either a T_STRING token pre-PHP 7.4, or T_FN on PHP 7.4 in combination
         * with PHPCS < 3.5.3/4/5.
         *
         * Now see about finding the relevant arrow function tokens.
         */
        $returnValue = [];

        $nextNonEmpty = $phpcsFile->findNext(
            (Tokens::$emptyTokens + [\T_BITWISE_AND]),
            ($stackPtr + 1),
            null,
            true
        );
        if ($nextNonEmpty === false || $tokens[$nextNonEmpty]['code'] !== \T_OPEN_PARENTHESIS) {
            return false;
        }

        $returnValue['parenthesis_opener'] = $nextNonEmpty;
        if (isset($tokens[$nextNonEmpty]['parenthesis_closer']) === false) {
            return false;
        }

        $returnValue['parenthesis_closer'] = $tokens[$nextNonEmpty]['parenthesis_closer'];

        $ignore                 = Tokens::$emptyTokens;
        $ignore                += Collections::returnTypeTokensBC();
        $ignore[\T_COLON]       = \T_COLON;
        $ignore[\T_INLINE_ELSE] = \T_INLINE_ELSE; // Return type colon on PHPCS < 2.9.1.
        $ignore[\T_INLINE_THEN] = \T_INLINE_THEN; // Nullable type indicator on PHPCS < 2.9.1.

        if (\defined('T_NULLABLE') === true) {
            $ignore[\T_NULLABLE] = \T_NULLABLE;
        }

        $arrow = $phpcsFile->findNext(
            $ignore,
            ($tokens[$nextNonEmpty]['parenthesis_closer'] + 1),
            null,
            true
        );

        if ($arrow === false
            || ($tokens[$arrow]['code'] !== \T_DOUBLE_ARROW && $tokens[$arrow]['type'] !== 'T_FN_ARROW')
        ) {
            return false;
        }

        $returnValue['scope_opener'] = $arrow;
        $inTernary                   = false;
        $lastEndToken                = null;

        for ($scopeCloser = ($arrow + 1); $scopeCloser < $phpcsFile->numTokens; $scopeCloser++) {
            if (isset(self::$arrowFunctionEndTokens[$tokens[$scopeCloser]['code']]) === true
                // BC for misidentified ternary else in some PHPCS versions.
                && ($tokens[$scopeCloser]['code'] !== \T_COLON || $inTernary === false)
            ) {
                if ($lastEndToken !== null
                    && $tokens[$scopeCloser]['code'] === \T_CLOSE_PARENTHESIS
                    && $tokens[$scopeCloser]['parenthesis_opener'] < $arrow
                ) {
                    $scopeCloser = $lastEndToken;
                }

                break;
            }

            if (isset(Collections::arrowFunctionTokensBC()[$tokens[$scopeCloser]['code']]) === true) {
                $nested = self::getArrowFunctionOpenClose($phpcsFile, $scopeCloser);
                if ($nested !== false && isset($nested['scope_closer'])) {
                    // We minus 1 here in case the closer can be shared with us.
                    $scopeCloser = ($nested['scope_closer'] - 1);
                    continue;
                }
            }

            if (isset($tokens[$scopeCloser]['scope_closer']) === true
                && $tokens[$scopeCloser]['code'] !== \T_INLINE_ELSE
                && $tokens[$scopeCloser]['code'] !== \T_END_HEREDOC
                && $tokens[$scopeCloser]['code'] !== \T_END_NOWDOC
            ) {
                // We minus 1 here in case the closer can be shared with us.
                $scopeCloser = ($tokens[$scopeCloser]['scope_closer'] - 1);
                continue;
            }

            if (isset($tokens[$scopeCloser]['parenthesis_closer']) === true) {
                $scopeCloser  = $tokens[$scopeCloser]['parenthesis_closer'];
                $lastEndToken = $scopeCloser;
                continue;
            }

            if (isset($tokens[$scopeCloser]['bracket_closer']) === true) {
                $scopeCloser  = $tokens[$scopeCloser]['bracket_closer'];
                $lastEndToken = $scopeCloser;
                continue;
            }

            if ($tokens[$scopeCloser]['code'] === \T_INLINE_THEN) {
                $inTernary = true;
                continue;
            }

            if ($tokens[$scopeCloser]['code'] === \T_INLINE_ELSE) {
                if ($inTernary === false) {
                    break;
                }

                $inTernary = false;
            }
        }

        if ($scopeCloser === $phpcsFile->numTokens) {
            return false;
        }

        $returnValue['scope_closer'] = $scopeCloser;

        return $returnValue;
    }

    /**
     * Returns the declaration name for a function.
     *
     * Alias for the {@see \PHPCSUtils\Utils\ObjectDeclarations::getName()} method.
     *
     * @see \PHPCSUtils\BackCompat\BCFile::getDeclarationName() Original function.
     * @see \PHPCSUtils\Utils\ObjectDeclarations::getName()     PHPCSUtils native improved version.
     *
     * @since 1.0.0
     *
     * @codeCoverageIgnore
     *
     * @param \PHP_CodeSniffer\Files\File $phpcsFile The file being scanned.
     * @param int                         $stackPtr  The position of the function keyword token.
     *
     * @return string|null The name of the function; or `NULL` if the passed token doesn't exist,
     *                     the function is anonymous or in case of a parse error/live coding.
     *
     * @throws \PHP_CodeSniffer\Exceptions\RuntimeException If the specified token is not of type
     *                                                      `T_FUNCTION`.
     */
    public static function getName(File $phpcsFile, $stackPtr)
    {
        return ObjectDeclarations::getName($phpcsFile, $stackPtr);
    }


    /**
     * Retrieves the method parameters for the specified function token.
     *
     * Also supports passing in a `T_USE` token for a closure use group.
     *
     * The returned array will contain the following information for each parameter:
     *
     * ```php
     * 0 => array(
     *   'name'                => '$var',  // The variable name.
     *   'token'               => integer, // The stack pointer to the variable name.
     *   'content'             => string,  // The full content of the variable definition.
     *   'pass_by_reference'   => boolean, // Is the variable passed by reference?
     *   'reference_token'     => integer, // The stack pointer to the reference operator
     *                                     // or FALSE if the param is not passed by reference.
     *   'variable_length'     => boolean, // Is the param of variable length through use of `...` ?
     *   'variadic_token'      => integer, // The stack pointer to the ... operator
     *                                     // or FALSE if the param is not variable length.
     *   'type_hint'           => string,  // The type hint for the variable.
     *   'type_hint_token'     => integer, // The stack pointer to the start of the type hint
     *                                     // or FALSE if there is no type hint.
     *   'type_hint_end_token' => integer, // The stack pointer to the end of the type hint
     *                                     // or FALSE if there is no type hint.
     *   'nullable_type'       => boolean, // TRUE if the var type is preceded by the nullability
     *                                     // operator.
     *   'comma_token'         => integer, // The stack pointer to the comma after the param
     *                                     // or FALSE if this is the last param.
     * )
     * ```
     *
     * Parameters with default values have the following additional array indexes:
     * ```php
     *   'default'             => string,  // The full content of the default value.
     *   'default_token'       => integer, // The stack pointer to the start of the default value.
     *   'default_equal_token' => integer, // The stack pointer to the equals sign.
     * ```
     *
     * Parameters declared using PHP 8 constructor property promotion, have these additional array indexes:
     * ```php
     *   'property_visibility' => string,  // The property visibility as declared.
     *   'visibility_token'    => integer, // The stack pointer to the visibility modifier token.
     * ```
     *
     * Main differences with the PHPCS version:
     * - Defensive coding against incorrect calls to this method.
     * - More efficient and more stable checking whether a `T_USE` token is a closure use.
     * - More efficient and more stable looping of the default value.
     * - Clearer exception message when a non-closure use token was passed to the function.
     * - To allow for backward compatible handling of arrow functions, this method will also accept
     *   `T_STRING` tokens and examine them to check if these are arrow functions.
     * - Support for PHP 8.0 identifier name tokens in parameter types, cross-version PHP & PHPCS.
     *
     * @see \PHP_CodeSniffer\Files\File::getMethodParameters()   Original source.
     * @see \PHPCSUtils\BackCompat\BCFile::getMethodParameters() Cross-version compatible version of the original.
     *
     * @since 1.0.0
     * @since 1.0.0-alpha2 Added BC support for PHP 7.4 arrow functions.
     * @since 1.0.0-alpha4 Added support for PHP 8.0 union types.
     * @since 1.0.0-alpha4 Added support for PHP 8.0 constructor property promotion.
     * @since 1.0.0-alpha4 Added support for PHP 8.0 identifier name tokenization.
     *
     * @param \PHP_CodeSniffer\Files\File $phpcsFile The file being scanned.
     * @param int                         $stackPtr  The position in the stack of the function token
     *                                               to acquire the parameters for.
     *
     * @return array
     *
     * @throws \PHP_CodeSniffer\Exceptions\RuntimeException If the specified $stackPtr is not of
     *                                                      type `T_FUNCTION`, `T_CLOSURE` or `T_USE`,
     *                                                      nor an arrow function.
     * @throws \PHP_CodeSniffer\Exceptions\RuntimeException If a passed `T_USE` token is not a closure
     *                                                      use token.
     */
    public static function getParameters(File $phpcsFile, $stackPtr)
    {
        $tokens         = $phpcsFile->getTokens();
        $arrowOpenClose = self::getArrowFunctionOpenClose($phpcsFile, $stackPtr);

        if (isset($tokens[$stackPtr]) === false
            || ($tokens[$stackPtr]['code'] !== \T_FUNCTION
                && $tokens[$stackPtr]['code'] !== \T_CLOSURE
                && $tokens[$stackPtr]['code'] !== \T_USE
                && $arrowOpenClose === false)
        ) {
            throw new RuntimeException('$stackPtr must be of type T_FUNCTION, T_CLOSURE or T_USE or an arrow function');
        }

        if ($tokens[$stackPtr]['code'] === \T_USE) {
            // This will work PHPCS 3.x/4.x cross-version without much overhead.
            $opener = $phpcsFile->findNext(Tokens::$emptyTokens, ($stackPtr + 1), null, true);
            if ($opener === false
                || $tokens[$opener]['code'] !== \T_OPEN_PARENTHESIS
                || UseStatements::isClosureUse($phpcsFile, $stackPtr) === false
            ) {
                throw new RuntimeException('$stackPtr was not a valid closure T_USE');
            }
        } elseif ($arrowOpenClose !== false) {
            // Arrow function in combination with PHP < 7.4 or PHPCS < 3.5.3/4/5.
            $opener = $arrowOpenClose['parenthesis_opener'];
        } else {
            if (isset($tokens[$stackPtr]['parenthesis_opener']) === false) {
                // Live coding or syntax error, so no params to find.
                return [];
            }

            $opener = $tokens[$stackPtr]['parenthesis_opener'];
        }

        if (isset($tokens[$opener]['parenthesis_closer']) === false) {
            // Live coding or syntax error, so no params to find.
            return [];
        }

        $closer = $tokens[$opener]['parenthesis_closer'];

        $vars             = [];
        $currVar          = null;
        $paramStart       = ($opener + 1);
        $defaultStart     = null;
        $equalToken       = null;
        $paramCount       = 0;
        $passByReference  = false;
        $referenceToken   = false;
        $variableLength   = false;
        $variadicToken    = false;
        $typeHint         = '';
        $typeHintToken    = false;
        $typeHintEndToken = false;
        $nullableType     = false;
        $visibilityToken  = null;

        for ($i = $paramStart; $i <= $closer; $i++) {
            // Changed from checking 'code' to 'type' to allow for T_NULLABLE not existing in PHPCS < 2.8.0.
            switch ($tokens[$i]['type']) {
                case 'T_BITWISE_AND':
                    $passByReference = true;
                    $referenceToken  = $i;
                    break;

                case 'T_VARIABLE':
                    $currVar = $i;
                    break;

                case 'T_ELLIPSIS':
                    $variableLength = true;
                    $variadicToken  = $i;
                    break;

                case 'T_ARRAY_HINT': // PHPCS < 3.3.0.
                case 'T_CALLABLE':
                case 'T_SELF':
                case 'T_PARENT':
                case 'T_STATIC': // Self and parent are valid, static invalid, but was probably intended as type hint.
                case 'T_FALSE': // Union types.
                case 'T_NULL': // Union types.
                case 'T_STRING':
                case 'T_NAMESPACE':
                case 'T_NS_SEPARATOR':
                case 'T_NAME_QUALIFIED':
                case 'T_NAME_FULLY_QUALIFIED':
                case 'T_NAME_RELATIVE':
                case 'T_BITWISE_OR': // Union type separator PHPCS < 3.6.0.
                case 'T_TYPE_UNION': // Union type separator PHPCS >= 3.6.0.
                    if ($typeHintToken === false) {
                        $typeHintToken = $i;
                    }

                    $typeHint        .= $tokens[$i]['content'];
                    $typeHintEndToken = $i;
                    break;

                case 'T_NULLABLE':
                case 'T_INLINE_THEN': // PHPCS < 2.8.0.
                    $nullableType     = true;
                    $typeHint        .= $tokens[$i]['content'];
                    $typeHintEndToken = $i;
                    break;

                case 'T_PUBLIC':
                case 'T_PROTECTED':
                case 'T_PRIVATE':
                    $visibilityToken = $i;
                    break;

                case 'T_CLOSE_PARENTHESIS':
                case 'T_COMMA':
                    // If it's null, then there must be no parameters for this
                    // method.
                    if ($currVar === null) {
                        continue 2;
                    }

                    $vars[$paramCount]            = [];
                    $vars[$paramCount]['token']   = $currVar;
                    $vars[$paramCount]['name']    = $tokens[$currVar]['content'];
                    $vars[$paramCount]['content'] = \trim(
                        GetTokensAsString::normal($phpcsFile, $paramStart, ($i - 1))
                    );

                    if ($defaultStart !== null) {
                        $vars[$paramCount]['default']             = \trim(
                            GetTokensAsString::normal($phpcsFile, $defaultStart, ($i - 1))
                        );
                        $vars[$paramCount]['default_token']       = $defaultStart;
                        $vars[$paramCount]['default_equal_token'] = $equalToken;
                    }

                    $vars[$paramCount]['pass_by_reference']   = $passByReference;
                    $vars[$paramCount]['reference_token']     = $referenceToken;
                    $vars[$paramCount]['variable_length']     = $variableLength;
                    $vars[$paramCount]['variadic_token']      = $variadicToken;
                    $vars[$paramCount]['type_hint']           = $typeHint;
                    $vars[$paramCount]['type_hint_token']     = $typeHintToken;
                    $vars[$paramCount]['type_hint_end_token'] = $typeHintEndToken;
                    $vars[$paramCount]['nullable_type']       = $nullableType;

                    if ($visibilityToken !== null) {
                        $vars[$paramCount]['property_visibility'] = $tokens[$visibilityToken]['content'];
                        $vars[$paramCount]['visibility_token']    = $visibilityToken;
                    }

                    if ($tokens[$i]['code'] === \T_COMMA) {
                        $vars[$paramCount]['comma_token'] = $i;
                    } else {
                        $vars[$paramCount]['comma_token'] = false;
                    }

                    // Reset the vars, as we are about to process the next parameter.
                    $currVar          = null;
                    $paramStart       = ($i + 1);
                    $defaultStart     = null;
                    $equalToken       = null;
                    $passByReference  = false;
                    $referenceToken   = false;
                    $variableLength   = false;
                    $variadicToken    = false;
                    $typeHint         = '';
                    $typeHintToken    = false;
                    $typeHintEndToken = false;
                    $nullableType     = false;
                    $visibilityToken  = null;

                    $paramCount++;
                    break;

                case 'T_EQUAL':
                    $defaultStart = $phpcsFile->findNext(Tokens::$emptyTokens, ($i + 1), null, true);
                    $equalToken   = $i;

                    // Skip past everything in the default value before going into the next switch loop.
                    for ($j = ($i + 1); $j <= $closer; $j++) {
                        // Skip past array()'s et al as default values.
                        if (isset($tokens[$j]['parenthesis_opener'], $tokens[$j]['parenthesis_closer'])) {
                            $j = $tokens[$j]['parenthesis_closer'];

                            if ($j === $closer) {
                                // Found the end of the parameter.
                                break;
                            }

                            continue;
                        }

                        // Skip past short arrays et al as default values.
                        if (isset($tokens[$j]['bracket_opener'])) {
                            $j = $tokens[$j]['bracket_closer'];
                            continue;
                        }

                        if ($tokens[$j]['code'] === \T_COMMA) {
                            break;
                        }
                    }

                    $i = ($j - 1);
                    break;
            }
        }

        return $vars;
    }

    /**
     * Check if an arbitrary token is the "fn" keyword for a PHP 7.4 arrow function.
     *
     * Helper function for cross-version compatibility with both PHP as well as PHPCS.
     * - PHP 7.4+ will tokenize most tokens with the content "fn" as `T_FN`, even when it isn't an arrow function.
     * - PHPCS < 3.5.3 will tokenize arrow functions keywords as `T_STRING`.
     * - PHPCS 3.5.3/3.5.4 will tokenize the keyword differently depending on which PHP version is used
     *   and similar to PHP will tokenize most tokens with the content "fn" as `T_FN`, even when it's not an
     *   arrow function.
     *   > Note: the tokens tokenized by PHPCS 3.5.3 - 3.5.4 as `T_FN` are not 100% the same as those tokenized
     *   by PHP 7.4+ as `T_FN`.
     *
     * Either way, the `T_FN` token is not a reliable search vector for finding or examining
     * arrow functions, at least not until PHPCS 3.5.5.
     * This function solves that and will give reliable results in the same way as this is now
     * solved in PHPCS 3.5.5.
     *
     * > Note: Bugs are still being found and reported about how PHPCS tokenizes the arrow functions.
     * This method will keep up with upstream changes and backport them, in as far possible, to allow
     * for sniffing arrow functions in PHPCS < current.
     *
     * @see \PHPCSUtils\Utils\FunctionDeclarations::getArrowFunctionOpenClose() Related function.
     *
     * @since 1.0.0
     *
     * @param \PHP_CodeSniffer\Files\File $phpcsFile The file where this token was found.
     * @param int                         $stackPtr  The token to check. Typically a T_FN or
     *                                               T_STRING token as those are the only two
     *                                               tokens which can be the arrow function keyword.
     *
     * @return bool `TRUE` if the token is the "fn" keyword for an arrow function. `FALSE` when it's not
     *              or in case of live coding/parse error.
     */
    public static function isArrowFunction(File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();
        if (isset($tokens[$stackPtr]) === false) {
            return false;
        }

        if ($tokens[$stackPtr]['type'] === 'T_FN'
            && isset($tokens[$stackPtr]['scope_closer']) === true
        ) {
            return true;
        }

        if (isset(Collections::arrowFunctionTokensBC()[$tokens[$stackPtr]['code']]) === false
            || \strtolower($tokens[$stackPtr]['content']) !== 'fn'
        ) {
            return false;
        }

        $openClose = self::getArrowFunctionOpenClose($phpcsFile, $stackPtr);
        if ($openClose !== false && isset($openClose['scope_closer'])) {
            return true;
        }

        return false;
    }
}
