<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento2\Tests\Annotation;

use PHP_CodeSniffer\Tests\Standards\AbstractSniffUnitTest;

class MethodArgumentsUnitTest extends AbstractSniffUnitTest
{
    /**
     * @inheritdoc
     */
    public function getErrorList()
    {
        return [
            12 => 1,
            21 => 1,
            32 => 1,
            50 => 1
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
