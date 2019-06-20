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
 * Detects no try block detected when processing system resources
 */
class TryProcessSystemResourcesSniff implements Sniff
{
    /**
     * String representation of warning.
     *
     * @var string
     */
    protected $warningMessage = 'The code MUST be wrapped with a try block if the method uses system resources .';

    /**
     * Warning violation code.
     *
     * @var string
     */
    protected $warningCode = ' TryProcessSystem';

    /**
     * Searched functions.
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
        return [T_STRING];
    }

    /**
     * @inheritDoc
     */
    public function process(File $phpcsFile, $stackPtr)
    {
        $isSystemResource = false;

        $tokens = $phpcsFile->getTokens();
        $match = $tokens[$stackPtr]['content'];

        foreach ($this->functions as $function) {
            if (strpos($match, $function) === false) {
                continue;
            }

            $isSystemResource = true;
            break;
        }

        if (false === $isSystemResource) {
            // Probably no a system resource no check
            return;
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
