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
    use ParseXMLTrait;

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
}
