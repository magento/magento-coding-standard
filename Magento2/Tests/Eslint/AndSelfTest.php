<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento2\Tests\Eslint;

/**
 * Class AndSelfTest
 *
 * Test Eslint Rule: jquery-no-andSelf.js
 */
class AndSelfTest extends AbstractEslintTestCase
{
    public function testExecute(): void
    {
        $this->assertFileContainsError(
            'AndSelfTest.js',
            ['jQuery.andSelf() removed, use jQuery.addBack()']
        );
    }
}
