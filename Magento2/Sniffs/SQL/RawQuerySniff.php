<?php
/**
 * Copyright 2019 Adobe
 * All Rights Reserved.
 */
namespace Magento2\Sniffs\SQL;

use PHP_CodeSniffer\Sniffs\Sniff;
use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Util\Tokens;

/**
 * Detects possible raw SQL queries.
 */
class RawQuerySniff implements Sniff
{
    /**
     * String representation of warning.
     *
     * @var string
     */
    protected $warningMessage = 'Possible raw SQL statement %s detected.';
    /**
     * Warning violation code.
     *
     * @var string
     */
    protected $warningCode = 'FoundRawSql';
    /**
     * List of SQL statements.
     *
     * @var array
     */
    protected $statements = [
        'SELECT',
        'UPDATE',
        'INSERT',
        'CREATE',
        'DELETE',
        'ALTER',
        'DROP',
        'TRUNCATE'
    ];
    /**
     * List of query functions.
     *
     * @var array
     */
    protected $queryFunctions = [
        'query'
    ];
    /**
     * @inheritdoc
     */
    public function register()
    {
        return array_merge(Tokens::$stringTokens, [T_HEREDOC, T_NOWDOC]);
    }
    /**
     * @inheritdoc
     */
    public function process(File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();
        $ignoredTokens = array_merge([T_WHITESPACE, T_OPEN_PARENTHESIS], Tokens::$stringTokens);
        $prev = $tokens[$phpcsFile->findPrevious($ignoredTokens, $stackPtr - 1, null, true)];
        if ($prev['code'] === T_EQUAL
            || ($prev['code'] === T_STRING && in_array($prev['content'], $this->queryFunctions))
            || in_array($tokens[$stackPtr]['code'], [T_HEREDOC, T_NOWDOC])
        ) {
            $trim = function ($str) {
                return trim(str_replace(['\'', '"'], '', $str));
            };

            if (preg_match('/^(' . implode('|', $this->statements) . ')\s/i', $trim($tokens[$stackPtr]['content']))) {
                $phpcsFile->addWarning(
                    $this->warningMessage,
                    $stackPtr,
                    $this->warningCode,
                    [trim($tokens[$stackPtr]['content'])]
                );
            }
        }
    }
}
