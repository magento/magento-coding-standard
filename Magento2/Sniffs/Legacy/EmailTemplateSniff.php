<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magento2\Sniffs\Legacy;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

/**
 * Test for obsolete email directives in view/email/*.html
 */
class EmailTemplateSniff implements Sniff
{
    private const OBSOLETE_EMAIL_DIRECTIVES = [
        'FoundObsoleteHtmlescapeDirective' => [
            'pattern' => '/\{\{htmlescape.*?\}\}/i',
            'message' => 'Directive {{htmlescape}} is obsolete. Use {{var}} instead.',
        ],
        'FoundObsoleteEscapehtmlDirective' => [
            'pattern' => '/\{\{escapehtml.*?\}\}/i',
            'message' => 'Directive {{escapehtml}} is obsolete. Use {{var}} instead.',
        ],
    ];

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
        $content = $phpcsFile->getTokens()[$stackPtr]['content'];
        foreach (self::OBSOLETE_EMAIL_DIRECTIVES as $code => $data) {
            if (preg_match($data['pattern'], $content)) {
                $phpcsFile->addError(
                    $data['message'],
                    $stackPtr,
                    $code
                );
            }
        }
    }
}
