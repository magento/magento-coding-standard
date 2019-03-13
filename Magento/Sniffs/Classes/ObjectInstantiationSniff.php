<?php
/**
 * Copyright © Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\Sniffs\Classes;

use PHP_CodeSniffer\Sniffs\Sniff;
use PHP_CodeSniffer\Files\File;

/**
 * Detects direct object instantiation via 'new' keyword.
 */
class ObjectInstantiationSniff implements Sniff
{
    /**
     * String representation of warning.
     *
     * phpcs:disable Magento.Files.LineLength.MaxExceeded
     *
     * @var string
     */
    protected $warningMessage = 'Direct %s object instantiation is discouraged in Magento. Use dependency injection or factories instead.';
    //phpcs:enable

    /**
     * Warning violation code.
     *
     * @var string
     */
    protected $warningCode = 'FoundDirectInstantiation';

    /**
     * List of tokens which declares left bound of current scope.
     *
     * @var array
     */
    protected $leftRangeTokens = [
        T_WHITESPACE,
        T_THROW
    ];

    /**
     * List of tokens which declares right bound of current scope.
     *
     * @var array
     */
    protected $rightRangeTokens = [
        T_STRING,
        T_SELF,
        T_STATIC,
        T_VARIABLE,
        T_NS_SEPARATOR
    ];

    /**
     * @inheritdoc
     */
    public function register()
    {
        return [T_NEW];
    }

    /**
     * @inheritdoc
     */
    public function process(File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();
        $leftLimit = $phpcsFile->findPrevious($this->leftRangeTokens, $stackPtr - 1, null, true);
        $findThrow = $phpcsFile->findPrevious(T_THROW, $stackPtr - 1, $leftLimit);
        if (!$findThrow) {
            $classNameStart = $phpcsFile->findNext($this->rightRangeTokens, $stackPtr + 1);
            $classNameEnd = $phpcsFile->findNext($this->rightRangeTokens, $classNameStart + 1, null, true);
            $className = '';
            for ($i = $classNameStart; $i < $classNameEnd; $i++) {
                $className .= $tokens[$i]['content'];
            }
            $phpcsFile->addWarning(
                $this->warningMessage,
                $classNameStart,
                $this->warningCode,
                [$className]
            );
        }
    }
}
