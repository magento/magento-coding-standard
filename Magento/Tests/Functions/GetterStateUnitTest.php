<?php
/**
 * Copyright © Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magento\Tests\Functions;

use PHP_CodeSniffer\Tests\Standards\AbstractSniffUnitTest;

/**
 * Class GetterStateUnitTest
 */
class GetterStateUnitTest extends AbstractSniffUnitTest
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
    protected function getWarningList()
    {
        return [
            28 => 1,
            29 => 1,
            30 => 1,
            43 => 1,
        ];
    }
}
