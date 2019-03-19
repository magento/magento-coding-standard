<?php
/**
 * Copyright © Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento2\Sniffs\NamingConvention;

use PHP_CodeSniffer\Sniffs\Sniff;
use PHP_CodeSniffer\Files\File;

/**
 * Detects possible interface declaration without 'Interface' suffix.
 */
class InterfaceNameSniff implements Sniff
{
    /**
     * String representation of warning.
     *
     * @var string
     */
    protected $warningMessage = 'Interface should have name that ends with "Interface" suffix.';

    /**
     * Warning violation code.
     *
     * @var string
     */
    protected $warningCode = 'WrongInterfaceName';

    /**
     * Interface suffix.
     *
     * @var string
     */
    private $interfaceSuffix = 'Interface';

    /**
     * @inheritdoc
     */
    public function register()
    {
        return [T_INTERFACE];
    }

    /**
     * @inheritdoc
     */
    public function process(File $sourceFile, $stackPtr)
    {
        $tokens = $sourceFile->getTokens();
        $declarationLine = $tokens[$stackPtr]['line'];
        $suffixLength = strlen($this->interfaceSuffix);
        // Find first T_STRING after 'interface' keyword in the line and verify it
        while ($tokens[$stackPtr]['line'] === $declarationLine) {
            if ($tokens[$stackPtr]['type'] === 'T_STRING') {
                if (substr($tokens[$stackPtr]['content'], 0 - $suffixLength) !== $this->interfaceSuffix) {
                    $sourceFile->addWarning($this->warningMessage, $stackPtr, $this->warningCode);
                }
                break;
            }
            $stackPtr++;
        }
    }
}
