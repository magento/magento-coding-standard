<?php

/**
 * Copyright 2019 Adobe
 * All Rights Reserved.
 */

namespace Magento2\Sniffs\Exceptions;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;
use PHP_CodeSniffer\Util\Tokens;

/**
 * Detects missing try-catch block when processing system resources.
 */
class TryProcessSystemResourcesSniff implements Sniff
{
    /**
     * String representation of warning.
     *
     * @var string
     */
    protected $warningMessage = 'The code must be wrapped with a try block if the method uses system resources.';

    /**
     * Warning violation code.
     *
     * @var string
     */
    protected $warningCode = 'MissingTryCatch';

    /**
     * Search for functions that start with.
     *
     * @var array
     */
    protected $functions = [
        'stream_',
        'socket_',
    ];

    /**
     * @inheritDoc
     */
    public function register()
    {
        return [
            \T_USE,
            \T_STRING,
        ];
    }

    /**
     * @inheritDoc
     */
    public function process(File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();

        if ($tokens[$stackPtr]['code'] === \T_USE) {
            $previousToken = $phpcsFile->findPrevious(Tokens::$emptyTokens, $stackPtr - 1, null, true);
            $nextToken = $phpcsFile->findNext(Tokens::$emptyTokens, $stackPtr + 1, null, true);
            $semicolon = $phpcsFile->findNext(T_SEMICOLON, $stackPtr + 1);
            if ($previousToken !== false
                && \in_array($tokens[$previousToken]['code'], [\T_OPEN_TAG, \T_SEMICOLON], true)
                && $nextToken !== false
                && $tokens[$nextToken]['code'] === \T_STRING
                && $tokens[$nextToken]['content'] === 'function'
                && $semicolon !== false
            ) {
                // We have found a 'use function ...' statement; skip over this.
                return $semicolon;
            }

            // This is not a 'use function ...' statement.
            return;
        }

        foreach ($this->functions as $function) {
            if (strpos($tokens[$stackPtr]['content'], $function) !== 0) {
                continue;
            }

            $tryPosition = $phpcsFile->findPrevious(T_TRY, $stackPtr - 1);

            if ($tryPosition !== false) {
                $tryTag = $tokens[$tryPosition];
                $start = $tryTag['scope_opener'];
                $end = $tryTag['scope_closer'];
                if ($stackPtr > $start && $stackPtr < $end) {
                    // element is warped by try no check required
                    return;
                }
            }

            $phpcsFile->addWarning(
                $this->warningMessage,
                $stackPtr,
                $this->warningCode
            );
        }
    }
}
