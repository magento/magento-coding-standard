<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento2\Tests\GraphQL;

use PHP_CodeSniffer\Config;

/**
 * Covers {@link \Magento2\Sniffs\GraphQL\ValidTypeNameSniff}.
 */
class ValidTypeNameUnitTest extends AbstractGraphQLSniffUnitTestCase
{
    /**
     * Returns the lines where errors should occur.
     *
     * The key of the array should represent the line number and the value
     * should represent the number of errors that should occur on that line.
     *
     * @return array<int, int>
     */
    protected function getErrorList()
    {
        return [
            9 => 1,
            10 => 1,
            11 => 1,
            12 => 1,
            13 => 1,
            14 => 1,
            17 => 1,
            18 => 1,
            19 => 1,
            23 => 1,
            25 => 1,
            27 => 1,
            37 => 1,
            41 => 1,
            45 => 1,
        ];
    }

    /**
     * Returns the lines where warnings should occur.
     *
     * The key of the array should represent the line number and the value
     * should represent the number of warnings that should occur on that line.
     *
     * @return array<int, int>
     */
    protected function getWarningList()
    {
        return [];
    }
}
