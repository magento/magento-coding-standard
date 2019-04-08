<?php
/**
 * Copyright © Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento2\Tests\Classes;

use PHP_CodeSniffer\Tests\Standards\AbstractSniffUnitTest;

/**
 * Class DiscouragedDependenciesUnitTest
 *
 * Tests for interceptors in constructors
 */
class DiscouragedDependenciesUnitTest extends AbstractSniffUnitTest
{
    /**
     * @inheritdoc
     */
    public function getErrorList($testFile = '')
    {
        if ($testFile === 'DiscouragedDependenciesUnitTest.1.inc') {
            return [
                17 => 1,
                37 => 1,
                44 => 1
            ];
        } elseif ($testFile === 'DiscouragedDependenciesUnitTest.2.inc') {
            return [
                17 => 1,
                37 => 1,
                44 => 1
            ];
        }

        return [];
    }

    /**
     * @inheritdoc
     */
    public function getWarningList()
    {
        return [];
    }
}
