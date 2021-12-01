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
use Magento2\Helpers\PHPCSUtils\BackCompat\BCTokens;

use Magento2\Helpers\PHPCSUtils\Utils\Parentheses;

/**
 * Utility functions for examining use statements.
 *
 * @since 1.0.0
 */
class UseStatements
{

    /**
     * Determine what a T_USE token is used for.
     *
     * @since 1.0.0
     *
     * @param \PHP_CodeSniffer\Files\File $phpcsFile The file being scanned.
     * @param int                         $stackPtr  The position of the `T_USE` token.
     *
     * @return string Either `'closure'`, `'import'` or `'trait'`.
     *                An empty string will be returned if the token is used in an
     *                invalid context or if it couldn't be reliably determined what
     *                the `T_USE` token is used for. An empty string being returned will
     *                normally mean the code being examined contains a parse error.
     *
     * @throws \PHP_CodeSniffer\Exceptions\RuntimeException If the specified position is not a
     *                                                      `T_USE` token.
     */
    public static function getType(File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();

        if (isset($tokens[$stackPtr]) === false
            || $tokens[$stackPtr]['code'] !== \T_USE
        ) {
            throw new RuntimeException('$stackPtr must be of type T_USE');
        }

        $next = $phpcsFile->findNext(Tokens::$emptyTokens, ($stackPtr + 1), null, true);
        if ($next === false) {
            // Live coding or parse error.
            return '';
        }

        $prev = $phpcsFile->findPrevious(Tokens::$emptyTokens, ($stackPtr - 1), null, true);
        if ($prev !== false && $tokens[$prev]['code'] === \T_CLOSE_PARENTHESIS
            && Parentheses::isOwnerIn($phpcsFile, $prev, \T_CLOSURE) === true
        ) {
            return 'closure';
        }

        $lastCondition = Conditions::getLastCondition($phpcsFile, $stackPtr);
        if ($lastCondition === false || $tokens[$lastCondition]['code'] === \T_NAMESPACE) {
            // Global or scoped namespace and not a closure use statement.
            return 'import';
        }

        $traitScopes = BCTokens::ooScopeTokens();
        // Only classes and traits can import traits.
        unset($traitScopes[\T_INTERFACE]);

        if (isset($traitScopes[$tokens[$lastCondition]['code']]) === true) {
            return 'trait';
        }

        return '';
    }

    /**
     * Determine whether a T_USE token represents a closure use statement.
     *
     * @since 1.0.0
     *
     * @param \PHP_CodeSniffer\Files\File $phpcsFile The file being scanned.
     * @param int                         $stackPtr  The position of the `T_USE` token.
     *
     * @return bool `TRUE` if the token passed is a closure use statement.
     *              `FALSE` if it's not.
     *
     * @throws \PHP_CodeSniffer\Exceptions\RuntimeException If the specified position is not a
     *                                                      `T_USE` token.
     */
    public static function isClosureUse(File $phpcsFile, $stackPtr)
    {
        return (self::getType($phpcsFile, $stackPtr) === 'closure');
    }

    /**
     * Determine whether a T_USE token represents a class/function/constant import use statement.
     *
     * @since 1.0.0
     *
     * @param \PHP_CodeSniffer\Files\File $phpcsFile The file being scanned.
     * @param int                         $stackPtr  The position of the `T_USE` token.
     *
     * @return bool `TRUE` if the token passed is an import use statement.
     *              `FALSE` if it's not.
     *
     * @throws \PHP_CodeSniffer\Exceptions\RuntimeException If the specified position is not a
     *                                                      `T_USE` token.
     */
    public static function isImportUse(File $phpcsFile, $stackPtr)
    {
        return (self::getType($phpcsFile, $stackPtr) === 'import');
    }

    /**
     * Determine whether a T_USE token represents a trait use statement.
     *
     * @since 1.0.0
     *
     * @param \PHP_CodeSniffer\Files\File $phpcsFile The file being scanned.
     * @param int                         $stackPtr  The position of the `T_USE` token.
     *
     * @return bool `TRUE` if the token passed is a trait use statement.
     *              `FALSE` if it's not.
     *
     * @throws \PHP_CodeSniffer\Exceptions\RuntimeException If the specified position is not a
     *                                                      `T_USE` token.
     */
    public static function isTraitUse(File $phpcsFile, $stackPtr)
    {
        return (self::getType($phpcsFile, $stackPtr) === 'trait');
    }

