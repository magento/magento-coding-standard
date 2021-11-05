<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento2\Tests\Functions;

use PHP_CodeSniffer\Tests\Standards\AbstractSniffUnitTest;

/**
 * Sniff to validate PHP deprecated function.
 */
class DeprecatedFunctionUnitTest extends AbstractSniffUnitTest
{
    /**
     * @inheritdoc
     */
    public function getErrorList(): array
    {
        return [];
    }

    /**
     * @inheritdoc
     */
    public function getWarningList($testFile = ''): array
    {
        if ($testFile === 'DeprecatedFunctionUnitTest.inc') {
            return [
                23 => 1
            ];
        }

        return [];
    }
}
