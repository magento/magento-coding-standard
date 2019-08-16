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
     * Warning violation code.
     *
     * @var string
     */
    protected $warningCodeFoundHelper = 'FoundHelper';

    /**
     * String representation of warning.
     *
     * @var string
     */
    protected $warningMessageFoundHelper = 'The use of helpers in templates is discouraged. Use ViewModel instead.';

    /**
     * Warning violation code.
     *
     * @var string
     */
    protected $warningCodeFoundThis = 'FoundThis';

    /**
     * String representation of warning.
     *
     * @var string
     */
    protected $warningMessageFoundThis = 'The use of $this in templates is deprecated. Use $block instead.';

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
            $position = $phpcsFile->findNext(T_STRING, $stackPtr, null, false, 'helper', true);
            if ($position !== false) {
                $phpcsFile->addWarning($this->warningMessageFoundHelper, $position, $this->warningCodeFoundHelper);
            } else {
                $phpcsFile->addWarning($this->warningMessageFoundThis, $stackPtr, $this->warningCodeFoundThis);
            }
        }
    }
}
