<?php
/**
 * Copyright © Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magento2\Sniffs\Performance;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

class ForeachArrayMergeSniff implements Sniff
{
    /**
     * String representation of warning.
     *
     * @var string
     */
    protected $warningMessage = 'Array merge is slow in each functions. ';

    /**
     * Warning violation code.
     *
     * @var string
     */
    protected $warningCode = 'ForeachArrayMerge';

    /**
     * @inheritdoc
     */
    public function register()
    {
        return [T_FOREACH, T_FOR];
    }

    /**
     * @inheritdoc
     */
    public function process(File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();

        $scopeOpener = $tokens[$stackPtr]['scope_opener'];
        $scopeCloser = $tokens[$stackPtr]['scope_closer'] ;

        for ($i = $scopeOpener; $i <  $scopeCloser; $i++)
        {
            $tag = $tokens[$i];
            if ($tag['code'] !== T_STRING) {
                continue;
            }
            if ($tag['content'] !== 'array_merge') {
                continue;
            }

            $phpcsFile->addWarning($this->warningMessage, $i, $this->warningCode);
        }
    }
}
