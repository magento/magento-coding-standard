<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento2\Tests\Namespaces;

use PHP_CodeSniffer\Tests\Standards\AbstractSniffUnitTest;

/**
 * Class InterfaceNameUnitTest
 */
class ImportsFromTestNamespaceUnitTest extends AbstractSniffUnitTest
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
            2 => 1,
            5 => 1
        ];
    }
}
