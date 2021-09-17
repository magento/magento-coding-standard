<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento2\Tests\Eslint;

/**
 * Class BindUnbindTest
 *
 * Test Eslint Rule: jquery-no-bind-unbind.js
 */
class BindUnbindTest extends AbstractEslintTestCase
{
    public function testExecute(): void
    {
        $this->assertFileContainsError(
            'BindUnbindTest.js',
            ['jQuery $.bind and $.unbind are deprecated, use $.on and $.off instead']
        );
    }
}
