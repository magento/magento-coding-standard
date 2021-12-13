<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento2\Tests\Eslint;

/**
 * Class MiscDeprecatedFunctionsTest
 *
 * Test Eslint Rule: jquery-no-misc-deprecated-functions.js
 */
class MiscDeprecatedFunctionsTest extends AbstractEslintTestCase
{
    public function testExecute(): void
    {
        $this->assertFileContainsError(
            'MiscDeprecatedFunctionsTest.js',
            [
                'jQuery.isFunction() is deprecated. In most cases, it can be replaced by [typeof x === "function"]',
                'jQuery.type() is deprecated. Replace with an appropriate type check like [typeof x === "function"]',
                'jQuery.isArray() is deprecated. Use the native Array.isArray method instead',
                'jQuery.parseJSON() is deprecated. To parse JSON strings, use the native JSON.parse method instead'
            ]
        );
    }
}
