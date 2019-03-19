<?php
/**
 * Copyright © Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento2\Sniffs\Security;

use PHP_CodeSniffer\Sniffs\Sniff;
use PHP_CodeSniffer\Files\File;

/**
 * Detects possible usage of super global variables.
 */
class SuperglobalSniff implements Sniff
{
    /**
     * String representation of warning.
     *
     * @var string
     */
    protected $warningMessage = 'Direct use of %s Superglobal detected.';

    /**
     * String representation of error.
     *
     * @var string
     */
    protected $errorMessage = 'Direct use of %s Superglobal detected.';

    /**
     * Warning violation code.
     *
     * @var string
     */
    protected $warningCode = 'SuperglobalUsageWarning';

    /**
     * Error violation code.
     *
     * @var string
     */
    protected $errorCode = 'SuperglobalUsageError';

    /**
     * @inheritdoc
     */
    protected $superGlobalErrors = [
        '$GLOBALS',
        '$_GET',
        '$_POST',
        '$_SESSION',
        '$_REQUEST',
        '$_ENV',
        '$_FILES',
    ];

    /**
     * @inheritdoc
     */
    protected $superGlobalWarning = [
        '$_COOKIE', //sometimes need to get list of all cookies array and there are no methods to do that in M2
        '$_SERVER',
    ];

    /**
     * @inheritdoc
     */
    public function register()
    {
        return [T_VARIABLE];
    }

    /**
     * @inheritdoc
     */
    public function process(File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();
        $var = $tokens[$stackPtr]['content'];
        if (in_array($var, $this->superGlobalErrors)) {
            $phpcsFile->addError(
                $this->errorMessage,
                $stackPtr,
                $this->errorCode,
                [$var]
            );
        } elseif (in_array($var, $this->superGlobalWarning)) {
            $phpcsFile->addWarning(
                $this->warningMessage,
                $stackPtr,
                $this->warningCode,
                [$var]
            );
        }
    }
}
