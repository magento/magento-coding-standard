<?php
/**
 * Copyright © Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento2\Tests\GraphQL;

/**
 * Covers {@link \Magento2\Sniffs\GraphQL\ValidEnumValueSniff}
 */
class ValidEnumValueUnitTest extends AbstractGraphQLSniffUnitTestCase
{
    /**
     * @inheritDoc
     */
    protected function getErrorList()
    {
        return [
            14 => 1,
            15 => 1,
            16 => 1,
            17 => 1,
            18 => 1,
            19 => 1,
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
