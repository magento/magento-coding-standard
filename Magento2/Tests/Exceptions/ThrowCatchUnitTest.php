<?php
/**
 * Copyright © Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magento2\Tests\Exceptions;

use PHP_CodeSniffer\Tests\Standards\AbstractSniffUnitTest;

class ThrowCatchUnitTest extends AbstractSniffUnitTest
{
    /**
     * @inheritdoc
     */
    protected function getErrorList()
    {
        return [];
    }

    /**
     * @inheritdoc
     */
    protected function getWarningList($testFile = '')
    {

        if ($testFile === 'ThrowCatchUnitTest.1.inc') {
            return [];
        }

        return [
            41 => 1,
            120 => 1,
            126 => 1,
            145 => 1,
            156 => 1
        ];
    }
}
