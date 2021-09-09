<?php
/**
 * Copyright © Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento2\Sniffs\Legacy;

use PHP_CodeSniffer\Sniffs\Sniff;
use PHP_CodeSniffer\Files\File;

class ObsoleteMethodsUsageSniff implements Sniff
{
    private const ERROR_MESSAGE = 'Obsolete methods usage detected';
    
    private const ERROR_CODE = 'ObsoleteMethodsUsage';

    private $obsoleteStaticMethods = [
        'getModel', 'getSingleton', 'getResourceModel', 'getResourceSingleton',
        'addBlock', 'createBlock', 'getBlockSingleton',
        'initReport', 'setEntityModelClass', 'setAttributeModel', 'setBackendModel', 'setFrontendModel',
        'setSourceModel', 'setModel'
    ];

    /**
     * @inheritdoc
     */
    public function register(): array
    {
        return [
            T_DOUBLE_COLON,
        ];
    }

    /**
     * @inheritdoc
     */
    public function process(File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();
        $methodNameStackPtr = $phpcsFile->findNext(T_STRING, $stackPtr + 1, null, false, null, true);
        if ($methodNameStackPtr === false) {
            return;
        }
        $name = $tokens[$methodNameStackPtr]['content'];
        if (in_array($name, $this->obsoleteStaticMethods)) {
            $classNameStackPtr = $phpcsFile->findPrevious(
                [T_STRING],
                $methodNameStackPtr - 1,
                null,
                false,
                null,
                true
            );
            if ($classNameStackPtr === false) {
                return;
            }
            if ($tokens[$classNameStackPtr]['content'] === 'Mage') {
                $phpcsFile->addError(
                    self::ERROR_MESSAGE,
                    $methodNameStackPtr + 1,
                    self::ERROR_CODE,
                );
            }
        }
    }
}
