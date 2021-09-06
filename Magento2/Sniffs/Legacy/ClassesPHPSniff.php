<?php
/**
 * Copyright © Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento2\Sniffs\Legacy;

use PHP_CodeSniffer\Sniffs\Sniff;
use PHP_CodeSniffer\Files\File;

class ClassesPHPSniff implements Sniff
{

    private const errorMessage = 'Obsolete factory name(s) detected';
    
    private const errorCode = 'ObsoleteFactoryName';

    private $methodsThatReceiveClassNameAsFirstArgument = [
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
            T_OBJECT,
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
        if (in_array($name, $this->methodsThatReceiveClassNameAsFirstArgument)) {
            $firstArgumentStackPtr = $phpcsFile->findNext(
                [T_CONSTANT_ENCAPSED_STRING],
                $methodNameStackPtr + 1,
                null,
                false,
                null,
                true
            );
            if ($firstArgumentStackPtr === false) {
                return;
            }
            $name = $tokens[$firstArgumentStackPtr]['content'];
            if (!$this->isAValidNonFactoryName($name)) {
                $phpcsFile->addError(
                    self::errorMessage,
                    $methodNameStackPtr + 1,
                    self::errorCode,
                );
            }
        }
    }

    /**
     * Check whether specified classes or module names correspond to a file according PSR-1 Standard.
     *
     * @param string $name
     * @return bool
     */
    private function isAValidNonFactoryName(string $name): bool
    {
        if (strpos($name, 'Magento') === false) {
            return true;
        }

        if (false === strpos($name, '\\')) {
            return false;
        }

        if (preg_match('/^([A-Z\\\\][A-Za-z\d\\\\]+)+$/', $name) !== 1) {
            return false;
        }

        return true;
    }
}
