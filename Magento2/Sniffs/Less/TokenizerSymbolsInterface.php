<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento2\Sniffs\Less;

/**
 * Interface TokenizerSymbolsInterface
 */
interface TokenizerSymbolsInterface
{
    public const TOKENIZER_CSS = 'CSS';

    /**#@+
     * Symbols for usage into Sniffers
     */
    public const BITWISE_AND         = '&';
    public const COLON               = ';';
    public const OPEN_PARENTHESIS    = '(';
    public const CLOSE_PARENTHESIS   = ')';
    public const NEW_LINE            = "\n";
    public const WHITESPACE          = ' ';
    public const DOUBLE_WHITESPACE   = '  ';
    public const INDENT_SPACES       = '    ';
    /**#@-*/
}
