<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento2\Tests\Eslint;

/**
 * Class EventShorthandTest
 *
 * Test Eslint Rule: jquery-no-event-shorthand.js
 */
class EventShorthandTest extends AbstractEslintTestCase
{
    public function testExecute(): void
    {
        $this->assertFileContainsError(
            'EventShorthandTest.js',
            ['jQuery.load() was removed, use .on("load", fn) instead']
        );
    }
}