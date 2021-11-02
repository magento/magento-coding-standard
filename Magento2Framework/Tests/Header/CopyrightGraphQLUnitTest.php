<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento2Framework\Tests\Header;

use PHP_CodeSniffer\Tests\Standards\AbstractSniffUnitTest;

class CopyrightGraphQLUnitTest extends AbstractSniffUnitTest
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
        if ($testFile === 'CopyrightGraphQLUnitTest.1.inc' || $testFile === 'CopyrightGraphQLUnitTest.2.inc') {
            return [];
        }

        if ($testFile === 'CopyrightGraphQLUnitTest.3.inc' || $testFile === 'CopyrightGraphQLUnitTest.4.inc') {
            return [
                1 => 1
            ];
        }

        return [];
    }
}
