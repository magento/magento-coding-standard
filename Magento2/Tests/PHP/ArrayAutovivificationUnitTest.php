<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento2\Tests\PHP;

use PHP_CodeSniffer\Tests\Standards\AbstractSniffUnitTest;

class ArrayAutovivificationUnitTest extends AbstractSniffUnitTest
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
        if ($testFile === 'ArrayAutovivificationUnitTest.inc') {
            return [
                46 => 1
            ];
        }

        return [];
    }
}
