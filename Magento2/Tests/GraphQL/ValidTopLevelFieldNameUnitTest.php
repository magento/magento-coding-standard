<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento2\Tests\GraphQL;

/**
 * Covers {@link \Magento2\Sniffs\GraphQL\ValidTopLevelFieldNameSniff}.
 */
class ValidTopLevelFieldNameUnitTest extends AbstractGraphQLSniffUnitTestCase
{
    /**
     * @inheritDoc
     */
    protected function getErrorList()
    {
        return [
            6 => 1,
            7 => 1,
            8 => 1,
            9 => 1,
            16 => 1,
            17 => 1,
            27 => 1,
            31 => 1,
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
