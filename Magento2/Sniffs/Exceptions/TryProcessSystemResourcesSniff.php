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
        return [T_STRING];
    }

    /**
     * @inheritDoc
     */
    public function process(File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();

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
