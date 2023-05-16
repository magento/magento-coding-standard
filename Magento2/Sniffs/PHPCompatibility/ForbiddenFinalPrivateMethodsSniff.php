<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magento2\Sniffs\PHPCompatibility;

use Magento2\Internal\FileProxy;
use PHP_CodeSniffer\Files\File;

/**
 * @inheritdoc
 */
class ForbiddenFinalPrivateMethodsSniff extends \PHPCompatibility\Sniffs\FunctionDeclarations\ForbiddenFinalPrivateMethodsSniff
{
    /**
     * @inheritdoc
     */
    public function process(File $phpcsFile, $stackPtr)
    {
        $phpcsFile->fixer->enabled = true;
        $warningCount = $phpcsFile->getWarningCount();
        $phpcsFileProxy = new FileProxy(
            $phpcsFile,
            [
                'addWarning' => function ($warning, $stackPtr, $code, $data = [], $severity = 0) use ($phpcsFile) {
                    $phpcsFile->addFixableWarning($warning, $stackPtr, $code, $data, $severity);
                },
            ]
        );
        $result =  parent::process($phpcsFileProxy, $stackPtr);
        if ($warningCount < $phpcsFile->getWarningCount() && $phpcsFile->fixer->enabled === true) {
            $phpcsFile->fixer->beginChangeset();
            $prev = $phpcsFile->findPrevious(\T_FINAL, ($stackPtr - 1));
            $phpcsFile->fixer->replaceToken($prev, null);
            // Remove extra space left out by previous replacement
            $next = $phpcsFile->findNext(\T_WHITESPACE, $prev);
            $phpcsFile->fixer->replaceToken($next, null);
            $phpcsFile->fixer->endChangeset();
        }

        return $result;
    }
}
