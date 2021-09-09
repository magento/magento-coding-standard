<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magento2\Sniffs\Legacy;

use DOMDocument;
use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

/**
 * Test for obsolete nodes/attributes in the widget.xml
 */
class WidgetXMLSniff implements Sniff
{
    private const ERROR_CODE_OBSOLETE = 'FoundObsoleteNode';
    private const ERROR_CODE_FACTORY = 'FoundFactory';
    private const ERROR_CODE_XML = 'WrongXML';

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

        try {
            $xml = simplexml_load_string($this->getFormattedXML($phpcsFile));
        } catch (\Exception $e) {
            $this->invalidXML($phpcsFile, $stackPtr);
            return;
        }
        if ($xml === false) {
            $this->invalidXML($phpcsFile, $stackPtr);
            return;
        }

        $foundElements = $xml->xpath('/widgets/*[@type]');

        foreach ($foundElements as $element) {
            if (!property_exists($element->attributes(), 'type')) {
                continue;
            }
            $type = $element['type'];
            if (preg_match('/\//', $type)) {
                $phpcsFile->addError(
                    "Factory name detected: {$type}.",
                    dom_import_simplexml($element)->getLineNo() - 1,
                    self::ERROR_CODE_FACTORY
                );
            }
        }

        $foundElements = $xml->xpath('/widgets/*/supported_blocks');
        foreach ($foundElements as $element) {
            $phpcsFile->addError(
                "Obsolete node: <supported_blocks>. To be replaced with <supported_containers>",
                dom_import_simplexml($element)->getLineNo() - 1,
                self::ERROR_CODE_OBSOLETE
            );
        }

        $foundElements = $xml->xpath('/widgets/*/*/*/block_name');
        foreach ($foundElements as $element) {
            $phpcsFile->addError(
                "Obsolete node: <block_name>. To be replaced with <container_name>",
                dom_import_simplexml($element)->getLineNo() - 1,
                self::ERROR_CODE_OBSOLETE
            );
        }
    }

    /**
     * Adds an invalid XML error
     *
     * @param File $phpcsFile
     * @param int $stackPtr
     */
    protected function invalidXML(File $phpcsFile, int $stackPtr): void
    {
        $phpcsFile->addError(
            sprintf(
                "Couldn't parse contents of '%s', check that they are in valid XML format",
                $phpcsFile->getFilename(),
            ),
            $stackPtr,
            self::ERROR_CODE_XML
        );
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

        return $node->getLineNo() === $stackPtr + 1;
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
