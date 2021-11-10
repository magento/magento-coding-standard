<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento2\Sniffs\Exceptions;

use PHP_CodeSniffer\Sniffs\Sniff;
use PHP_CodeSniffer\Files\File;

/**
 * Detects possible direct throws of Exceptions.
 */
class DirectThrowSniff implements Sniff
{
    /**
     * String representation of warning.
     * phpcs:disable Generic.Files.LineLength.TooLong
     * @var string
     */
    protected $warningMessage = 'Direct throw of generic Exception is discouraged. Use context specific instead.';
    //phpcs:enable

    /**
     * Warning violation code.
     *
     * @var string
     */
    protected $warningCode = 'FoundDirectThrow';

    /**
     * @inheritdoc
     */
    public function register()
    {
        return [T_THROW];
    }

    /**
     * @inheritdoc
     */
    public function process(File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();
        $endOfStatement = $phpcsFile->findEndOfStatement($stackPtr);
        $posOfException = $phpcsFile->findNext(T_STRING, $stackPtr, $endOfStatement);
        $content = $tokens[$posOfException]['content'];
        $exceptionClassInUseStatement = false;
        foreach ($tokens as $key => $token) {
            if ($token['code'] === T_USE) {
                $endOfUse = $phpcsFile->findEndOfStatement($key);
                $posOfException = $phpcsFile->findNext(T_STRING, $key, $key + 3, false, 'Exception');
                if ($posOfException && $phpcsFile->findNext(T_SEMICOLON, $posOfException+1, $endOfUse + 1)) {
                    $exceptionClassInUseStatement = true;
                    break;
                }
            }
        }
        if ($content === '\Exception' || ($content === 'Exception' && $exceptionClassInUseStatement)) {
            $phpcsFile->addWarning(
                $this->warningMessage,
                $stackPtr,
                $this->warningCode,
                [$posOfException]
            );
        }
    }
}
