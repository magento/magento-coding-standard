<?php
/**
 * Copyright © Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento2\Sniffs\Security;

use PHP_CodeSniffer\Sniffs\Sniff;
use PHP_CodeSniffer\Files\File;

/**
 * Detects not escaped output in phtml templates.
 */
class XssTemplateSniff implements Sniff
{
    /**
     * String representation of warning.
     *
     * @var string
     */
    protected $warningMessage = 'Unescaped output detected.';

    /**
     * Warning violation code.
     *
     * @var string
     */
    protected $warningCodeUnescaped = 'FoundUnescaped';

    /**
     * Warning violation code.
     *
     * @var string
     */
    protected $warningCodeNotAllowed = 'FoundNotAllowed';

    /**
     * Magento escape methods.
     *
     * @var array
     */
    protected $allowedMethods = [
        'escapeUrl',
        'escapeJsQuote',
        'escapeQuote',
        'escapeXssInUrl',
        'escapeJs',
        'escapeCss',
        'getJsLayout'
    ];

    /**
     * Allowed method name - {suffix}Html{postfix}()
     *
     * @var string
     */
    protected $methodNameContains = 'html';

    /**
     * PHP functions, that no need escaping.
     *
     * @var array
     */
    protected $allowedFunctions = ['count'];

    /**
     * Allowed annotations.
     *
     * @var array
     */
    protected $allowedAnnotations = [
        '@noEscape',
    ];

    /**
     * Warning violation code.
     *
     * @var string
     */
    private $hasDisallowedAnnotation = false;

    /**
     * Parsed statements to check for escaping.
     *
     * @var array
     */
    private $statements = [];

    /**
     * PHP_CodeSniffer file.
     *
     * @var File
     */
    private $file;

    /**
     * All tokens from current file.
     *
     * @var array
     */
    private $tokens;

    /**
     * @inheritdoc
     */
    public function register()
    {
        return [
            T_ECHO,
            T_OPEN_TAG_WITH_ECHO,
            T_PRINT,
        ];
    }

    /**
     * @inheritdoc
     */
    public function process(File $phpcsFile, $stackPtr)
    {
        $this->file = $phpcsFile;
        $this->tokens = $this->file->getTokens();

        $annotation = $this->findSpecialAnnotation($stackPtr);
        if ($annotation !== false) {
            foreach ($this->allowedAnnotations as $allowedAnnotation) {
                if (strpos($this->tokens[$annotation]['content'], $allowedAnnotation) !== false) {
                    return;
                }
            }
            $this->hasDisallowedAnnotation = true;
        }

        $endOfStatement = $phpcsFile->findNext([T_CLOSE_TAG, T_SEMICOLON], $stackPtr);
        $this->addStatement($stackPtr + 1, $endOfStatement);

        while ($this->statements) {
            $statement = array_shift($this->statements);
            $this->detectUnescapedString($statement);
        }
    }

    /**
     * Finds special annotations which are used for mark is output should be escaped.
     *
     * @param int $stackPtr
     * @return int|bool
     */
    private function findSpecialAnnotation($stackPtr)
    {
        if ($this->tokens[$stackPtr]['code'] === T_ECHO) {
            $startOfStatement = $this->file->findPrevious(T_OPEN_TAG, $stackPtr);
            return $this->file->findPrevious(T_COMMENT, $stackPtr, $startOfStatement);
        }
        if ($this->tokens[$stackPtr]['code'] === T_OPEN_TAG_WITH_ECHO) {
            $endOfStatement = $this->file->findNext(T_CLOSE_TAG, $stackPtr);
            return $this->file->findNext(T_COMMENT, $stackPtr, $endOfStatement);
        }
        return false;
    }

