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
    private const OBSOLETE_NODES = [
        'FoundObsoleteParamNode' => [
            'pattern' => '<param',
            'message' => 'The <param> node is obsolete. Instead, use the <argument name="..." xsi:type="...">'
        ],
        'FoundObsoleteInstanceNode' => [
            'pattern' => '<instance',
            'message' => 'The <instance> node is obsolete. Instead, use the <argument name="..." xsi:type="object">>'
        ],
        'FoundObsoleteArrayNode' => [
            'pattern' => '<array',
            'message' => 'The <array> node is obsolete. Instead, use the <argument name="..." xsi:type="array">'
        ],
        'FoundObsoleteItemNode' => [
            'pattern' => '<item key=',
            'message' => 'The <item key="..."> node is obsolete. Instead, use the <item name="..." xsi:type="...">'
        ],
        'FoundObsoleteValueNode' => [
            'pattern' => '<value',
            'message' => 'The <value> node is obsolete. Instead, provide the actual value as a text literal'
        ],
    ];

    /**
     * @inheritDoc
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
        $lineContent = $phpcsFile->getTokensAsString($stackPtr, 1);

        foreach (self::OBSOLETE_NODES as $code => $data) {
            if (strpos($lineContent, $data['pattern']) !== false) {
                $phpcsFile->addWarning(
                    $data['message'],
                    $stackPtr,
                    $code
                );
            }
        }
    }
}
