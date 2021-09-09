<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento2\Tests\Legacy;

use PHP_CodeSniffer\Tests\Standards\AbstractSniffUnitTest;

class AbstractBlockUnitTest extends AbstractSniffUnitTest
{
    /**
     * @inheritdoc
     */
    public function getErrorList()
    {
        return [
            10 => 1,
            20 => 1,
            24 => 1,
            28 => 1,
            30 => 1
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function getWarningList()
    {
        return [];
    }
}
