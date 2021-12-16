<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento2\Tests\Eslint;

use PHPUnit\Framework\TestCase;

/**
 * Abstract class AbstractEslintTestCase
 *
 * Test Eslint Rules (magento-coding-standard/eslint/rules)
 */
abstract class AbstractEslintTestCase extends TestCase
{
    /**
     * Assert that file contains a specific error.
     *
     * @param string $testFile
     * @param array $expectedMessages
     */
    protected function assertFileContainsError(string $testFile, array $expectedMessages): void
    {
        // phpcs:disable
        exec(
            'npm run eslint -- Magento2/Tests/Eslint/' . $testFile,
            $output
        );

        foreach ($expectedMessages as $message) {
            $this->assertStringContainsString($message, implode(' ', $output));
        }
    }
}
