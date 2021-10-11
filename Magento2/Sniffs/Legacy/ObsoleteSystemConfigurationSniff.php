<?php

/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magento2\Sniffs\Legacy;

use DOMDocument;
use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

class ObsoleteSystemConfigurationSniff implements Sniff
{
    private const ERROR_CODE_XML = 'WrongXML';
    private const WARNING_CODE_OBSOLETE = 'FoundObsoleteSystemConfiguration';

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
     * @inheritdoc
     */
    public function process(File $phpcsFile, $stackPtr)
    {
        if ($stackPtr > 0) {
            return;
        }

        $xml = simplexml_load_string($this->getFormattedXML($phpcsFile));

        if ($xml === false) {
            $this->invalidXML($phpcsFile, $stackPtr);
            return;
        }
        
        $foundElements = $xml->xpath('/config/tabs|/config/sections');
        
        if ($foundElements === false) {
            return;
        }
        
        foreach ($foundElements as $element) {
            $phpcsFile->addWarning(
                "Obsolete system configuration structure detected in file.",
                dom_import_simplexml($element)->getLineNo() - 1,
                self::WARNING_CODE_OBSOLETE
            );
        }
    }

    /**
     * Adds an invalid XML error
     *
     * @param File $phpcsFile
     * @param int $stackPtr
     */
    private function invalidXML(File $phpcsFile, int $stackPtr): void
    {
        $phpcsFile->addError(
            sprintf(
                "Couldn't parse contents of '%s', check that they are in valid XML format.",
                $phpcsFile->getFilename(),
            ),
            $stackPtr,
            self::ERROR_CODE_XML
        );
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
