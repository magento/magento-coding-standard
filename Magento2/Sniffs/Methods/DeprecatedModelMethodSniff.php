<?php
/**
 * Copyright © Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento2\Sniffs\Methods;

use PHP_CodeSniffer\Sniffs\Sniff;
use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Util\Tokens;

/**
 * Detects possible use of deprecated model methods.
 */
class DeprecatedModelMethodSniff implements Sniff
{
    /**
     * String representation of warning.
     *
     * @var string
     */
    protected $warningMessage = "Possible use of the deprecated model method 'getResource()'" .
    " to '%s' the data detected.";

    /**
     * Warning violation code.
     *
     * @var string
     */
    protected $warningCode = 'FoundDeprecatedModelMethod';

    /**
     * List of deprecated method.
     *
     * @var array
     */
    protected $methods = [
        'save',
        'load',
        'delete'
    ];

    protected $severity = 0;

    /**
     * @inheritdoc
     */
    public function register()
    {
        return [
            T_OBJECT_OPERATOR,
            T_DOUBLE_COLON
        ];
    }
    /**
     * @inheritdoc
     */
    public function process(File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();
        $methodPosition = $phpcsFile->findNext(T_STRING, $stackPtr + 1);

        if ($methodPosition !== false &&
            in_array($tokens[$methodPosition]['content'], $this->methods)
        ) {
            $resourcePosition = $phpcsFile->findPrevious([T_STRING, T_VARIABLE], $stackPtr - 1);
            if ($resourcePosition !== false) {
                $methodName = $tokens[$resourcePosition]['content'];
                if ($methodName === "getResource") {
                    $phpcsFile->addWarning(
                        sprintf($this->warningMessage, $tokens[$methodPosition]['content']),
                        $stackPtr,
                        $this->warningCode
                    );
                }
            }
        }
    }
}
