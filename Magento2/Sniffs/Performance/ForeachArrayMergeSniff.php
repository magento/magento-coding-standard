<?php
/**
 * Copyright 2019 Adobe
 * All Rights Reserved.
 */
namespace Magento2\Sniffs\Performance;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

/**
 * Detects array_merge(...) is used in a loop and is a resources greedy construction.
 */
class ForeachArrayMergeSniff implements Sniff
{
    /**
     * String representation of warning.
     *
     * @var string
     */
    protected $warningMessage = 'array_merge(...) is used in a loop and is a resources greedy construction.';

    /**
     * Warning violation code.
     *
     * @var string
     */
    protected $warningCode = 'ForeachArrayMerge';

    /**
     * @var array
     */
    protected $foreachCache = [];

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

        // If it's inline control structure we do nothing. PSR2 issue will be raised.
        if (!array_key_exists('scope_opener', $tokens[$stackPtr])) {
            return;
        }
        $scopeOpener = $tokens[$stackPtr]['scope_opener'];
        $scopeCloser = $tokens[$stackPtr]['scope_closer'];

        for ($i = $scopeOpener; $i < $scopeCloser; $i++) {
            $tag = $tokens[$i];
            if ($tag['code'] !== T_STRING) {
                continue;
            }
            if ($tag['content'] !== 'array_merge') {
                continue;
            }

            $cacheKey = $phpcsFile->getFilename() . $i;
            if (isset($this->foreachCache[$cacheKey])) {
                continue;
            }

            $this->foreachCache[$cacheKey] = '';
            $phpcsFile->addWarning($this->warningMessage, $i, $this->warningCode);
        }
    }
}
