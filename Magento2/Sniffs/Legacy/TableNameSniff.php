<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types = 1);

namespace Magento2\Sniffs\Legacy;

use PHP_CodeSniffer\Sniffs\Sniff;
use PHP_CodeSniffer\Files\File;

/**
 * Coverage of obsolete table names usage
 */
class TableNameSniff implements Sniff
{
    /**
     * Methods which receive table names as parameters, with the argument position in which table names are passed
     *
     * @var array
     */
    private $argPositionInMethods = [
        'getTableName' => [0],
        '_setMainTable' => [0],
        'setMainTable' => [0],
        'getTable' => [0],
        'setTable' => [0],
        'getTableRow' => [0],
        'deleteTableRow' => [0],
        'updateTableRow' => [0],
        'updateTable' => [0],
        'tableExists' => [0],
        'joinField' => [1],
        'joinTable' => [0],
        'getFkName' => [0, 2],
        'getIdxName' => [0],
        'addVirtualGridColumn' => [1],
    ];

    /**
     * String representation of error.
     *
     * @var string
     */
    private const ERROR_MESSAGE = 'Legacy table names with slash must be fixed to direct table names. Found: %s';

    /**
     * Error violation code.
     *
     * @var string
     */
    private const ERROR_CODE = 'FoundLegacyTableName';

    /**
     * @inheritdoc
     */
    public function register()
    {
        return [
            T_OBJECT_OPERATOR,
            T_VARIABLE,
            T_DOUBLE_ARROW
        ];
    }

    /**
     * @inheritdoc
     */
    public function process(File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();
        if ($tokens[$stackPtr]['code'] === T_OBJECT_OPERATOR) {
            $this->checkOccurrencesInMethods($phpcsFile, $stackPtr, $tokens);
        } elseif ($tokens[$stackPtr]['code'] === T_DOUBLE_ARROW) {
            $this->checkOccurrencesInArray($phpcsFile, $stackPtr, $tokens);
        } else {
            $this->checkOccurrencesInProperty($phpcsFile, $stackPtr, $tokens);
        }
    }

    /**
     * Check if passed file is a resource but not a collection
     *
     * @param string $filePath
     * @return bool
     */
    private function isResourceButNotCollection(string $filePath): bool
    {
        $filePath = str_replace('\\', '/', $filePath);
        $parts = explode('/', $filePath);
        return array_search('Resource', $parts) !== false && array_search('Collection.php', $parts) === false;
    }

    /**
     * Check references to table names in methods
     *
     * @param File $phpcsFile
     * @param int $stackPtr
     * @param array $tokens
     */
    private function checkOccurrencesInMethods(File $phpcsFile, int $stackPtr, array $tokens): void
    {
        $methodNamePos = $phpcsFile->findNext(T_STRING, $stackPtr + 1);
        $methodName = $tokens[$methodNamePos]['content'];
        if (array_key_exists($methodName, $this->argPositionInMethods) === false) {
            return;
        }
        $firstArgumentPos = $phpcsFile->findNext([T_CONSTANT_ENCAPSED_STRING, T_VARIABLE], $methodNamePos + 1);

        foreach ($this->argPositionInMethods[$methodName] as $argPosition) {
            $paramPos = $firstArgumentPos;
            for ($i = 0; $i < $argPosition; $i++) {
                $paramPos = $phpcsFile->findNext(
                    [T_CONSTANT_ENCAPSED_STRING, T_VARIABLE],
                    $paramPos + 1,
                    $phpcsFile->findNext(T_CLOSE_PARENTHESIS, $paramPos + 1)
                );
            }
            if (strpos($tokens[$paramPos]['content'], '/') !== false) {
                $phpcsFile->addError(
                    sprintf(
                        self::ERROR_MESSAGE,
                        $tokens[$paramPos]['content'],
                    ),
                    $paramPos,
                    self::ERROR_CODE
                );
            }
        }

        if ($this->isResourceButNotCollection($phpcsFile->getFilename())) {
            if ($tokens[$stackPtr]['content'] !== '_init') {
                return;
            }

            $paramPos = $phpcsFile->findNext(T_PARAM_NAME, $stackPtr + 1);
            if (strpos($tokens[$paramPos]['content'], '/') !== false) {
                $phpcsFile->addError(
                    sprintf(
                        self::ERROR_MESSAGE,
                        $tokens[$paramPos]['content'],
                    ),
                    $paramPos,
                    self::ERROR_CODE
                );
            }
        }
    }

    /**
     * Check references to table names in the $_aggregationTable property
     *
     * @param File $phpcsFile
     * @param int $stackPtr
     * @param array $tokens
     */
    private function checkOccurrencesInProperty(File $phpcsFile, int $stackPtr, array $tokens): void
    {
        if ($methodName = $tokens[$stackPtr]['content'] !== '$_aggregationTable') {
            return;
        }

        $tableNamePos = $phpcsFile->findNext(
            T_CONSTANT_ENCAPSED_STRING,
            $stackPtr + 1,
            $phpcsFile->findEndOfStatement($stackPtr + 1)
        );

        if (strpos($tokens[$tableNamePos]['content'], '/') !== false) {
            $phpcsFile->addError(
                sprintf(
                    self::ERROR_MESSAGE,
                    $tokens[$tableNamePos]['content'],
                ),
                $tableNamePos,
                self::ERROR_CODE
            );
        }
    }

    /**
     * Check references to table names in arrays
     *
     * @param File $phpcsFile
     * @param int $stackPtr
     * @param array $tokens
     */
    private function checkOccurrencesInArray(File $phpcsFile, int $stackPtr, array $tokens): void
    {
        $aliasPos = $phpcsFile->findPrevious(
            T_WHITESPACE,
            $stackPtr - 1,
            null,
            true,
        );

        $alias = trim($tokens[$aliasPos]['content'], '\'"');

        if ($this->endsWith($alias, '_table') === false) {
            return;
        }

        $tableNamePos = $phpcsFile->findNext(
            T_CONSTANT_ENCAPSED_STRING,
            $aliasPos + 1
        );

        if (strpos($tokens[$tableNamePos]['content'], '/') !== false) {
            $phpcsFile->addError(
                sprintf(
                    self::ERROR_MESSAGE,
                    $tokens[$tableNamePos]['content'],
                ),
                $tableNamePos,
                self::ERROR_CODE
            );
        }
    }

    /**
     * Checks if $haystack ends with $needle
     *
     * @param string $haystack
     * @param string $needle
     * @return bool
     */
    private function endsWith(string $haystack, string $needle): bool
    {
        $length = strlen($needle);
        if ($length === 0) {
            return true;
        }
        return substr($haystack, -$length) === $needle;
    }
}
