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
class MiscDeprecatedExprTest extends AbstractEslintTestCase
{
    public function testExecute(): void
    {
        $this->assertFileContainsError(
            'MiscDeprecatedExprTest.js',
            [
                'jQuery.expr[":"] is deprecated; Use jQuery.expr.pseudos instead',
                'jQuery.expr.filters is deprecated; Use jQuery.expr.pseudos instead'
            ]
        );
    }
}
