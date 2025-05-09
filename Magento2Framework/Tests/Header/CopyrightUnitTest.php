<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento2Framework\Tests\Header;

use PHP_CodeSniffer\Tests\Standards\AbstractSniffUnitTest;

class CopyrightUnitTest extends AbstractSniffUnitTest
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
        if ($testFile === 'CopyrightUnitTest.4.inc' || $testFile === 'CopyrightUnitTest.5.inc') {
            return [];
        }

        if ($testFile === 'CopyrightUnitTest.1.inc') {
            return [
                1 => 1,
            ];
        }

        if ($testFile === 'CopyrightUnitTest.2.inc' || $testFile === 'CopyrightUnitTest.3.inc') {
            return [
                null => 1,
            ];
        }

        return [];
    }
}
