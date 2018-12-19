<?php
/**
 * Copyright © Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\Sniffs\Performance;

use PHP_CodeSniffer\Sniffs\Sniff;
use PHP_CodeSniffer\Files\File;

/**
 * Allows easily detect wrong approach for checking empty variables in conditions.
 */
class EmptyCheckSniff implements Sniff
{
    /**
     * Violation severity.
     *
     * @var int
     */
    protected $severity = 8;

    /**
     * Mapping for function's code and message.
     *
     * @var array
     */

    protected $map = [
        'count' => [
            // phpcs:ignore Generic.Files.LineLength.TooLong
            'message' => 'count(...) function should not be used to check if array is empty. Use empty(...) language construct instead',
            'code' => 'FoundCount'
        ],
        'strlen' => [
            // phpcs:ignore Generic.Files.LineLength.TooLong
            'message' => 'strlen(...) function should not be used to check if string is empty. Consider replace with (=/!)== ""',
            'code' => 'FoundStrlen'
        ],
    ];


    /**
     * All tokens from current file.
     *
     * @var array
     */
    private $tokens;

    /**
     * List of comparison operators that are used to check if statement is empty.
     *
     * @var array
     */
    protected $comparisonOperators = [
        T_GREATER_THAN,
        T_IS_NOT_IDENTICAL,
        T_IS_NOT_EQUAL
    ];

    /**
     * List of all other comparison operators that can follow the statement.
     *
     * @var array
     */
    protected $otherComparisonOperators = [
        T_IS_GREATER_OR_EQUAL,
        T_LESS_THAN,
        T_IS_SMALLER_OR_EQUAL,
        T_IS_IDENTICAL,
        T_IS_EQUAL
    ];

    /**
     * List of logic operators that show an end of condition.
     *
     * @var array
     */
    protected $logicOperators = [
        T_BOOLEAN_AND,
        T_BOOLEAN_OR,
        T_LOGICAL_AND,
        T_LOGICAL_OR
    ];

    /**
     * @inheritdoc
     */
    public function register()
    {
        return [T_IF, T_ELSEIF];
    }

    /**
     * @inheritdoc
     */
    public function process(File $phpcsFile, $stackPtr)
    {
        $this->tokens = $phpcsFile->getTokens();
        $functionPosition = $this->findFunctionPosition($stackPtr);
        if ($functionPosition !== false
            && array_key_exists('nested_parenthesis', $this->tokens[$functionPosition])
        ) {
            $openParenthesisPosition = key($this->tokens[$functionPosition]['nested_parenthesis']);
            $endOfStatementPosition = $this->tokens[$openParenthesisPosition]['parenthesis_closer'];
            $nextOperatorPosition = $phpcsFile->findNext(
                $this->logicOperators,
                $functionPosition,
                $endOfStatementPosition
            );
            if ($nextOperatorPosition !== false) {
                $endOfStatementPosition = $nextOperatorPosition;
            }
            $operatorPosition = $phpcsFile->findNext(
                $this->comparisonOperators,
                $functionPosition,
                $endOfStatementPosition
            );
            $code = $this->map[$this->tokens[$functionPosition]['content']]['code'];
            $message = $this->map[$this->tokens[$functionPosition]['content']]['message'];
            if ($operatorPosition !== false) {
                if ($phpcsFile->findNext(T_LNUMBER, $operatorPosition, $endOfStatementPosition, false, '0') !== false) {
                    $phpcsFile->addWarning($message, $stackPtr, $code, [], $this->severity);
                }
            } else {
                // phpcs:ignore Generic.Files.LineLength.TooLong
                if ($phpcsFile->findNext($this->otherComparisonOperators, $functionPosition, $endOfStatementPosition) === false) {
                    $phpcsFile->addWarning($message, $stackPtr, $code, [], $this->severity);
                }
            }
        }
    }

    /**
     * Find the position of discouraged function between parenthesis.
     *
     * @param int $index
     * @return mixed
     */
    private function findFunctionPosition($index)
    {
        // phpcs:ignore Generic.Files.LineLength.TooLong
        for ($i = $this->tokens[$index]['parenthesis_opener'] + 1; $i < $this->tokens[$index]['parenthesis_closer']; $i++) {
            if (array_key_exists($this->tokens[$i]['content'], $this->map)) {
                return $i;
            }
        }
        return false;
    }
}
