<?php
/**
 * Copyright 2019 Adobe
 * All Rights Reserved.
 */
namespace Magento2\Sniffs\Functions;

use PHP_CodeSniffer\Sniffs\Sniff;
use PHP_CodeSniffer\Files\File;

/**
 * Detects static function definitions.
 */
class StaticFunctionSniff implements Sniff
{
    /**
     * String representation of warning.
     *
     * @var string
     */
    protected $warningMessage = 'Static method cannot be intercepted and its use is discouraged.';

    /**
     * Warning violation code.
     *
     * @var string
     */
    protected $warningCode = 'StaticFunction';

    /**
     * @inheritDoc
     */
    public function register()
    {
        return [T_STATIC];
    }

    /**
     * @inheritDoc
     */
    public function process(File $phpcsFile, $stackPtr)
    {
        $posOfFunction = $phpcsFile->findNext(T_FUNCTION, $stackPtr) + 1;
        $tokens = array_slice($phpcsFile->getTokens(), $stackPtr, $posOfFunction - $stackPtr);

        $allowedTypes = [T_STATIC => true, T_WHITESPACE => true, T_FUNCTION => true];
        foreach ($tokens as $token) {
            $code = $token['code'];
            if (!array_key_exists($code, $allowedTypes)) {
                break;
            }

            if ($code === T_FUNCTION) {
                $phpcsFile->addWarning($this->warningMessage, $posOfFunction, $this->warningCode);
            }
        }
    }
}
