<?php
/**
 * Copyright © Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento2\Sniffs\Templates;

use PHP_CodeSniffer\Sniffs\Sniff;
use PHP_CodeSniffer\Files\File;

/**
 * Detects possible usage of $this variable files.
 */
class ThisInTemplateSniff implements Sniff
{
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
            $phpcsFile->addWarning($this->warningMessage, $stackPtr, $this->warningCode);
        }
    }
}
