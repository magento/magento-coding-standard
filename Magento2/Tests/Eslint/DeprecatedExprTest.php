<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento2\Tests\Eslint;

/**
 * Class DeprecatedExprTest
 *
 * Test Eslint Rule: jquery-no-deprecated-expr.js
 */
class DeprecatedExprTest extends AbstractEslintTestCase
{
    public function testExecute(): void
    {
        $this->assertFileContainsError(
            'DeprecatedExprTest.js',
            [
                'jQuery.expr[":"] is deprecated; Use jQuery.expr.pseudos instead',
                'jQuery.expr.filters is deprecated; Use jQuery.expr.pseudos instead'
            ]
        );
    }
}
