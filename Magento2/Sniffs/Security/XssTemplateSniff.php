<?php
/**
 * Copyright © Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento2\Sniffs\Security;

use PHP_CodeSniffer\Sniffs\Sniff;
use PHP_CodeSniffer\Files\File;
use function array_key_exists;
use function is_string;
use function preg_match;
use function sprintf;
use function substr;

/**
 * Detects not escaped output in phtml templates.
 */
class XssTemplateSniff implements Sniff
{
    private const CONTEXT_HTML = 'context_html';
    private const CONTEXT_HTML_ATTRIBUTE = 'context_html_attribute';
    private const CONTEXT_JAVASCRIPT = 'context_javascript';

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
     * Annotations preventing from static analysis (skipping this sniff)
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
     * Tokens that need to be removed
     *
     * @var array
     */
    private $removeTokens = [];

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
                    $fixed = $this->fix($posOfFirstElement, $posOfFirstElement);
                    if ($fixed === true) {
                        break;
                    }
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
                    $fixed = $this->fix($posOfFirstElement);
                    if ($fixed === true) {
                        break;
                    }
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
                    $fixed = $this->fix($posOfFirstElement, $posOfMethod);
                    if ($fixed === true) {
                        break;
                    }
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
            if ($posOfInlineElse !== false) {
                $this->addStatement($posOfLastInlineThen + 1, $posOfInlineElse);
                $this->addStatement($posOfInlineElse + 1, $end);
            }
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
            $this->hasDisallowedAnnotation = false;
        } else {
            $this->file->addWarning($this->warningMessage, $position, $this->warningCodeUnescaped);
        }
    }

    private function fix(int $posOfElement, ?int $posOfMethod = null): ?bool
    {
        $element = $posOfMethod === null ? $posOfElement : $posOfMethod;
        if (preg_match('(url|Url)', $this->tokens[$element]['content'])) {
            $this->fixUnescapedUrl($posOfElement, $posOfMethod);
            return true;
        }

        if (preg_match('(json|Json)', $this->tokens[$element]['content'])) {
            $this->fixUnescapedJson($posOfElement);
            return true;
        }

        return $this->fixUnescaped($posOfElement, $posOfMethod);
    }

    private function fixUnescapedUrl(int $posOfElement, ?int $posOfMethod = null): void
    {
        $fix = $this->file->addFixableError(
            'Can be fixed because it contains "Url"',
            $posOfElement,
            $this->warningCodeUnescaped
        );
        if (!$fix) {
            return;
        }
        $content = $this->tokens[$posOfElement]['content'];
        if ($posOfMethod !== null) {
            $posOfEndFunction = $this->getEndOfFunction($posOfMethod);
            $content = $this->getFullFunctionName($posOfElement, $posOfEndFunction);
        }

        $newContent = sprintf('$escaper->escapeUrl(%s)', $content);

        $this->file->fixer->beginChangeset();
        $this->removeUnusedTokens();
        $this->file->fixer->replaceToken($posOfElement, $newContent);
        $this->file->fixer->endChangeset();

    }

    private function fixUnescapedJson(int $posOfElement): void
    {
        $fix = $this->file->addFixableError(
            'Can be fixed because it contains "json"',
            $posOfElement,
            $this->warningCodeUnescaped
        );
        if (!$fix) {
            return;
        }

        $content = $this->tokens[$posOfElement]['content'];
        $newContent = sprintf('/* @noEscape  */ %s', $content);

        $this->file->fixer->beginChangeset();
        $this->file->fixer->replaceToken($posOfElement, $newContent);
        $this->file->fixer->endChangeset();
    }

    private function fixUnescaped(int $posOfElement, ?int $posOfMethod = null): ?bool
    {
        $context = $this->findContextBeforeExpression($posOfElement);

        $newContent = null;

        if ($context !== null && $context === self::CONTEXT_HTML_ATTRIBUTE) {
            $newContent = $this->getNewContentHtmlAttribute($posOfElement, $posOfMethod);
        }

        if ($context !== null && $context === self::CONTEXT_HTML) {
            $newContent = $this->getNewContentHtml($posOfElement, $posOfMethod);
        }

        if (!is_string($newContent)) {
            return $newContent;
        }

        $this->file->fixer->beginChangeset();
        $this->removeUnusedTokens();
        $this->file->fixer->replaceToken($posOfElement, $newContent);
        $this->file->fixer->endChangeset();

        return true;
    }

    private function findContextBeforeExpression(int $posOfStartElement): ?string
    {
        if (!array_key_exists($posOfStartElement -1, $this->tokens)) {
            return null;
        }
        $previousElement = $this->tokens[$posOfStartElement -1];
        if ($previousElement['type'] !== 'T_OPEN_TAG_WITH_ECHO' && $previousElement['type'] !== 'T_OPEN_TAG') {
            return $this->findContextBeforeExpression($posOfStartElement -1);
        }

        $index = 2;
        $isFixable = true;
        while ($isFixable) {
            if (($posOfStartElement - $index) === 0 || $this->hasDisallowedAnnotation) {
                $isFixable = false;
                continue;
            }
            $element = $this->tokens[$posOfStartElement - $index];
            if ($element['type'] === 'T_INLINE_HTML') {
                $isWhiteSpace = false;
                // remove enter from html tag
                $content = preg_replace("/\r|\n/", '', $element['content']);
                switch (substr($content, -1)) {
                    case '>':
                        return self::CONTEXT_HTML;
                    case '"':
                        return self::CONTEXT_HTML_ATTRIBUTE;
                    case ':':
                        return self::CONTEXT_JAVASCRIPT;
                    default:
                        $isWhiteSpace = true;
                        $index++;
                }
                continue;
            }

            $index++;
        }

        return null;
    }

    private function getEndOfFunction(int $posOfElement): int
    {
        $isEndOfFunction = false;
        $index = 1;
        while(!$isEndOfFunction) {
            $newElement = $this->tokens[$posOfElement + $index];
            if ($newElement['code'] === T_CLOSE_PARENTHESIS) {
                $isEndOfFunction = true;
                continue;
            }

            $index++;
        }

        return $posOfElement + $index;
    }

    private function getFullFunctionName(int $beginPosOfElement, int $endPosOfElement): string
    {
        $result = '';
        for ($index = $beginPosOfElement; $index <= $endPosOfElement; $index++) {
            $result .= $this->tokens[$index]['content'];
            $this->removeTokens[] = $index;
        }

        return $result;
    }

    /**
     * @param int $posOfElement
     * @param int|null $posOfMethod
     * @return false|string
     */
    private function getNewContentHtmlAttribute(int $posOfElement, ?int $posOfMethod)
    {
        $fix = $this->file->addFixableError(
            'Can be fixed because its an attribute',
            $posOfElement,
            $this->warningCodeUnescaped
        );

        if (!$fix) {
            return true;
        }
        $content = $this->tokens[$posOfElement]['content'];
        if ($posOfMethod !== null) {
            $posOfEndFunction = $this->getEndOfFunction($posOfMethod);
            $content = $this->getFullFunctionName($posOfElement, $posOfEndFunction);
        }

        return sprintf('$escaper->escapeHtmlAttr(%s)', $content);
    }

    /**
     * @param int $posOfElement
     * @param int|null $posOfMethod
     * @return false|string
     */
    private function getNewContentHtml(int $posOfElement, ?int $posOfMethod)
    {
        $fix = $this->file->addFixableError(
            'Can be fixed because its a html tag',
            $posOfElement,
            $this->warningCodeUnescaped
        );

        if (!$fix) {
            return true;
        }
        $content = $this->tokens[$posOfElement]['content'];
        if ($posOfMethod !== null) {
            $posOfEndFunction = $this->getEndOfFunction($posOfMethod);
            $content = $this->getFullFunctionName($posOfElement, $posOfEndFunction);
        }

        return sprintf('$escaper->escapeHtml(%s)', $content);
    }

    private function removeUnusedTokens(): void
    {
        foreach ($this->removeTokens as $removeToken) {
            $this->file->fixer->replaceToken($removeToken, '');
        }
        $this->removeTokens = [];
    }
}