    /**
     * Split an import use statement into individual imports.
     *
     * Handles single import, multi-import and group-import use statements.
     *
     * @since 1.0.0
     *
     * @param \PHP_CodeSniffer\Files\File $phpcsFile The file where this token was found.
     * @param int                         $stackPtr  The position in the stack of the `T_USE` token.
     *
     * @return array A multi-level array containing information about the use statement.
     *               The first level is `'name'`, `'function'` and `'const'`. These keys will always exist.
     *               If any statements are found for any of these categories, the second level
     *               will contain the alias/name as the key and the full original use name as the
     *               value for each of the found imports or an empty array if no imports were found
     *               in this use statement for a particular category.
     *
     *               For example, for this function group use statement:
     *               ```php
     *               use function Vendor\Package\{
     *                   LevelA\Name as Alias,
     *                   LevelB\Another_Name,
     *               };
     *               ```
     *               the return value would look like this:
     *               ```php
     *               array(
     *                 'name'     => array(),
     *                 'function' => array(
     *                   'Alias'        => 'Vendor\Package\LevelA\Name',
     *                   'Another_Name' => 'Vendor\Package\LevelB\Another_Name',
     *                 ),
     *                 'const'    => array(),
     *               )
     *               ```
     *
     * @throws \PHP_CodeSniffer\Exceptions\RuntimeException If the specified position is not a
     *                                                      `T_USE` token.
     * @throws \PHP_CodeSniffer\Exceptions\RuntimeException If the `T_USE` token is not for an import
     *                                                      use statement.
     */
    public static function splitImportUseStatement(File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();

        if (isset($tokens[$stackPtr]) === false || $tokens[$stackPtr]['code'] !== \T_USE) {
            throw new RuntimeException('$stackPtr must be of type T_USE');
        }

        if (self::isImportUse($phpcsFile, $stackPtr) === false) {
            throw new RuntimeException('$stackPtr must be an import use statement');
        }

        $statements = [
            'name'     => [],
            'function' => [],
            'const'    => [],
        ];

        $endOfStatement = $phpcsFile->findNext([\T_SEMICOLON, \T_CLOSE_TAG], ($stackPtr + 1));
        if ($endOfStatement === false) {
            // Live coding or parse error.
            return $statements;
        }

        $endOfStatement++;

        $start     = true;
        $useGroup  = false;
        $hasAlias  = false;
        $baseName  = '';
        $name      = '';
        $type      = '';
        $fixedType = false;
        $alias     = '';

        for ($i = ($stackPtr + 1); $i < $endOfStatement; $i++) {
            if (isset(Tokens::$emptyTokens[$tokens[$i]['code']]) === true) {
                continue;
            }

            $tokenCode = $tokens[$i]['code'];

            /*
             * BC: Work round a tokenizer bug related to a parse error.
             *
             * If `function` or `const` is used as the alias, the semi-colon after it would
             * be tokenized as T_STRING.
             * For `function` this was fixed in PHPCS 2.8.0. For `const` the issue still exists
             * in PHPCS 3.5.2.
             *
             * Along the same lines, the `}` T_CLOSE_USE_GROUP would also be tokenized as T_STRING.
             */
            if ($tokenCode === \T_STRING) {
                if ($tokens[$i]['content'] === ';') {
                    $tokenCode = \T_SEMICOLON;
                } elseif ($tokens[$i]['content'] === '}') {
                    $tokenCode = \T_CLOSE_USE_GROUP;
                }
            }

            switch ($tokenCode) {
                case \T_STRING:
                    // Only when either at the start of the statement or at the start of a new sub within a group.
                    if ($start === true && $fixedType === false) {
                        $content = \strtolower($tokens[$i]['content']);
                        if ($content === 'function'
                            || $content === 'const'
                        ) {
                            $type  = $content;
                            $start = false;
                            if ($useGroup === false) {
                                $fixedType = true;
                            }

                            break;
                        } else {
                            $type = 'name';
                        }
                    }

                    $start = false;

                    if ($hasAlias === false) {
                        $name .= $tokens[$i]['content'];
                    }

                    $alias = $tokens[$i]['content'];
                    break;

                case \T_AS:
                    $hasAlias = true;
                    break;

                case \T_OPEN_USE_GROUP:
                    $start    = true;
                    $useGroup = true;
                    $baseName = $name;
                    $name     = '';
                    break;

                case \T_SEMICOLON:
                case \T_CLOSE_TAG:
                case \T_CLOSE_USE_GROUP:
                case \T_COMMA:
                    if ($name !== '') {
                        if ($useGroup === true) {
                            $statements[$type][$alias] = $baseName . $name;
                        } else {
                            $statements[$type][$alias] = $name;
                        }
                    }

                    if ($tokenCode !== \T_COMMA) {
                        break 2;
                    }

                    // Reset.
                    $start    = true;
                    $name     = '';
                    $hasAlias = false;
                    if ($fixedType === false) {
                        $type = '';
                    }
                    break;

                case \T_NS_SEPARATOR:
                    $name .= $tokens[$i]['content'];
                    break;

                case \T_FUNCTION:
                case \T_CONST:
                    /*
                     * BC: Work around tokenizer bug in PHPCS < 3.4.1.
                     *
                     * `function`/`const` in `use function`/`use const` tokenized as T_FUNCTION/T_CONST
                     * instead of T_STRING when there is a comment between the keywords.
                     *
                     * @link https://github.com/squizlabs/PHP_CodeSniffer/issues/2431
                     */
                    if ($start === true && $fixedType === false) {
                        $type  = \strtolower($tokens[$i]['content']);
                        $start = false;
                        if ($useGroup === false) {
                            $fixedType = true;
                        }

                        break;
                    }

                    $start = false;

                    if ($hasAlias === false) {
                        $name .= $tokens[$i]['content'];
                    }

                    $alias = $tokens[$i]['content'];
                    break;

                /*
                 * Fall back in case reserved keyword is (illegally) used in name.
                 * Parse error, but not our concern.
                 */
                default:
                    if ($hasAlias === false) {
                        $name .= $tokens[$i]['content'];
                    }

                    $alias = $tokens[$i]['content'];
                    break;
            }
        }

        return $statements;
    }

