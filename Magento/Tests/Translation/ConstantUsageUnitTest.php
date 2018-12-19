<?php
/**
 * Copyright © Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\Tests\Translation;

use PHP_CodeSniffer\Tests\Standards\AbstractSniffUnitTest;

/**
 * Class ConstantUsageUnitTest
 */
class ConstantUsageUnitTest extends AbstractSniffUnitTest
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
            9 => 1,
            11 => 1,
            12 => 1,
            15 => 1,
        ];
    }
}
