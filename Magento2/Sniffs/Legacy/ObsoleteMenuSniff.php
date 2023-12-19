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
class ObsoleteMenuSniff implements Sniff
{
    use ParseXMLTrait;

    private const WARNING_OBSOLETE_MENU_STRUCTURE = 'ObsoleteMenuStructure';

    /**
     * @var string
     */
    private $xpath = '/config/menu/*[boolean(./children) or boolean(./title) or boolean(./action)]';

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
        $foundElements = $xml->xpath($this->xpath);
        foreach ($foundElements as $element) {
            $phpcsFile->addWarning(
                'Obsolete menu structure detected in line ' . dom_import_simplexml($element)->getLineNo(),
                dom_import_simplexml($element)->getLineNo() - 1,
                self::WARNING_OBSOLETE_MENU_STRUCTURE
            );
        }
    }
}
