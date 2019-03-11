<?php
/**
 * Copyright © Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magento\Tests\Classes;

use PHP_CodeSniffer\Tests\Standards\AbstractSniffUnitTest;

/**
 * Class ConstructorProxyInterceptorUnitTest
 *
 * Tests for interceptors in constructors
 */
class ConstructorProxyInterceptorUnitTest extends AbstractSniffUnitTest
{
    /**
     * @inheritdoc
     */
    public function getErrorList()
    {
        return [];
    }

    /**
     * @inheritdoc
     */
    public function getWarningList($testFile = '')
    {
        if ($testFile === 'ConstructorProxyInterceptorUnitTest.1.inc') {
            return [
                17 => 1,
                18 => 1,
                36 => 2,
                43 => 1
            ];
        } elseif ($testFile === 'ConstructorProxyInterceptorUnitTest.2.inc') {
            return [
                17 => 1,
                18 => 1,
                36 => 2,
                43 => 1
            ];
        }
        return [];
    }
}
