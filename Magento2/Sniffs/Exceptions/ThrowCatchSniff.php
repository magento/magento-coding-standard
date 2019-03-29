<?php
/**
 * Copyright © Magento. All rights reserved.
 * See COPYING.txt for license details.
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
        return [T_FUNCTION, T_CLOSURE];
    }

    /**
     * @inheritDoc
     */
    public function process(File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();
        if (!isset($tokens[$stackPtr]['scope_closer'])) {
            // Probably an interface method no check
            return;
        }

        $closeBrace = $tokens[$stackPtr]['scope_closer'];
        $throwTags = [];
        $catchTags = [];

        for ($i = $stackPtr; $i < $closeBrace; $i++) {
            $token = $tokens[$i];
            if ($token['code'] === T_CATCH) {
                $catchTags[] = $token;
            }
            if ($token['code'] === T_THROW) {
                $throwTags[] = $i;
            }
        }

        if (count($catchTags) === 0 || count($throwTags) === 0) {
            // No catch or throw found no check
            return;
        }

        $catchClassNames = [];
        $throwClassNames = [];

        // find all relevant classes in catch
        foreach ($catchTags as $catchTag) {
            $start = $catchTag['parenthesis_opener'];
            $end = $catchTag['parenthesis_closer'];

            $match = $phpcsFile->findNext(T_STRING, $start, $end);
            $catchClassNames[$match] = $tokens[$match]['content'];
        }

        // find all relevant classes in throws
        foreach ($throwTags as $throwTag) {
            $match = $phpcsFile->findNext(T_STRING, $throwTag);
            $throwClassNames[] = $tokens[$match]['content'];
        }

        $throwClassNames = array_flip($throwClassNames);
        foreach ($catchClassNames as $match => $catchClassName) {
            if (array_key_exists($catchClassName, $throwClassNames)) {
                $phpcsFile->addWarning($this->warningMessage, $match, $this->warningCode);
            }
        }
    }
}
