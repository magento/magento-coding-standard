<?php
/**
 * Copyright © Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\Sniffs\Exceptions;

use PHP_CodeSniffer\Sniffs\Sniff;
use PHP_CodeSniffer\Files\File;

/**
 * Detects possible usage of exceptions without namespace declaration.
 */
class NamespaceSniff implements Sniff
{
    /**
     * String representation of error.
     *
     * @var string
     */
    protected $errorMessage = 'Namespace for %s class is not specified.';

    /**
     * Error violation code.
     *
     * @var string
     */
    protected $errorCode = 'NotFoundNamespace';

    /**
     * @inheritdoc
     */
    public function register()
    {
        return [T_CATCH, T_THROW];
    }

    /**
     * @inheritdoc
     */
    public function process(File $phpcsFile, $stackPtr)
    {
        if ($phpcsFile->findNext(T_NAMESPACE, 0) === false) {
            return;
        }

        $tokens = $phpcsFile->getTokens();
        $endOfStatement = $phpcsFile->findEndOfStatement($stackPtr);
        $posOfExceptionClassName = $phpcsFile->findNext(T_STRING, $stackPtr, $endOfStatement);
        $posOfNsSeparator = $phpcsFile->findNext(T_NS_SEPARATOR, $stackPtr, $posOfExceptionClassName);
        if ($posOfNsSeparator === false && $posOfExceptionClassName !== false) {
            $exceptionClassName = trim($tokens[$posOfExceptionClassName]['content']);
            $posOfClassInUse = $phpcsFile->findNext(T_STRING, 0, $stackPtr, false, $exceptionClassName);
            if ($posOfClassInUse === false || $tokens[$posOfClassInUse]['level'] != 0) {
                $phpcsFile->addError(
                    $this->errorMessage,
                    $stackPtr,
                    $this->errorCode,
                    $exceptionClassName
                );
            }
        }
    }
}
