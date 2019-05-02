<?php
/**
 * Copyright © Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento2\Sniffs\Classes;

use PHP_CodeSniffer\Sniffs\Sniff;
use PHP_CodeSniffer\Files\File;

/**
 * Detects api annotation for an abstract class.
 */
class AbstractApiSniff implements Sniff
{

    /**
     * String representation of warning.
     *
     * @var string
     */
    protected $warningMessage = 'Abstract classes MUST NOT be marked as public @api.';

    /**
     * Warning violation code.
     *
     * @var string
     */
    protected $warningCode = 'AbstractApi';

    /**
     * @inheritDoc
     */
    public function register()
    {
        return [T_CLASS];
    }

    /**
     * @inheritDoc
     */
    public function process(File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();
        $prev = $phpcsFile->findPrevious(T_WHITESPACE, $stackPtr - 1, null, true);
        if ($prev !== false && $tokens[$prev]['code'] !== T_ABSTRACT) {
            return;
        }

        $commentStartPtr = $phpcsFile->findPrevious(T_DOC_COMMENT_OPEN_TAG, $stackPtr - 1, 0);
        if ($commentStartPtr === false) {
            return;
        }
        $commentCloserPtr = $tokens[$commentStartPtr]['comment_closer'];

        for ($i = $commentStartPtr; $i <= $commentCloserPtr; $i++) {
            $token = $tokens[$i];

            if ($token['code'] !== T_DOC_COMMENT_TAG) {
                continue;
            }

            if (strpos($token['content'], '@api') === false) {
                continue;
            }

            $phpcsFile->addWarning($this->warningMessage, $i, $this->warningCode);
        }
    }
}
