<?php
/**
 * Copyright © Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento2\Sniffs\Namespaces;

use PHP_CodeSniffer\Sniffs\Sniff;
use PHP_CodeSniffer\Files\File;

/**
 * Detects static test namespace.
 */
class UseDeclarationSniff implements Sniff
{

    /**
     * @var string
     */
    private $_prohibitNamespace = 'Magento\Tests';

    /**
     * @var string
     */
    protected $warningMessage = 'Incorrect namespace has been imported.';

    /**
     * @var string
     */
    protected $warningCode = 'WrongImportNamespaces';

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
        $getTokenAsContent = $phpcsFile->getTokensAsString($stackPtr, ($next - $stackPtr));
        if (strpos($getTokenAsContent, $this->_prohibitNamespace) !== false) {
            $phpcsFile->addWarning($this->warningMessage, $stackPtr, $this->warningCode);
        }
    }
}
