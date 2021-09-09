<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento2\Tests\GraphQL;

/**
 * Covers {@link \Magento2\Sniffs\GraphQL\ValidFieldNameSniff}.
 */
class ValidFieldNameUnitTest extends AbstractGraphQLSniffUnitTestCase
{
    /**
     * @inheritDoc
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
