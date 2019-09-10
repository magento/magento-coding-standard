<?php
/**
 * Copyright © Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento2\Tests\GraphQL;

/**
 * Covers {@link \Magento2\Sniffs\GraphQL\ValidFieldNameUnitTest}.
 */
class ValidFieldNameUnitTest extends AbstractGraphQLSniffUnitTestCase
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
            10 => 1,
            11 => 1,
            12 => 1,
            13 => 1,
            14 => 1,
            26 => 1,
            27 => 1,
            28 => 1,
            29 => 1,
            30 => 1,
        ];
    }

    /**
     * @inheritDoc
     */
    protected function getWarningList()
    {
        return [];
    }
}
