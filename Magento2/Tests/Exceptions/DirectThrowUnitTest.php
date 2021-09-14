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
    public function getErrorList()
    {
        return [];
    }

    /**
     * @inheritdoc
     */
    public function getWarningList()
    {
        return [
            10 => 1,
            17 => 1,
        ];
    }
}
