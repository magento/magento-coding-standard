<?php
/**
 * NOTICE OF LICENSE
 *
 * Copyright (c) 2019 TechDivision GmbH <info@techdivision.com> - TechDivision GmbH
 * All rights reserved
 *
 * This product includes proprietary software developed at TechDivision GmbH, Germany
 * For more information see https://www.techdivision.com/
 *
 * To obtain a valid license for using this software please contact us at license@techdivision.com
 */
namespace Magento2\Sniffs\GraphQL;

use PHP_CodeSniffer\Sniffs\Sniff;

/**
 * Defines an abstract base class for GraphQL sniffs.
 */
abstract class AbstractGraphQLSniff implements Sniff
{
    /**
     * Defines the tokenizers that this sniff is using.
     *
     * @var array
     */
    public $supportedTokenizers = ['GraphQL'];

    /**
     * Returns whether <var>$name</var> starts with a lower case character and is written in camel case.
     *
     * @param string $name
     * @return bool
     */
    protected function isCamelCase($name)
    {
        return (preg_match('/^[a-z][a-zA-Z0-9]+$/', $name) !== 0);
    }

    /**
     * Returns whether <var>$name</var> is strictly lower case, potentially separated by underscores.
     *
     * @param string $name
     * @return bool
     */
    protected function isSnakeCase($name)
    {
        return preg_match('/^[a-z][a-z0-9_]*$/', $name);
    }
}
