<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magento2\Sniffs\Legacy;

use DOMDocument;
use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;
use SimpleXMLElement;

/**
 * Test for obsolete nodes/attributes in the module.xml
 */
class ModuleXMLSniff implements Sniff
{
    private const WARNING_CODE = 'FoundObsoleteAttribute';
    private const ERROR_CODE = 'WrongXML';

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
        if ($stackPtr > 0) {
            return;
        }

        // We need to format the incoming XML to avoid tags split into several lines. In that case, PHP's DOMElement
        // returns the position of the closing /> as the position of the tag, and we need the position of <module
        // instead, as it is the one we compare with $stackPtr later on.
        $xml = simplexml_load_string($this->getFormattedXML($phpcsFile));
        if ($xml === false) {
            $phpcsFile->addError(
                sprintf(
                    "Couldn't parse contents of '%s', check that they are in valid XML format",
                    $phpcsFile->getFilename(),
                ),
                $stackPtr,
                self::ERROR_CODE
            );
            return;
        }

        $foundElements = $xml->xpath('/config/module[@version]');
        if ($foundElements !== false) {
            foreach ($foundElements as $element) {
                $phpcsFile->addWarning(
                    'The "version" attribute is obsolete. Use "setup_version" instead.',
                    dom_import_simplexml($element)->getLineNo()-1,
                    self::WARNING_CODE
                );
            }
        }

        $foundElements = $xml->xpath('/config/module[@active]');
        if ($foundElements !== false) {
            foreach ($foundElements as $element) {
                $phpcsFile->addWarning(
                    'The "active" attribute is obsolete. The list of active modules '.
                    'is defined in deployment configuration.',
                    dom_import_simplexml($element)->getLineNo()-1,
                    self::WARNING_CODE
                );
            }
        }
    }

    /**
     * Format the incoming XML to avoid tags split into several lines.
     *
     * @param File $phpcsFile
     * @return false|string
     */
    private function getFormattedXML(File $phpcsFile)
    {
        $doc = new DomDocument('1.0');
        $doc->formatOutput = true;
        $doc->loadXML($phpcsFile->getTokensAsString(0, 999999));
        return $doc->saveXML();
    }
}
