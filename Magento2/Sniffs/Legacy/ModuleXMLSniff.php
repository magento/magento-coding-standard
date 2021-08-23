<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magento2\Sniffs\Legacy;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

/**
 * Test for obsolete nodes/attributes in the module.xml
 */
class ModuleXMLSniff implements Sniff
{
    /**
     * Error violation code.
     *
     * @var string
     */
    protected $warningCode = 'FoundObsoleteAttribute';
    
    /**
     * @inheritdoc
     */
    public function register(): array
    {
        return [
            T_INLINE_HTML
        ];
    }

    /**
     * @inheritDoc
     */
    public function process(File $phpcsFile, $stackPtr)
    {
        $xml = simplexml_load_string($phpcsFile->getTokensAsString(0, 999999));
        
        if ($xml->xpath('/config/module/@version') !== false) {
            $phpcsFile->addWarning(
                'The "version" attribute is obsolete. Use "setup_version" instead.',
                $stackPtr,
                $this->warningCode
            );
        }
        
        if ($xml->xpath('/config/module/@active') !== false) {
            $phpcsFile->addWarning(
                'The "active" attribute is obsolete. The list of active modules is defined in deployment configuration.',
                $stackPtr,
                $this->warningCode
            );
        }
    }
}
