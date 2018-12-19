<?php
/**
 * Copyright © Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\Sniffs\Templates;

use PHP_CodeSniffer\Sniffs\Sniff;
use PHP_CodeSniffer\Files\File;

/**
 * Detects possible usage of $this variable files.
 */
class ThisInTemplateSniff implements Sniff
{
    /**
     * Violation severity.
     *
     * @var int
     */
    protected $severity = 6;

    /**
     * String representation of warning.
     *
     * @var string
     */
    protected $warningMessage = 'Usage of $this in template files is deprecated.';

    /**
     * Warning violation code.
     *
     * @var string
     */
    protected $warningCode = 'FoundThis';

    /**
     * List of methods, allowed to called via $this.
     *
     * @var array
     */
    protected $allowedMethods = [
        'helper',
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
        if ($tokens[$stackPtr]['content'] === '$this') {
            $endOfStatementPtr = $phpcsFile->findEndOfStatement($stackPtr);
            $functionPtr = $phpcsFile->findNext(T_STRING, $stackPtr, $endOfStatementPtr);
            if ($functionPtr !== false) {
                if (!in_array($tokens[$functionPtr]['content'], $this->allowedMethods)) {
                    $phpcsFile->addWarning($this->warningMessage, $stackPtr, $this->warningCode, [], $this->severity);
                }
            } else {
                $phpcsFile->addWarning($this->warningMessage, $stackPtr, $this->warningCode, [], $this->severity);
            }
        }
    }
}
