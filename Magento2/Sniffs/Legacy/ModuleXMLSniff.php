<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magento2\Sniffs\Legacy;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;
use SimpleXMLElement;

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
        $line = $phpcsFile->getTokens()[$stackPtr]['content'];
        if (strpos(trim($line), '<module ') === false) {
            return;
        }
        
        $xml = simplexml_load_string($phpcsFile->getTokensAsString(0, 999999));

        $foundElements = $xml->xpath('/config/module');
        if ($foundElements === false) {
            return;
        }
        
        foreach ($foundElements as $element) {
            if (!$this->elementIsCurrentlySniffedLine($element, $stackPtr)) {
                continue;
            }
            
            if (property_exists($element->attributes(), 'version')) {
                $phpcsFile->addWarning(
                    'The "version" attribute is obsolete. Use "setup_version" instead.',
                    $stackPtr,
                    $this->warningCode
                );
            }

            if (property_exists($element->attributes(), 'active')) {
                $phpcsFile->addWarning(
                    'The "active" attribute is obsolete. The list of active modules '.
                            'is defined in deployment configuration.',
                    $stackPtr,
                    $this->warningCode
                );
            }
        }
    }

    /**
     * Check if the element passed is in the currently sniffed line
     * 
     * @param SimpleXMLElement $element
     * @param int $stackPtr
     * @return bool
     */
    private function elementIsCurrentlySniffedLine(SimpleXMLElement $element, int $stackPtr): bool
    {
        $node = dom_import_simplexml($element);
        if ($node->getLineNo() === $stackPtr+1) {
            return true;
        }
        return false;
    }
}
