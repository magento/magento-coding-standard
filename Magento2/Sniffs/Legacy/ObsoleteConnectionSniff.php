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
        '_getReadConnection',
        '_getWriteConnection',
        '_getReadAdapter',
        '_getWriteAdapter',
        'getReadConnection',
        'getWriteConnection',
        'getReadAdapter',
        'getWriteAdapter',
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
     * @param $phpcsFile
     * @param $stackPtr
     */
    private function validateObsoleteMethod($phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();
        $stringPos = $phpcsFile->findNext(T_STRING, $stackPtr + 1);
        
        foreach ($this->obsoleteMethods as $method) {
            if ($tokens[$stringPos]['content'] === $method) {
                $phpcsFile->addWarning(
                    sprintf("Contains obsolete method: %s.", $method),
                    $stackPtr,
                    self::ERROR_CODE_METHOD
                );
            }
        }
    }
}
