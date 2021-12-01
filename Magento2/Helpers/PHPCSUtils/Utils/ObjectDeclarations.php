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
use Magento2\Helpers\PHPCSUtils\Tokens\Collections;

/**
 * Utility functions for use when examining object declaration statements.
 *
 * @since 1.0.0 The `ObjectDeclarations::get(Declaration)Name()`,
 *              `ObjectDeclarations::getClassProperties()`, `ObjectDeclarations::findExtendedClassName()`
 *              and `ObjectDeclarations::findImplementedInterfaceNames()` methods are based on and
 *              inspired by the methods of the same name in the PHPCS native
 *              `PHP_CodeSniffer\Files\File` class.
 *              Also see {@see \PHPCSUtils\BackCompat\BCFile}.
 */
class ObjectDeclarations
{

    /**
     * Retrieves the declaration name for classes, interfaces, traits, and functions.
     *
     * Main differences with the PHPCS version:
     * - Defensive coding against incorrect calls to this method.
     * - Improved handling of invalid names, like names starting with a number.
     *   This allows sniffs to report on invalid names instead of ignoring them.
     * - Bug fix: improved handling of parse errors.
     *   Using the original method, a parse error due to an invalid name could cause the method
     *   to return the name of the *next* construct, a partial name and/or the name of a class
     *   being extended/interface being implemented.
     *   Using this version of the utility method, either the complete name (invalid or not) will
     *   be returned or `null` in case of no name (parse error).
     *
     * Note:
     * - For ES6 classes in combination with PHPCS 2.x, passing a `T_STRING` token to
     *   this method will be accepted for JS files.
     * - Support for JS ES6 method syntax has not been back-filled for PHPCS < 3.0.0.
     *
     * @see \PHP_CodeSniffer\Files\File::getDeclarationName()   Original source.
     * @see \PHPCSUtils\BackCompat\BCFile::getDeclarationName() Cross-version compatible version of the original.
     *
     * @since 1.0.0
     *
     * @param \PHP_CodeSniffer\Files\File $phpcsFile The file being scanned.
     * @param int                         $stackPtr  The position of the declaration token
     *                                               which declared the class, interface,
     *                                               trait, or function.
     *
     * @return string|null The name of the class, interface, trait, or function;
     *                     or `NULL` if the passed token doesn't exist, the function or
     *                     class is anonymous or in case of a parse error/live coding.
     *
     * @throws \PHP_CodeSniffer\Exceptions\RuntimeException If the specified token is not of type
     *                                                      `T_FUNCTION`, `T_CLASS`, `T_TRAIT`, or `T_INTERFACE`.
     */
    public static function getName(File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();

        if (isset($tokens[$stackPtr]) === false
            || ($tokens[$stackPtr]['code'] === \T_ANON_CLASS || $tokens[$stackPtr]['code'] === \T_CLOSURE)
        ) {
            return null;
        }

        $tokenCode = $tokens[$stackPtr]['code'];

        /*
         * BC: Work-around JS ES6 classes not being tokenized as T_CLASS in PHPCS < 3.0.0.
         */
        if (isset($phpcsFile->tokenizerType)
            && $phpcsFile->tokenizerType === 'JS'
            && $tokenCode === \T_STRING
            && $tokens[$stackPtr]['content'] === 'class'
        ) {
            $tokenCode = \T_CLASS;
        }

        if ($tokenCode !== \T_FUNCTION
            && $tokenCode !== \T_CLASS
            && $tokenCode !== \T_INTERFACE
            && $tokenCode !== \T_TRAIT
        ) {
            throw new RuntimeException(
                'Token type "' . $tokens[$stackPtr]['type'] . '" is not T_FUNCTION, T_CLASS, T_INTERFACE or T_TRAIT'
            );
        }

        if ($tokenCode === \T_FUNCTION
            && \strtolower($tokens[$stackPtr]['content']) !== 'function'
        ) {
            // This is a function declared without the "function" keyword.
            // So this token is the function name.
            return $tokens[$stackPtr]['content'];
        }

        /*
         * Determine the name. Note that we cannot simply look for the first T_STRING
         * because an (invalid) class name starting with a number will be multiple tokens.
         * Whitespace or comment are however not allowed within a name.
         */

        $stopPoint = $phpcsFile->numTokens;
        if ($tokenCode === \T_FUNCTION && isset($tokens[$stackPtr]['parenthesis_opener']) === true) {
            $stopPoint = $tokens[$stackPtr]['parenthesis_opener'];
        } elseif (isset($tokens[$stackPtr]['scope_opener']) === true) {
            $stopPoint = $tokens[$stackPtr]['scope_opener'];
        }

        $exclude   = Tokens::$emptyTokens;
        $exclude[] = \T_OPEN_PARENTHESIS;
        $exclude[] = \T_OPEN_CURLY_BRACKET;
        $exclude[] = \T_BITWISE_AND;

        $nameStart = $phpcsFile->findNext($exclude, ($stackPtr + 1), $stopPoint, true);
        if ($nameStart === false) {
            // Live coding or parse error.
            return null;
        }

        $tokenAfterNameEnd = $phpcsFile->findNext($exclude, $nameStart, $stopPoint);

        if ($tokenAfterNameEnd === false) {
            $content = null;

            /*
             * BC: In PHPCS 2.6.0, in case of live coding, the last token in a file will be tokenized
             * as T_STRING, but won't have the `content` index set.
             */
            if (isset($tokens[$nameStart]['content'])) {
                $content = $tokens[$nameStart]['content'];
            }

            return $content;
        }

        // Name starts with number, so is composed of multiple tokens.
        return GetTokensAsString::noEmpties($phpcsFile, $nameStart, ($tokenAfterNameEnd - 1));
    }

