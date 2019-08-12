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
    protected $warningMessageFoundHelper = 'Usage of helpers in templates is discouraged.';

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
    protected $warningMessageFoundThis = 'Usage of $this in template files is deprecated.';

    /**
     * @inheritdoc
     */
    public function register()
    {
        return [
            T_VARIABLE,
            T_STRING,
        ];
    }

    /**
     * @inheritdoc
     */
    public function process(File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();
        if ($tokens[$stackPtr]['content'] === '$this') {
            $phpcsFile->addWarning($this->warningMessageFoundThis, $stackPtr, $this->warningCodeFoundThis);
        }
        if ($tokens[$stackPtr]['content'] === 'helper') {
            $phpcsFile->addWarning($this->warningMessageFoundHelper, $stackPtr, $this->warningCodeFoundHelper);
        }
    }
}
