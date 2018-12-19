<?php
/**
 * Copyright © Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\Tests\Strings;

use PHP_CodeSniffer\Tests\Standards\AbstractSniffUnitTest;

/**
 * Class RegExUnitTest
 */
class RegExUnitTest extends AbstractSniffUnitTest
{
    /**
     * @inheritdoc
     */
    public function getErrorList()
    {
        return [
            4 => 1,
            10 => 1,
            16 => 1,
            18 => 1,
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