    /**
     * Retrieves the implementation properties of a class.
     *
     * Main differences with the PHPCS version:
     * - Bugs fixed:
     *   - Handling of PHPCS annotations.
     *   - Handling of unorthodox docblock placement.
     *   - A class cannot both be abstract as well as final, so this utility should not allow for that.
     * - Defensive coding against incorrect calls to this method.
     *
     * @see \PHP_CodeSniffer\Files\File::getClassProperties()   Original source.
     * @see \PHPCSUtils\BackCompat\BCFile::getClassProperties() Cross-version compatible version of the original.
     *
     * @since 1.0.0
     *
     * @param \PHP_CodeSniffer\Files\File $phpcsFile The file being scanned.
     * @param int                         $stackPtr  The position in the stack of the `T_CLASS`
     *                                               token to acquire the properties for.
     *
     * @return array Array with implementation properties of a class.
     *               The format of the return value is:
     *               ```php
     *               array(
     *                 'is_abstract' => false, // TRUE if the abstract keyword was found.
     *                 'is_final'    => false, // TRUE if the final keyword was found.
     *               );
     *               ```
     *
     * @throws \PHP_CodeSniffer\Exceptions\RuntimeException If the specified position is not a
     *                                                      `T_CLASS` token.
     */
    public static function getClassProperties(File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();

        if (isset($tokens[$stackPtr]) === false || $tokens[$stackPtr]['code'] !== \T_CLASS) {
            throw new RuntimeException('$stackPtr must be of type T_CLASS');
        }

        $valid      = Collections::$classModifierKeywords + Tokens::$emptyTokens;
        $properties = [
            'is_abstract' => false,
            'is_final'    => false,
        ];

        for ($i = ($stackPtr - 1); $i > 0; $i--) {
            if (isset($valid[$tokens[$i]['code']]) === false) {
                break;
            }

            switch ($tokens[$i]['code']) {
                case \T_ABSTRACT:
                    $properties['is_abstract'] = true;
                    break 2;

                case \T_FINAL:
                    $properties['is_final'] = true;
                    break 2;
            }
        }

        return $properties;
    }

    /**
     * Retrieves the name of the class that the specified class extends.
     *
     * Works for classes, anonymous classes and interfaces, though it is strongly recommended
     * to use the {@see \PHPCSUtils\Utils\ObjectDeclarations::findExtendedInterfaceNames()}
     * method to examine interfaces instead. Interfaces can extend multiple parent interfaces,
     * and that use-case is not handled by this method.
     *
     * Main differences with the PHPCS version:
     * - Bugs fixed:
     *   - Handling of PHPCS annotations.
     *   - Handling of comments.
     * - Improved handling of parse errors.
     * - The returned name will be clean of superfluous whitespace and/or comments.
     *
     * @see \PHP_CodeSniffer\Files\File::findExtendedClassName()               Original source.
     * @see \PHPCSUtils\BackCompat\BCFile::findExtendedClassName()             Cross-version compatible version of
     *                                                                         the original.
     * @see \PHPCSUtils\Utils\ObjectDeclarations::findExtendedInterfaceNames() Similar method for extended interfaces.
     *
     * @since 1.0.0
     *
     * @param \PHP_CodeSniffer\Files\File $phpcsFile The file being scanned.
     * @param int                         $stackPtr  The stack position of the class or interface.
     *
     * @return string|false The extended class name or `FALSE` on error or if there
     *                      is no extended class name.
     */
    public static function findExtendedClassName(File $phpcsFile, $stackPtr)
    {
        $names = self::findNames($phpcsFile, $stackPtr, \T_EXTENDS, Collections::$OOCanExtend);
        if ($names === false) {
            return false;
        }

        // Classes can only extend one parent class.
        return \array_shift($names);
    }

