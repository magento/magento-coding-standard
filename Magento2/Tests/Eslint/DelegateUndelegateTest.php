<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento2\Tests\Eslint;

/**
 * Class DelegateUndelegateTest
 *
 * Test Eslint Rule: jquery-no-delegate-undelegate.js
 */
class DelegateUndelegateTest extends AbstractEslintTestCase
{
    public function testExecute(): void
    {
        $this->assertFileContainsError(
            'DelegateUndelegateTest.js',
            ['jQuery $.delegate and $.undelegate are deprecated, use $.on and $.off instead']
        );
    }
}
