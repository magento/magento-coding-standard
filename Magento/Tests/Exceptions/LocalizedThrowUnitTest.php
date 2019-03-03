<?php
/**
 * Copyright © Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magento\Tests\Exceptions;

use PHP_CodeSniffer\Tests\Standards\AbstractSniffUnitTest;

/**
 * Class NamespaceUnitTest
 */
class LocalizedThrowUnitTest extends AbstractSniffUnitTest
{
    /**
     * @inheritdoc
     */
    public function getErrorList()
    {
        return [
        ];
    }

    /**
     * @inheritdoc
     */
    public function getWarningList($testFile = '')
    {
        if ($testFile === 'LocalizedThrowUnitTest.2.inc') {
            return [
               18 => 1
            ];
        }

        return [];
    }
}
