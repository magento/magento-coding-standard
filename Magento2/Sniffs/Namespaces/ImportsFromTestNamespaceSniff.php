<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento2\Sniffs\Namespaces;

use PHP_CodeSniffer\Sniffs\Sniff;
use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Util\Tokens;

/**
 * Detects static test namespace.
 */
class ImportsFromTestNamespaceSniff implements Sniff
{
    /**
     * @var string
     */
    private $prohibitNamespace = 'Magento\Tests';

    /**
     * @var string
     */
    protected $warningMessage = 'Application modules should not use classed from test modules.';

    /**
     * @var string
     */
    protected $warningCode = 'WrongImport';

    /**
     * @inheritdoc
     */
    public function register()
    {
        return [T_USE];
    }

    /**
     * @inheritdoc
     */
    public function process(File $phpcsFile, $stackPtr)
    {
        $next = $phpcsFile->findNext([T_COMMA, T_SEMICOLON, T_OPEN_USE_GROUP, T_CLOSE_TAG], ($stackPtr + 1));
        $tokens = $phpcsFile->getTokens();
        $getTokenAsContent = $phpcsFile->getTokensAsString($stackPtr, ($next - $stackPtr));
        if (strpos($getTokenAsContent, $this->prohibitNamespace) !== false) {
            $phpcsFile->addWarning($this->warningMessage, $stackPtr, $this->warningCode);
        }
        if ($next !== false
            && $tokens[$next]['code'] !== T_SEMICOLON
            && $tokens[$next]['code'] !== T_CLOSE_TAG
        ) {
            $baseUse  = rtrim($phpcsFile->getTokensAsString($stackPtr, ($next - $stackPtr)));
            $baseUse = str_replace('use \\', '', $baseUse);
            $closingCurly = $phpcsFile->findNext(T_CLOSE_USE_GROUP, ($next + 1));
            do {
                $next = $phpcsFile->findNext(Tokens::$emptyTokens, ($next + 1), $closingCurly, true);
                if ($next !== false) {
                    $groupedAsContent = $baseUse. $tokens[$next]['content'];
                    $next = $phpcsFile->findNext(T_COMMA, ($next + 1), $closingCurly);
                    if (strpos($groupedAsContent, $this->prohibitNamespace) !== false) {
                        $phpcsFile->addWarning($this->warningMessage, $stackPtr, $this->warningCode);
                        return;
                    }
                }
            } while ($next !== false);
        }
    }
}
