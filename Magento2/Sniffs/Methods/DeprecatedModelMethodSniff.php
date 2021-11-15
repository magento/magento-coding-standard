<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento2\Sniffs\Methods;

use PHP_CodeSniffer\Sniffs\Sniff;
use PHP_CodeSniffer\Files\File;

/**
 * Detects possible use of deprecated model methods.
 */
class DeprecatedModelMethodSniff implements Sniff
{
    private const RESOURCE_METHOD = "getResource";

    /**
     * String representation of warning.
     *
     * @var string
     */
    protected $warningMessage = "The use of the deprecated method 'getResource()' to '%s' the data detected.";

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

    /**
     * @inheritdoc
     */
    public function register()
    {
        return [
            T_OBJECT_OPERATOR
        ];
    }
    /**
     * @inheritdoc
     */
    public function process(File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();
        $endOfStatement = $phpcsFile->findEndOfStatement($stackPtr);
        $resourcePosition = $phpcsFile->findNext(
            T_STRING,
            $stackPtr + 1,
            $endOfStatement,
            false,
            self::RESOURCE_METHOD
        );
        if ($resourcePosition !== false) {
            $methodPosition = $phpcsFile->findNext([T_STRING, T_VARIABLE], $resourcePosition + 1, $endOfStatement);
            if ($methodPosition !== false && in_array($tokens[$methodPosition]['content'], $this->methods, true)) {
                $phpcsFile->addWarning(
                    sprintf($this->warningMessage, $tokens[$methodPosition]['content']),
                    $stackPtr,
                    $this->warningCode
                );
            }
        }
    }
}
