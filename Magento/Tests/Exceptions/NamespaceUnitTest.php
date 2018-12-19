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
class NamespaceUnitTest extends AbstractSniffUnitTest
{
    /**
     * @inheritdoc
     */
    public function getErrorList()
    {
        return [
            9 => 1,
            10 => 1,
            48 => 1,
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
