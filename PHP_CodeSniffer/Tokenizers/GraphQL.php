<?php
/**
 * Copyright © Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace PHP_CodeSniffer\Tokenizers;

use PHP_CodeSniffer\Config;

/**
 * Implements a tokenizer for GraphQL files.
 */
class GraphQL extends JS
{

    protected $additionalTokenValues = [
        'type'      => 'T_CLASS',
        'interface' => 'T_CLASS',
        'enum'      => 'T_CLASS',
        '#'         => 'T_COMMENT',
    ];

    /**
     * Constructor.
     *
     * @param string $content
     * @param Config $config
     * @param string $eolChar
     * @throws \PHP_CodeSniffer\Exceptions\TokenizerException
     */
    public function __construct($content, Config $config, $eolChar = '\n')
    {
        //add our token values
        $this->tokenValues = array_merge(
            $this->tokenValues,
            $this->additionalTokenValues
        );

        //let parent do its job (which will start tokenizing)
        parent::__construct($content, $config, $eolChar);
    }

    /**
     * @inheritDoc
     */
    public function processAdditional()
    {
        //NOP Does nothing intentionally
    }

}
