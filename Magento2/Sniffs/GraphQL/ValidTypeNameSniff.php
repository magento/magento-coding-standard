<?php
/**
 * Copyright © Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento2\Sniffs\GraphQL;

use PHP_CodeSniffer\Standards\Squiz\Sniffs\Classes\ValidClassNameSniff;

/**
 * Detects types (<kbd>type</kbd>, <kbd>interface</kbd> and <kbd>enum</kbd>) that are not specified in
 * <kbd>UpperCamelCase</kbd>.
 */
class ValidTypeNameSniff extends ValidClassNameSniff
{

    /**
     * Defines the tokenizers that this sniff is using.
     *
     * @var array
     */
    public $supportedTokenizers = ['GraphQL'];

    /**
     * @inheritDoc
     */
    public function register()
    {
        return [T_CLASS];
    }

}