    /**
     * Split an import use statement into individual imports and merge it with an array of previously
     * seen import use statements.
     *
     * Beware: this method should only be used to combine the import use statements found in *one* file.
     * Do NOT combine the statements of multiple files as the result will be inaccurate and unreliable.
     *
     * In most cases when tempted to use this method, the {@see \PHPCSUtils\AbstractSniffs\AbstractFileContextSniff}
     * (upcoming) should be used instead.
     *
     * @see \PHPCSUtils\AbstractSniffs\AbstractFileContextSniff
     * @see \PHPCSUtils\Utils\UseStatements::splitImportUseStatement()
     *
     * @since 1.0.0-alpha3
     *
     * @param \PHP_CodeSniffer\Files\File $phpcsFile             The file where this token was found.
     * @param int                         $stackPtr              The position in the stack of the `T_USE` token.
     * @param array                       $previousUseStatements The import `use` statements collected so far.
     *                                                           This should be either the output of a
     *                                                           previous call to this method or the output of
     *                                                           an earlier call to the
     *                                                           {@see UseStatements::splitImportUseStatement()}
     *                                                           method.
     *
     * @return array A multi-level array containing information about the current `use` statement combined with
     *               the previously collected `use` statement information.
     *               See {@see UseStatements::splitImportUseStatement()} for more details about the array format.
     */
    public static function splitAndMergeImportUseStatement(File $phpcsFile, $stackPtr, $previousUseStatements)
    {
        try {
            $useStatements = self::splitImportUseStatement($phpcsFile, $stackPtr);

            if (isset($previousUseStatements['name']) === false) {
                $previousUseStatements['name'] = $useStatements['name'];
            } else {
                $previousUseStatements['name'] += $useStatements['name'];
            }
            if (isset($previousUseStatements['function']) === false) {
                $previousUseStatements['function'] = $useStatements['function'];
            } else {
                $previousUseStatements['function'] += $useStatements['function'];
            }
            if (isset($previousUseStatements['const']) === false) {
                $previousUseStatements['const'] = $useStatements['const'];
            } else {
                $previousUseStatements['const'] += $useStatements['const'];
            }
        } catch (RuntimeException $e) {
            // Not an import use statement.
        }

        return $previousUseStatements;
    }
}
