<?php

/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magento2\Sniffs\Legacy;

use DOMDocument;
use PHP_CodeSniffer\Sniffs\Sniff;
use PHP_CodeSniffer\Files\File;

class ObsoleteConfigNodesSniff implements Sniff
{
    private const ERROR_MESSAGE_CONFIG = "Nodes identified by XPath '%s' are obsolete. %s";
    private const ERROR_CODE_CONFIG = 'ObsoleteNodeInConfig';

    /**
     * @inheritdoc
     */
    public function register()
    {
        return [
            T_INLINE_HTML,
        ];
    }

    /**
     * @inheritdoc
     */
    public function process(File $phpcsFile, $stackPtr)
    {
        if ($stackPtr > 0) {
            return;
        }

        // We need to format the incoming XML to avoid tags split into several lines. In that case, PHP's DOMElement
        // returns the position of the closing /> as the position of the tag, and we need the position of <
        // instead, as it is the one we compare with $stackPtr later on.
        $xml = simplexml_load_string($this->getFormattedXML($phpcsFile));
        if ($xml === false) {
            $phpcsFile->addError(
                sprintf(
                    "Couldn't parse contents of '%s', check that they are in valid XML format",
                    $phpcsFile->getFilename(),
                ),
                $stackPtr,
                self::ERROR_CODE_CONFIG
            );
        }

        foreach ($this->getObsoleteNodes() as $xpath => $suggestion) {
            $matches = $xml->xpath($xpath);
            if (empty($matches)) {
                continue;
            }
            foreach ($matches as $match) {
                $phpcsFile->addError(
                    sprintf(
                        self::ERROR_MESSAGE_CONFIG,
                        $xpath,
                        $suggestion
                    ),
                    dom_import_simplexml($match)->getLineNo()-1,
                    self::ERROR_CODE_CONFIG
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

    /**
     * Get a list of obsolete nodes
     *
     * @return array
     */
    private function getObsoleteNodes(): array
    {
        $obsoleteNodes = [];
        $obsoleteNodesFiles = glob(__DIR__ . '/_files/obsolete_config_nodes*.php');
        foreach ($obsoleteNodesFiles as $obsoleteNodesFile) {
            $obsoleteNodes = array_merge($obsoleteNodes, include $obsoleteNodesFile);
        }
        return $obsoleteNodes;
    }

}