    /**
     * Retrieves the names of the interfaces that the specified class implements.
     *
     * Main differences with the PHPCS version:
     * - Bugs fixed:
     *   - Handling of PHPCS annotations.
     *   - Handling of comments.
     * - Improved handling of parse errors.
     * - The returned name(s) will be clean of superfluous whitespace and/or comments.
     *
     * @see \PHP_CodeSniffer\Files\File::findImplementedInterfaceNames()   Original source.
     * @see \PHPCSUtils\BackCompat\BCFile::findImplementedInterfaceNames() Cross-version compatible version of
     *                                                                     the original.
     *
     * @since 1.0.0
     *
     * @param \PHP_CodeSniffer\Files\File $phpcsFile The file being scanned.
     * @param int                         $stackPtr  The stack position of the class.
     *
     * @return array|false Array with names of the implemented interfaces or `FALSE` on
     *                     error or if there are no implemented interface names.
     */
    public static function findImplementedInterfaceNames(File $phpcsFile, $stackPtr)
    {
        return self::findNames($phpcsFile, $stackPtr, \T_IMPLEMENTS, Collections::$OOCanImplement);
    }

    /**
     * Retrieves the names of the interfaces that the specified interface extends.
     *
     * @see \PHPCSUtils\Utils\ObjectDeclarations::findExtendedClassName() Similar method for extended classes.
     *
     * @since 1.0.0
     *
     * @param \PHP_CodeSniffer\Files\File $phpcsFile The file where this token was found.
     * @param int                         $stackPtr  The stack position of the interface keyword.
     *
     * @return array|false Array with names of the extended interfaces or `FALSE` on
     *                     error or if there are no extended interface names.
     */
    public static function findExtendedInterfaceNames(File $phpcsFile, $stackPtr)
    {
        return self::findNames(
            $phpcsFile,
            $stackPtr,
            \T_EXTENDS,
            [\T_INTERFACE => \T_INTERFACE]
        );
    }

    /**
     * Retrieves the names of the extended classes or interfaces or the implemented
     * interfaces that the specific class/interface declaration extends/implements.
     *
     * @since 1.0.0
     *
     * @param \PHP_CodeSniffer\Files\File $phpcsFile  The file where this token was found.
     * @param int                         $stackPtr   The stack position of the
     *                                                class/interface declaration keyword.
     * @param int                         $keyword    The token constant for the keyword to examine.
     *                                                Either `T_EXTENDS` or `T_IMPLEMENTS`.
     * @param array                       $allowedFor Array of OO types for which use of the keyword
     *                                                is allowed.
     *
     * @return array|false Returns an array of names or `FALSE` on error or when the object
     *                     being declared does not extend/implement another object.
     */
    private static function findNames(File $phpcsFile, $stackPtr, $keyword, $allowedFor)
    {
        $tokens = $phpcsFile->getTokens();

        if (isset($tokens[$stackPtr]) === false
            || isset($allowedFor[$tokens[$stackPtr]['code']]) === false
            || isset($tokens[$stackPtr]['scope_opener']) === false
        ) {
            return false;
        }

        $scopeOpener = $tokens[$stackPtr]['scope_opener'];
        $keywordPtr  = $phpcsFile->findNext($keyword, ($stackPtr + 1), $scopeOpener);
        if ($keywordPtr === false) {
            return false;
        }

        $find  = [
            \T_NS_SEPARATOR,
            \T_STRING,
        ];
        $find += Tokens::$emptyTokens;

        $names = [];
        $end   = $keywordPtr;
        do {
            $start = ($end + 1);
            $end   = $phpcsFile->findNext($find, $start, ($scopeOpener + 1), true);
            $name  = GetTokensAsString::noEmpties($phpcsFile, $start, ($end - 1));

            if (\trim($name) !== '') {
                $names[] = $name;
            }
        } while ($tokens[$end]['code'] === \T_COMMA);

        if (empty($names)) {
            return false;
        }

        return $names;
    }
}
