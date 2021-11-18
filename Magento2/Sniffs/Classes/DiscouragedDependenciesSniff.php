<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento2\Sniffs\Classes;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

/**
 * Detects explicit request of proxies and interceptors in constructors
 *
 * Search is in variable names and namespaces, including indirect namespaces from use statements
 */
class DiscouragedDependenciesSniff implements Sniff
{
    private const CONSTRUCT_METHOD_NAME = '__construct';

    /**
     * String representation of warning.
     *
     * @var string
     */
    protected $warningMessage = 'Proxies and interceptors MUST never be explicitly requested in constructors.';

    /**
     * Warning violation code.
     *
     * @var string
     */
    protected $warningCode = 'ConstructorProxyInterceptor';

    /**
     * @var string[]
     */
    private $aliases = [];

    /**
     * @var null|string
     */
    private $currentFile = null;

    /**
     * @var string[]
     */
    public $incorrectClassNames = ['proxy','interceptor'];

    /**
     * @inheritDoc
     */
    public function register()
    {
        return [
            T_USE,
            T_FUNCTION
        ];
    }

    /**
     * @inheritDoc
     */
    public function process(File $phpcsFile, $stackPtr)
    {
        // Clear down aliases when file under test changes
        $currentFileName = $phpcsFile->getFilename();
        if ($this->currentFile != $currentFileName) {
            // Clear aliases
            $this->aliases = [];
            $this->currentFile = $currentFileName;
        }

        // Match use statements and constructor (latter matches T_FUNCTION to find constructors)
        $tokens = $phpcsFile->getTokens();

        if ($tokens[$stackPtr]['code'] == T_USE) {
            $this->processUse($phpcsFile, $stackPtr, $tokens);
        } elseif ($tokens[$stackPtr]['code'] == T_FUNCTION) {
            $this->processFunction($phpcsFile, $stackPtr, $tokens);
        }
    }

    /**
     * Store plugin/proxy class names for use in matching constructor
     *
     * @param File $phpcsFile
     * @param int $stackPtr
     * @param array $tokens
     */
    private function processUse(
        File $phpcsFile,
        $stackPtr,
        $tokens
    ) {
        // Find end of use statement and position of AS alias if exists
        $endPos = $phpcsFile->findNext(T_SEMICOLON, $stackPtr);
        $asPos = $phpcsFile->findNext(T_AS, $stackPtr, $endPos);
        // Find whether this use statement includes any of the warning words
        $includesWarnWord =
            $this->includesWarnWordsInSTRINGs(
                $phpcsFile,
                $stackPtr,
                min($asPos, $endPos),
                $tokens,
                $lastWord
            );
        if (! $includesWarnWord) {
            return;
        }
        // If there is an alias then store this explicit alias for matching in constructor
        if ($asPos) {
            $aliasNamePos    = $asPos + 2;
            $this->aliases[] = strtolower($tokens[$aliasNamePos]['content']);
        }
        // Always store last word as alias for checking in constructor
        $this->aliases[] = $lastWord;
    }

    /**
     * If constructor, check for proxy/plugin names and warn
     *
     * @param File $phpcsFile
     * @param int $stackPtr
     * @param array $tokens
     */
    private function processFunction(
        File $phpcsFile,
        $stackPtr,
        $tokens
    ) {
        // Find start and end of constructor signature based on brackets
        if (! $this->getConstructorPosition($phpcsFile, $stackPtr, $tokens, $openParenth, $closeParenth)) {
            return;
        }
        $positionInConstrSig = $openParenth;
        $lastName = null;
        do {
            // Find next part of namespace (string) or variable name
            $positionInConstrSig = $phpcsFile->findNext(
                [T_STRING, T_VARIABLE],
                $positionInConstrSig + 1,
                $closeParenth
            );

            $currentTokenIsString = $tokens[$positionInConstrSig]['code'] == T_STRING;

            if ($currentTokenIsString) {
                // Remember string in case this is last before variable
                $lastName = strtolower($tokens[$positionInConstrSig]['content']);
            } else {
                // If this is a variable, check last word for matches as was end of classname/alias
                if ($lastName !== null) {
                    $namesToWarn = $this->mergedNamesToWarn(true);
                    if ($this->containsWord($namesToWarn, $lastName)) {
                        $phpcsFile->addError(
                            $this->warningMessage,
                            $positionInConstrSig,
                            $this->warningCode,
                            [$lastName]
                        );
                    }
                    $lastName = null;
                }
            }

        } while ($positionInConstrSig !== false && $positionInConstrSig < $closeParenth);
    }

    /**
     * Sets start and end of constructor signature or returns false
     *
     * @param File $phpcsFile
     * @param int $stackPtr
     * @param array $tokens
     * @param int $openParenth
     * @param int $closeParenth
     *
     * @return bool Whether a constructor
     */
    private function getConstructorPosition(
        File $phpcsFile,
        $stackPtr,
        array $tokens,
        &$openParenth,
        &$closeParenth
    ) {
        $methodNamePos = $phpcsFile->findNext(T_STRING, $stackPtr - 1);
        if ($methodNamePos === false) {
            return false;
        }
        // There is a method name
        if ($tokens[$methodNamePos]['content'] != self::CONSTRUCT_METHOD_NAME) {
            return false;
        }

        // KNOWN: There is a constructor, so get position

        $openParenth = $phpcsFile->findNext(T_OPEN_PARENTHESIS, $methodNamePos);
        $closeParenth = $phpcsFile->findNext(T_CLOSE_PARENTHESIS, $openParenth);
        if ($openParenth === false || $closeParenth === false) {
            return false;
        }

        return true;
    }

    /**
     * Whether $name exactly matches any of $haystacks
     *
     * @param array $haystacks
     * @param string $name
     *
     * @return bool
     */
    private function containsWord($haystacks, $name)
    {
        return in_array($name, $haystacks);
    }

    /**
     * Whether warn words are included in STRING tokens in the given range
     *
     * Populates $lastWord in set to get usable name from namespace
     *
     * @param File $phpcsFile
     * @param int $startPosition
     * @param int $endPosition
     * @param array $tokens
     * @param string|null $lastWord
     *
     * @return bool
     */
    private function includesWarnWordsInSTRINGs(
        File $phpcsFile,
        $startPosition,
        $endPosition,
        $tokens,
        &$lastWord
    ) {
        $includesWarnWord = false;
        $currentPosition = $startPosition;
        do {
            $currentPosition = $phpcsFile->findNext(T_STRING, $currentPosition + 1, $endPosition);
            if ($currentPosition !== false) {
                $word = strtolower($tokens[$currentPosition]['content']);
                if ($this->containsWord($this->mergedNamesToWarn(false), $word)) {
                    $includesWarnWord = true;
                }
                $lastWord = $word;
            }
        } while ($currentPosition !== false && $currentPosition < $endPosition);

        return $includesWarnWord;
    }

    /**
     * Get array of names that if matched should raise warning.
     *
     * Includes aliases if required
     *
     * @param bool $includeAliases
     *
     * @return array
     */
    private function mergedNamesToWarn($includeAliases = false)
    {
        $namesToWarn = $this->incorrectClassNames;
        if ($includeAliases) {
            $namesToWarn = array_merge($namesToWarn, $this->aliases);
        }

        return $namesToWarn;
    }
}
