<?php

/**
 * Copyright 2026 Adobe
 * All Rights Reserved.
 */
declare(strict_types=1);

namespace Magento2\Sniffs\Namespaces;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;
use PHP_CodeSniffer\Util\Tokens;
use PHPCSUtils\Utils\Namespaces;
use PHPCSUtils\Utils\UseStatements;

/**
 * Detects import use statements that are not sorted alphabetically.
 *
 * Class imports come first, then function imports, then constant imports.
 * Within each type, names are compared case-insensitively, namespace by namespace.
 */
class AlphabeticallySortedUsesSniff implements Sniff
{
    private const TYPE_ORDER = [
        'class' => 0,
        'function' => 1,
        'const' => 2,
    ];

    private const WARNING_CODE = 'IncorrectlyOrderedUses';

    /**
     * @inheritDoc
     */
    public function register()
    {
        return [T_OPEN_TAG];
    }

    /**
     * @inheritDoc
     */
    public function process(File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();
        $statements = [];

        for ($ptr = $stackPtr; $ptr < $phpcsFile->numTokens; $ptr++) {
            if ($tokens[$ptr]['code'] === T_NAMESPACE && Namespaces::isDeclaration($phpcsFile, $ptr)) {
                $this->checkStatements($phpcsFile, $statements);
                $statements = [];
                continue;
            }

            if ($tokens[$ptr]['code'] !== T_USE || !UseStatements::isImportUse($phpcsFile, $ptr)) {
                continue;
            }

            $end = $phpcsFile->findNext([T_SEMICOLON, T_CLOSE_TAG], $ptr + 1);
            if ($end === false) {
                break;
            }

            $statements[] = $this->describeStatement($phpcsFile, $ptr, $end);
            $ptr = $end;
        }

        $this->checkStatements($phpcsFile, $statements);

        return $phpcsFile->numTokens;
    }

    /**
     * Build the sort key and the source text of one import use statement.
     *
     * @param File $phpcsFile
     * @param int $start
     * @param int $end
     * @return array
     */
    private function describeStatement(File $phpcsFile, int $start, int $end): array
    {
        $tokens = $phpcsFile->getTokens();
        $type = 'class';
        $name = '';

        $ptr = $phpcsFile->findNext(Tokens::$emptyTokens, $start + 1, $end, true);
        $keyword = strtolower($tokens[$ptr]['content']);
        if ($keyword === 'function' || $keyword === 'const') {
            $type = $keyword;
            $ptr++;
        }

        for (; $ptr < $end; $ptr++) {
            $code = $tokens[$ptr]['code'];
            if ($code === T_AS || $code === T_OPEN_USE_GROUP || $code === T_COMMA) {
                break;
            }
            if (!isset(Tokens::$emptyTokens[$code])) {
                $name .= $tokens[$ptr]['content'];
            }
        }

        $lastCodeToken = $tokens[$end]['code'] === T_SEMICOLON ? $end : $end - 1;

        return [
            'start' => $start,
            'end' => $lastCodeToken,
            'type' => $type,
            'name' => trim($name, '\\'),
            'content' => $phpcsFile->getTokensAsString($start, $lastCodeToken - $start + 1),
        ];
    }

    /**
     * Report statements that are out of order and fix the whole block when it is safe to do so.
     *
     * @param File $phpcsFile
     * @param array $statements
     * @return void
     */
    private function checkStatements(File $phpcsFile, array $statements): void
    {
        $fixable = $this->isFixable($phpcsFile, $statements);
        $fixed = false;

        for ($i = 1, $count = count($statements); $i < $count; $i++) {
            $previous = $statements[$i - 1];
            $current = $statements[$i];
            if ($this->compare($previous, $current) <= 0) {
                continue;
            }

            $message = 'Use statements should be sorted alphabetically; "%s" should be placed before "%s"';
            $data = [$current['name'], $previous['name']];
            if (!$fixable) {
                $phpcsFile->addWarning($message, $current['start'], self::WARNING_CODE, $data);
                continue;
            }

            if ($phpcsFile->addFixableWarning($message, $current['start'], self::WARNING_CODE, $data) && !$fixed) {
                $this->fix($phpcsFile, $statements);
                $fixed = true;
            }
        }
    }

    /**
     * Statements can be reordered only when nothing but whitespace separates them.
     *
     * @param File $phpcsFile
     * @param array $statements
     * @return bool
     */
    private function isFixable(File $phpcsFile, array $statements): bool
    {
        $tokens = $phpcsFile->getTokens();

        for ($i = 1, $count = count($statements); $i < $count; $i++) {
            for ($ptr = $statements[$i - 1]['end'] + 1; $ptr < $statements[$i]['start']; $ptr++) {
                if ($tokens[$ptr]['code'] !== T_WHITESPACE) {
                    return false;
                }
            }
        }

        return true;
    }

    /**
     * Rewrite every statement slot with the statement that belongs there after sorting.
     *
     * @param File $phpcsFile
     * @param array $statements
     * @return void
     */
    private function fix(File $phpcsFile, array $statements): void
    {
        $sorted = $statements;
        usort($sorted, [$this, 'compare']);

        $phpcsFile->fixer->beginChangeset();
        foreach ($statements as $index => $statement) {
            $phpcsFile->fixer->replaceToken($statement['start'], $sorted[$index]['content']);
            for ($ptr = $statement['start'] + 1; $ptr <= $statement['end']; $ptr++) {
                $phpcsFile->fixer->replaceToken($ptr, '');
            }
        }
        $phpcsFile->fixer->endChangeset();
    }

    /**
     * Compare two statements by import type, then by name segment by segment, ignoring case.
     *
     * @param array $first
     * @param array $second
     * @return int
     */
    private function compare(array $first, array $second): int
    {
        $typeOrder = self::TYPE_ORDER[$first['type']] <=> self::TYPE_ORDER[$second['type']];
        if ($typeOrder !== 0) {
            return $typeOrder;
        }

        $firstSegments = explode('\\', strtolower($first['name']));
        $secondSegments = explode('\\', strtolower($second['name']));
        $length = min(count($firstSegments), count($secondSegments));
        for ($i = 0; $i < $length; $i++) {
            $segmentOrder = strcmp($firstSegments[$i], $secondSegments[$i]);
            if ($segmentOrder !== 0) {
                return $segmentOrder;
            }
        }

        return count($firstSegments) <=> count($secondSegments);
    }
}
