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
 * Test to find obsolete acl declaration
 */
class ObsoleteAclSniff implements Sniff
{
    use ParseXMLTrait;

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
}
