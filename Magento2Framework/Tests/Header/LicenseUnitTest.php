<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento2Framework\Tests\Header;

use PHP_CodeSniffer\Tests\Standards\AbstractSniffUnitTest;

class LicenseUnitTest extends AbstractSniffUnitTest
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
        if ($testFile === 'LicenseUnitTest.1.inc' || $testFile === 'LicenseUnitTest.3.xml') {
            return [];
        }

        if ($testFile === 'LicenseUnitTest.2.inc') {
            return [
                3 => 1,
            ];
        }

        if ($testFile === 'LicenseUnitTest.4.xml') {
            return [
                4 => 1,
            ];
        }

        if ($testFile === 'LicenseUnitTest.5.less') {
            return [
                2 => 1,
            ];
        }

        return [];
    }
}