    /**
     * Find unescaped statement by following rules:
     *
     * See https://devdocs.magento.com/guides/v2.3/extension-dev-guide/xss-protection.html
     *
     * @param array $statement
     * @return void
     *
     * phpcs:disable Generic.Metrics.CyclomaticComplexity.TooHigh
     */
    private function detectUnescapedString($statement)
    {
        // phpcs:enable
        $posOfFirstElement = $this->file->findNext(
            [T_WHITESPACE, T_COMMENT],
            $statement['start'],
            $statement['end'],
            true
        );
        if ($this->tokens[$posOfFirstElement]['code'] === T_OPEN_PARENTHESIS) {
            $posOfLastElement = $this->file->findPrevious(
                T_WHITESPACE,
                $statement['end'] - 1,
                $statement['start'],
                true
            );
            if ($this->tokens[$posOfFirstElement]['parenthesis_closer'] === $posOfLastElement) {
                $this->addStatement($posOfFirstElement + 1, $this->tokens[$posOfFirstElement]['parenthesis_closer']);
                return;
            }
        }
        if ($this->parseLineStatement($statement['start'], $statement['end'])) {
            return;
        }

        $posOfArithmeticOperator = $this->findNextInScope(
            [T_PLUS, T_MINUS, T_DIVIDE, T_MULTIPLY, T_MODULUS, T_POW],
            $statement['start'],
            $statement['end']
        );
        if ($posOfArithmeticOperator !== false) {
            return;
        }
        switch ($this->tokens[$posOfFirstElement]['code']) {
            case T_STRING:
                if (!in_array($this->tokens[$posOfFirstElement]['content'], $this->allowedFunctions)) {
                    $this->addWarning($posOfFirstElement);
                }
                break;
            case T_START_HEREDOC:
            case T_DOUBLE_QUOTED_STRING:
                $this->addWarning($posOfFirstElement);
                break;
            case T_VARIABLE:
                $posOfObjOperator = $this->findLastInScope(T_OBJECT_OPERATOR, $posOfFirstElement, $statement['end']);
                if ($posOfObjOperator === false) {
                    $this->addWarning($posOfFirstElement);
                    break;
                }
                $posOfMethod = $this->file->findNext([T_STRING, T_VARIABLE], $posOfObjOperator + 1, $statement['end']);
                if ($this->tokens[$posOfMethod]['code'] === T_STRING &&
                    (in_array($this->tokens[$posOfMethod]['content'], $this->allowedMethods) ||
                        stripos($this->tokens[$posOfMethod]['content'], $this->methodNameContains) !== false)
                ) {
                    break;
                } else {
                    $this->addWarning($posOfMethod);
                }
                break;
            case T_CONSTANT_ENCAPSED_STRING:
            case T_DOUBLE_CAST:
            case T_INT_CAST:
            case T_BOOL_CAST:
            default:
                return;
        }
    }

    /**
     * Split line from start to end by ternary operators and concatenations.
     *
     * @param int $start
     * @param int $end
     * @return bool
     */
    private function parseLineStatement($start, $end)
    {
        $parsed = false;
        $posOfLastInlineThen = $this->findLastInScope(T_INLINE_THEN, $start, $end);
        if ($posOfLastInlineThen !== false) {
            $posOfInlineElse = $this->file->findNext(T_INLINE_ELSE, $posOfLastInlineThen, $end);
            $this->addStatement($posOfLastInlineThen + 1, $posOfInlineElse);
            $this->addStatement($posOfInlineElse + 1, $end);
            $parsed = true;
        } else {
            do {
                $posOfConcat = $this->findNextInScope(T_STRING_CONCAT, $start, $end);
                if ($posOfConcat !== false) {
                    $this->addStatement($start, $posOfConcat);
                    $parsed = true;
                } elseif ($parsed) {
                    $this->addStatement($start, $end);
                }
                $start = $posOfConcat + 1;
            } while ($posOfConcat !== false);
        }
        return $parsed;
    }

    /**
     * Push statement range in queue to check.
     *
     * @param int $start
     * @param int $end
     * @return void
     */
    private function addStatement($start, $end)
    {
        $this->statements[] = [
            'start' => $start,
            'end' => $end
        ];
    }

    /**
     * Finds next token position in current scope.
     *
     * @param int|array $types
     * @param int $start
     * @param int $end
     * @return int|bool
     */
    private function findNextInScope($types, $start, $end)
    {
        $types = (array)$types;
        $next = $this->file->findNext(array_merge($types, [T_OPEN_PARENTHESIS]), $start, $end);
        $nextToken = $this->tokens[$next];
        if ($nextToken['code'] === T_OPEN_PARENTHESIS) {
            return $this->findNextInScope($types, $nextToken['parenthesis_closer'] + 1, $end);
        } else {
            return $next;
        }
    }

    /**
     * Finds last token position in current scope.
     *
     * @param int|array $types
     * @param int $start
     * @param int $end
     * @param int|bool $last
     * @return int|bool
     */
    private function findLastInScope($types, $start, $end, $last = false)
    {
        $types = (array)$types;
        $nextInScope = $this->findNextInScope($types, $start, $end);
        if ($nextInScope !== false && $nextInScope > $last) {
            return $this->findLastInScope($types, $nextInScope + 1, $end, $nextInScope);
        } else {
            return $last;
        }
    }

    /**
     * Adds CS warning message.
     *
     * @param int $position
     * @return void
     */
    private function addWarning($position)
    {
        if ($this->hasDisallowedAnnotation) {
            $this->file->addWarning($this->warningMessage, $position, $this->warningCodeNotAllowed);
        } else {
            $this->file->addWarning($this->warningMessage, $position, $this->warningCodeUnescaped);
        }
    }
}
