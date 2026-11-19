<?php
/**
 * Copyright 2019 Adobe
 * All Rights Reserved.
 */
namespace Magento2\Sniffs\Performance;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;
use PHP_CodeSniffer\Util\Tokens;
use PHPCSUtils\Utils\PassedParameters;

/**
 * Detects array_merge(...) accumulating into its own target inside a loop, which turns
 * the loop into a quadratic construction.
 */
class ForeachArrayMergeSniff implements Sniff
{
    /**
     * Tokens that terminate the expression preceding an assignment operator.
     *
     * @var array
     */
    private const EXPRESSION_BOUNDARIES = [
        T_SEMICOLON,
        T_OPEN_CURLY_BRACKET,
        T_CLOSE_CURLY_BRACKET,
        T_OPEN_PARENTHESIS,
        T_CLOSE_PARENTHESIS,
        T_COMMA,
        T_OPEN_TAG,
        T_INLINE_THEN,
        T_INLINE_ELSE,
        T_EQUAL,
        T_DOUBLE_ARROW,
    ];

    /**
     * Tokens that mean the array_merge string is not a global function call.
     *
     * @var array
     */
    private const NOT_A_FUNCTION_CALL = [
        T_OBJECT_OPERATOR,
        T_NULLSAFE_OBJECT_OPERATOR,
        T_DOUBLE_COLON,
        T_FUNCTION,
        T_NEW,
    ];

    /**
     * String representation of warning.
     *
     * @var string
     */
    protected $warningMessage = 'array_merge(...) is used in a loop and is a resources greedy construction.';

    /**
     * Warning violation code.
     *
     * @var string
     */
    protected $warningCode = 'ForeachArrayMerge';

    /**
     * @var array
     */
    protected $foreachCache = [];

    /**
     * @inheritdoc
     */
    public function register()
    {
        return [T_FOREACH, T_FOR, T_WHILE, T_DO];
    }

    /**
     * @inheritdoc
     */
    public function process(File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();

        // If it's inline control structure we do nothing. PSR2 issue will be raised.
        // The `while` of a do-while has no scope of its own, the T_DO body is checked instead.
        if (!array_key_exists('scope_opener', $tokens[$stackPtr])) {
            return;
        }
        $scopeOpener = $tokens[$stackPtr]['scope_opener'];
        $scopeCloser = $tokens[$stackPtr]['scope_closer'];

        for ($i = $scopeOpener; $i < $scopeCloser; $i++) {
            $tag = $tokens[$i];
            if ($tag['code'] !== T_STRING) {
                continue;
            }
            if ($tag['content'] !== 'array_merge') {
                continue;
            }
            if (!$this->isFunctionCall($phpcsFile, $i)) {
                continue;
            }
            // Let the innermost loop containing the call report it, so that the iteration
            // the array actually grows on is the one being looked at.
            if ($this->getInnermostLoop($phpcsFile, $i) !== $stackPtr) {
                continue;
            }

            $cacheKey = $phpcsFile->getFilename() . $i;
            if (isset($this->foreachCache[$cacheKey])) {
                continue;
            }
            $this->foreachCache[$cacheKey] = '';

            $target = $this->getAssignmentTarget($phpcsFile, $i);
            if (!$this->isAccumulator($phpcsFile, $i, $target)) {
                continue;
            }
            if ($target !== null && $this->isOverwrittenEachIteration($phpcsFile, $i, $stackPtr, $target)) {
                continue;
            }

            $phpcsFile->addWarning($this->warningMessage, $i, $this->warningCode);
        }
    }

    /**
     * Pointer of the innermost loop the token belongs to, or null when there is none.
     *
     * @param File $phpcsFile
     * @param int $stackPtr
     * @return int|null
     */
    private function getInnermostLoop(File $phpcsFile, int $stackPtr): ?int
    {
        $conditions = $phpcsFile->getTokens()[$stackPtr]['conditions'] ?? [];

        $loop = null;
        foreach ($conditions as $pointer => $code) {
            if (in_array($code, [T_FOREACH, T_FOR, T_WHILE, T_DO], true)) {
                $loop = $pointer;
            }
        }

        return $loop;
    }

