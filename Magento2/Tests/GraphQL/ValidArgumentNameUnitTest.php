<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento2\Tests\GraphQL;

/**
 * Covers {@link \Magento2\Sniffs\GraphQL\ValidArgumentNameSniff}.
 */
class ValidArgumentNameUnitTest extends AbstractGraphQLSniffUnitTestCase
{
    /**
     * @inheritDoc
     */
    protected function getErrorList()
    {
        return [
            11 => 1,
            12 => 1,
            13 => 1,
            14 => 1,
            27 => 1,
            28 => 1,
            29 => 1,
            30 => 1,
            51 => 1,
            52 => 1,
            53 => 1,
            54 => 1,
            55 => 1,
            56 => 1,
            57 => 1,
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
