<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types = 1);

namespace Magento2\Sniffs\Legacy;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

class ObsoleteConnectionSniff implements Sniff
{
    private const ERROR_CODE_METHOD = 'FoundObsoleteMethod';

    /**
     * @var string[]
     */
    private $obsoleteMethods = [
        '_getReadConnection' => 'FoundObsoleteMethod_getReadConnection',
        '_getWriteConnection' => 'FoundObsoleteMethod_getWriteConnection',
        '_getReadAdapter' => 'FoundObsoleteMethod_getReadAdapter',
        '_getWriteAdapter' => 'FoundObsoleteMethod_getWriteAdapter',
        'getReadConnection' => 'FoundObsoleteMethodGetReadConnection',
        'getWriteConnection' => 'FoundObsoleteMethodGetWriteConnection',
        'getReadAdapter' => 'FoundObsoleteMethodGetReadAdapter',
        'getWriteAdapter' => 'FoundObsoleteMethodGetWriteAdapter',
    ];

    /**
     * @inheritdoc
     */
    public function register()
    {
        return [
            T_OBJECT_OPERATOR,
            T_FUNCTION
        ];
    }

    /**
     * @inheritdoc
     */
    public function process(File $phpcsFile, $stackPtr)
    {
        $this->validateObsoleteMethod($phpcsFile, $stackPtr);
    }

    /**
     * Check if obsolete methods are used
     *
     * @param File $phpcsFile
     * @param int $stackPtr
     */
    private function validateObsoleteMethod(File $phpcsFile, int $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();
        $stringPos = $phpcsFile->findNext(T_STRING, $stackPtr + 1);
        
        foreach ($this->obsoleteMethods as $method => $errorCode) {
            if ($tokens[$stringPos]['content'] === $method) {
                $phpcsFile->addWarning(
                    sprintf("Contains obsolete method: %s. Please use getConnection method instead.", $method),
                    $stackPtr,
                    $errorCode
                );
            }
        }
    }
}