    /**
     * Whether the array_merge token is a call to the global function.
     *
     * @param File $phpcsFile
     * @param int $stackPtr
     * @return bool
     */
    private function isFunctionCall(File $phpcsFile, int $stackPtr): bool
    {
        $tokens = $phpcsFile->getTokens();

        $next = $phpcsFile->findNext(Tokens::$emptyTokens, $stackPtr + 1, null, true);
        if ($next === false || $tokens[$next]['code'] !== T_OPEN_PARENTHESIS) {
            return false;
        }

        $previous = $phpcsFile->findPrevious(Tokens::$emptyTokens, $stackPtr - 1, null, true);

        return $previous === false || !in_array($tokens[$previous]['code'], self::NOT_A_FUNCTION_CALL, true);
    }

    /**
     * Whether the result of the call is merged back into one of its own arguments.
     *
     * Only that shape grows the array on every iteration. `$row = array_merge($defaults, $data);`
     * inside a loop allocates a constant amount of memory and is not reported.
     *
     * @param File $phpcsFile
     * @param int $stackPtr
     * @param string|null $target
     * @return bool
     */
    private function isAccumulator(File $phpcsFile, int $stackPtr, ?string $target): bool
    {
        $arguments = $this->getArguments($phpcsFile, $stackPtr);
        if ($arguments === []) {
            return false;
        }

        if ($target !== null) {
            return in_array($target, $arguments, true);
        }

        return $this->isAccumulatedThroughSetter($phpcsFile, $stackPtr, $arguments);
    }

    /**
     * Whether the accumulator is unconditionally reassigned earlier in the same iteration.
     *
     * `$ids = array_column($rows, 'id'); $ids = array_merge($ids, $extra);` inside a loop starts
     * from scratch on every iteration, so nothing grows and there is nothing to report.
     *
     * @param File $phpcsFile
     * @param int $stackPtr
     * @param int $loopPtr
     * @param string $target
     * @return bool
     */
    private function isOverwrittenEachIteration(
        File $phpcsFile,
        int $stackPtr,
        int $loopPtr,
        string $target
    ): bool {
        $tokens = $phpcsFile->getTokens();

        if ($this->isForeachValue($phpcsFile, $loopPtr, $target)) {
            return true;
        }

        $level = $tokens[$stackPtr]['level'];
        $statementStart = $phpcsFile->findPrevious([T_SEMICOLON, T_OPEN_CURLY_BRACKET], $stackPtr - 1);
        if ($statementStart === false) {
            return false;
        }

        for ($i = $tokens[$loopPtr]['scope_opener'] + 1; $i < $statementStart; $i++) {
            if ($tokens[$i]['code'] !== T_EQUAL || $tokens[$i]['level'] !== $level) {
                continue;
            }
            $start = $phpcsFile->findPrevious(self::EXPRESSION_BOUNDARIES, $i - 1);
            $start = $start === false ? 0 : $start + 1;
            if ($this->normalize($phpcsFile, $start, $i - 1) !== $target) {
                continue;
            }
            // Another `$target = array_merge($target, ...)` above is part of the same
            // accumulation, not a fresh start.
            $value = $phpcsFile->findNext(Tokens::$emptyTokens, $i + 1, null, true);
            if ($value !== false
                && $tokens[$value]['code'] === T_STRING
                && $tokens[$value]['content'] === 'array_merge'
                && $this->isAccumulator($phpcsFile, $value, $target)
            ) {
                continue;
            }

            return true;
        }

        return false;
    }

    /**
     * Whether the target is the value or key variable of the given foreach, reset on each iteration.
     *
     * @param File $phpcsFile
     * @param int $loopPtr
     * @param string $target
     * @return bool
     */
    private function isForeachValue(File $phpcsFile, int $loopPtr, string $target): bool
    {
        $tokens = $phpcsFile->getTokens();

        if ($tokens[$loopPtr]['code'] !== T_FOREACH) {
            return false;
        }
        $as = $phpcsFile->findNext(
            T_AS,
            $tokens[$loopPtr]['parenthesis_opener'] + 1,
            $tokens[$loopPtr]['parenthesis_closer']
        );
        if ($as === false) {
            return false;
        }

        $assigned = $this->normalize($phpcsFile, $as + 1, $tokens[$loopPtr]['parenthesis_closer'] - 1);
        foreach (explode('=>', $assigned) as $variable) {
            if (ltrim($variable, '&') === $target) {
                return true;
            }
        }

        return false;
    }

