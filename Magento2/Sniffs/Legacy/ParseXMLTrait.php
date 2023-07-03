<?php

/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magento2\Sniffs\Legacy;

use DOMDocument;
use PHP_CodeSniffer\Files\File;

trait ParseXMLTrait
{
    /**
     * Format the incoming XML to avoid tags split into several lines.
     *
     * @param File $phpcsFile
     *
     * @return false|string
     */
    private function getFormattedXML(File $phpcsFile)
    {
        try {
            $doc = new DomDocument('1.0');
            $doc->formatOutput = true;
            $doc->loadXML($phpcsFile->getTokensAsString(0, count($phpcsFile->getTokens())));
            return $doc->saveXML();
        } catch (\Exception $e) {
            $phpcsFile->addError(
                "Couldn't parse contents of '%s', check that they are in valid XML format.",
                0,
                'WrongXML',
                [
                    $phpcsFile->getFilename(),
                ]
            );
            return false;
        }
    }
}
