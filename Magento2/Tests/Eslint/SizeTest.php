<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento2\Tests\Eslint;

/**
 * Class SizeTest
 *
 * Test Eslint Rule: jquery-no-size.js
 */
class SizeTest extends AbstractEslintTestCase
{
    public function testExecute(): void
    {
        $this->assertFileContainsError(
            'SizeTest.js',
            ['jQuery.size() removed, use jQuery.length']
        );
    }
}