    /**
     * Normalized textual representation of every argument passed to the call.
     *
     * @param File $phpcsFile
     * @param int $stackPtr
     * @return string[]
     */
    private function getArguments(File $phpcsFile, int $stackPtr): array
    {
        $parameters = PassedParameters::getParameters($phpcsFile, $stackPtr);

        $arguments = [];
        foreach ($parameters as $parameter) {
            $arguments[] = $this->normalize($phpcsFile, $parameter['start'], $parameter['end']);
        }

        return $arguments;
    }

    /**
     * Normalized textual representation of the variable the call result is assigned to.
     *
     * @param File $phpcsFile
     * @param int $stackPtr
     * @return string|null
     */
    private function getAssignmentTarget(File $phpcsFile, int $stackPtr): ?string
    {
        $tokens = $phpcsFile->getTokens();

        $assignment = $phpcsFile->findPrevious(Tokens::$emptyTokens, $stackPtr - 1, null, true);
        if ($assignment === false || $tokens[$assignment]['code'] !== T_EQUAL) {
            return null;
        }

        $start = $phpcsFile->findPrevious(self::EXPRESSION_BOUNDARIES, $assignment - 1);
        $start = $start === false ? 0 : $start + 1;

        $target = $this->normalize($phpcsFile, $start, $assignment - 1);

        return $target === '' ? null : $target;
    }

    /**
     * Whether the call result is passed to a setter that is fed by a getter on the same object.
     *
     * Covers `$builder->setColumns(array_merge($builder->getColumns(), $columns));`
     *
     * @param File $phpcsFile
     * @param int $stackPtr
     * @param string[] $arguments
     * @return bool
     */
    private function isAccumulatedThroughSetter(File $phpcsFile, int $stackPtr, array $arguments): bool
    {
        $tokens = $phpcsFile->getTokens();

        $nested = $tokens[$stackPtr]['nested_parenthesis'] ?? [];
        if ($nested === []) {
            return false;
        }
        $outerOpener = array_key_last($nested);

        $methodName = $phpcsFile->findPrevious(Tokens::$emptyTokens, $outerOpener - 1, null, true);
        if ($methodName === false || $tokens[$methodName]['code'] !== T_STRING) {
            return false;
        }
        $operator = $phpcsFile->findPrevious(Tokens::$emptyTokens, $methodName - 1, null, true);
        if ($operator === false
            || !in_array($tokens[$operator]['code'], [T_OBJECT_OPERATOR, T_NULLSAFE_OBJECT_OPERATOR], true)
        ) {
            return false;
        }

        $start = $phpcsFile->findPrevious(self::EXPRESSION_BOUNDARIES, $operator - 1);
        $start = $start === false ? 0 : $start + 1;
        $object = $this->normalize($phpcsFile, $start, $operator - 1);
        if ($object === '') {
            return false;
        }

        foreach ($arguments as $argument) {
            if (strpos($argument, $object . '->') === 0 || strpos($argument, $object . '?->') === 0) {
                return true;
            }
        }

        return false;
    }

    /**
     * Content of a token range with whitespace and comments stripped.
     *
     * @param File $phpcsFile
     * @param int $start
     * @param int $end
     * @return string
     */
    private function normalize(File $phpcsFile, int $start, int $end): string
    {
        $tokens = $phpcsFile->getTokens();

        $content = '';
        for ($i = $start; $i <= $end; $i++) {
            if (!isset($tokens[$i]) || isset(Tokens::$emptyTokens[$tokens[$i]['code']])) {
                continue;
            }
            $content .= $tokens[$i]['content'];
        }

        return $content;
    }
}
