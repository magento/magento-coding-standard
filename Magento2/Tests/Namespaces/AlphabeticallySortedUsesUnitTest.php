<?php

/**
 * Copyright 2026 Adobe
 * All Rights Reserved.
 */
declare(strict_types=1);

namespace Magento2\Tests\Namespaces;

use PHP_CodeSniffer\Tests\Standards\AbstractSniffUnitTest;

class AlphabeticallySortedUsesUnitTest extends AbstractSniffUnitTest
{
    /**
     * @inheritDoc
     */
    public function getErrorList($testFile = '')
    {
        return [];
    }

    /**
     * @inheritDoc
     */
    public function getWarningList($testFile = '')
    {
        switch ($testFile) {
            case 'AlphabeticallySortedUsesUnitTest.2.inc':
                return [
                    5 => 1,
                    6 => 1,
                    8 => 1,
                    10 => 1,
                ];
            case 'AlphabeticallySortedUsesUnitTest.3.inc':
                return [
                    6 => 1,
                ];
            case 'AlphabeticallySortedUsesUnitTest.4.inc':
                return [
                    4 => 1,
                    14 => 1,
                    15 => 1,
                ];
            default:
                return [];
        }
    }
}
