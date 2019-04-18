<?php
/**
 * Copyright © Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento2\Tests\Classes;

use PHP_CodeSniffer\Tests\Standards\AbstractSniffUnitTest;

/**
 * Class ObjectInstantiationUnitTest
 */
class AbstractApiUnitTest extends AbstractSniffUnitTest
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
        if ($testFile === 'AbstractApiUnitTest.1.inc') {
            return [
                14 => 1,
                23 => 1
            ];
        }

        return [];
    }
}
