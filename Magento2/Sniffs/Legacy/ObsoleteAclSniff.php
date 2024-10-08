<?php
/**
 * Copyright 2021 Adobe
 * All Rights Reserved.
 */
namespace Magento2\Sniffs\Legacy;

use DOMDocument;
use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

/**
 * Test to find obsolete acl declaration
 */
class ObsoleteAclSniff implements Sniff
{
    private const WARNING_OBSOLETE_ACL_STRUCTURE = 'ObsoleteAclStructure';

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

        $xml = simplexml_load_string($this->getFormattedXML($phpcsFile));
        $foundElements = $xml->xpath('/config/acl/*[boolean(./children) or boolean(./title)]');
        foreach ($foundElements as $element) {
            $phpcsFile->addWarning(
                'Obsolete acl structure detected in line ' . dom_import_simplexml($element)->getLineNo(),
                dom_import_simplexml($element)->getLineNo() - 1,
                self::WARNING_OBSOLETE_ACL_STRUCTURE
            );
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
