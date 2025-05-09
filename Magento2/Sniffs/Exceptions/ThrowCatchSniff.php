<?php
/**
 * Copyright 2019 Adobe
 * All Rights Reserved.
 */
namespace Magento2\Sniffs\Exceptions;

use function array_slice;
use PHP_CodeSniffer\Sniffs\Sniff;
use PHP_CodeSniffer\Files\File;

/**
 * Detects exceptions must not be handled in same function
 */
class ThrowCatchSniff implements Sniff
{
    /**
     * String representation of warning.
     *
     * @var string
     */
    protected $warningMessage = 'Exceptions must not be handled in the same function where they are thrown.';

    /**
     * Warning violation code.
     *
     * @var string
     */
    protected $warningCode = 'ThrowCatch';

    /**
     * @inheritDoc
     */
    public function register()
    {
        return [T_TRY];
    }

    /**
     * @inheritDoc
     */
    public function process(File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();
        $endOfStatement = $phpcsFile->findEndOfStatement($stackPtr);

        $throwClassNames = [];
        $searchForNextThrow = $stackPtr;

        //  search for all throws
        do {
            $throwTag = $phpcsFile->findNext(T_THROW, $searchForNextThrow, $endOfStatement);

            if ($throwTag === false) {
                break;
            }

            $throwClassNames[] = $this->getFullClassName($tokens, $throwTag + 1);

            $searchForNextThrow = $throwTag + 1;
        } while ($throwTag !== false);

        if (empty($throwClassNames)) {
            return; // is not relevant not throw in try found.
        }

        $catchClassNames = [];

        // TRY statements need to check until the end of all CATCH statements.
        do {
            $nextToken = $phpcsFile->findNext(T_WHITESPACE, ($endOfStatement + 1), null, true);
            if ($tokens[$nextToken]['code'] === T_CATCH) {
                $endOfStatement = $tokens[$nextToken]['scope_closer'];
                $catchClassNames[$nextToken] = $this->getFullClassName($tokens, $nextToken + 1);
            } else {
                break;
            }
        } while (isset($tokens[$nextToken]['scope_closer']) === true);

        if (empty($catchClassNames)) {
            return; // is not relevant no catch found
        }

        $throwClassNames = array_flip($throwClassNames);
        foreach ($catchClassNames as $match => $catchClassName) {
            if (isset($throwClassNames[$catchClassName])) {
                $phpcsFile->addWarning($this->warningMessage, $match, $this->warningCode);
            }
        }
    }

    /**
     * Get the full class name with namespace.
     *
     * @param array $tokens
     * @param int $startPos
     * @return string
     */
    private function getFullClassName(array $tokens, $startPos)
    {
        $fullName = "";
        $endOfClassName = [T_SEMICOLON => 0, T_CLOSE_PARENTHESIS => 0];

        $tokenCount = count($tokens);
        for ($i = $startPos; $i <= $tokenCount; $i++) {
            $type = $tokens[$i]['code'];

            if ($type === T_STRING || $type === T_NS_SEPARATOR) {
                $fullName .= $tokens[$i]['content'];
            }

            if (array_key_exists($type, $endOfClassName)) {
                break; // line end each
            }
        }

        return $fullName;
    }
}
