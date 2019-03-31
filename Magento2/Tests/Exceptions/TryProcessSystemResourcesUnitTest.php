<?php
/**
 * Copyright © Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento2\Tests\Exceptions;

use PHP_CodeSniffer\Tests\Standards\AbstractSniffUnitTest;

/**
 * Class ThrowCatchUnitTest
 */
class TryProcessSystemResourcesUnitTest extends AbstractSniffUnitTest
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
            21 => 1,
            38 => 1,
            40 => 1,
            42 => 1,
            44 => 1
        ];
    }
}
