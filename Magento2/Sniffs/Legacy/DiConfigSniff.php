<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magento2\Sniffs\Legacy;

use DOMDocument;
use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

class DiConfigSniff implements Sniff
{
    private const WARNING_CODE = 'FoundObsoleteAttribute';
    private const ERROR_CODE = 'WrongXML';

    private $xpathObsoleteElems = [
        'param',
        'instance',
        'array',
        'item[@key]',
        'value'
    ];

    private $messages = [
        'param' => 'The <param> node is obsolete. Instead, use the <argument name="..." xsi:type="...">',
        'instance' => 'The <instance> node is obsolete. Instead, use the <argument name="..." xsi:type="object">',
        'array' => 'The <array> node is obsolete. Instead, use the <argument name="..." xsi:type="array">',
        'item[@key]' => 'The <item key="..."> node is obsolete. Instead, use the <item name="..." xsi:type="...">',
        'value' => 'The <value> node is obsolete. Instead, provide the actual value as a text literal.'
    ];

    public function register(): array
    {
        return [
            T_INLINE_HTML
        ];
    }

    public function process(File $phpcsFile, $stackPtr)
    {
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
        }

        foreach ($this->xpathObsoleteElems as $obsoleteElem) {
            $found = $xml->xpath($obsoleteElem);
            if ($found === true) {
                $phpcsFile->addWarning(
                    $this->messages[$obsoleteElem],
                    $stackPtr,
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