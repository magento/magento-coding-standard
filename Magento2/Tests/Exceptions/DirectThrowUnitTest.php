<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento2\Tests\Exceptions;

use PHP_CodeSniffer\Tests\Standards\AbstractSniffUnitTest;

class DirectThrowUnitTest extends AbstractSniffUnitTest
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
        if ($testFile === 'DirectThrowUnitTest.1.inc') {
            return [
                10 => 1,
                17 => 1,
            ];
        } elseif ($testFile === 'DirectThrowUnitTest.2.inc') {
            return [
                20 => 1
            ];
        }
        return [];
    }
}
