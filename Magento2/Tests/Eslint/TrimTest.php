<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento2\Tests\Eslint;

/**
 * Class TrimTest
 *
 * Test Eslint Rule: jquery-no-trim.js
 */
class TrimTest extends AbstractEslintTestCase
{
    public function testExecute(): void
    {
        $this->assertFileContainsError(
            'TrimTest.js',
            ['jQuery.trim is deprecated; use String.prototype.trim']
        );
    }
}
