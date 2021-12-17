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
            [
                'jQuery.unload() was removed, use .on("unload", fn) instead',
                'jQuery.ready(handler) is deprecated and should be replaced with jQuery(handler)'
            ]
        );
    }
}
