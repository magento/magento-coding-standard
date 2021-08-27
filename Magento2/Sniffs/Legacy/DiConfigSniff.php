<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magento2\Sniffs\Legacy;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

class DiConfigSniff implements Sniff
{
    private const WARNING_CODE = 'FoundObsoleteAttribute';

    private $xpathObsoleteElems = [
        '<param' => 'The <param> node is obsolete. Instead, use the <argument name="..." xsi:type="...">',
        '<instance' => 'The <instance> node is obsolete. Instead, use the <argument name="..." xsi:type="object">',
        '<array' => 'The <array> node is obsolete. Instead, use the <argument name="..." xsi:type="array">',
        '<item key=' => 'The <item key="..."> node is obsolete. Instead, use the <item name="..." xsi:type="...">',
        '<value' => 'The <value> node is obsolete. Instead, provide the actual value as a text literal.'
    ];

    public function register(): array
    {
        return [
            T_INLINE_HTML
        ];
    }

    public function process(File $phpcsFile, $stackPtr)
    {
        $lineContent = $phpcsFile->getTokensAsString($stackPtr, 1);

        foreach ($this->xpathObsoleteElems as $elem => $message ) {
            if (strpos($lineContent, $elem) !== false) {
                $phpcsFile->addWarning(
                    $message,
                    $stackPtr,
                    self::WARNING_CODE
                );
            }
        }
    }
}
