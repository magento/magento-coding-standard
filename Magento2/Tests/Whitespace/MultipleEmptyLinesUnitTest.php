<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento2\Tests\Whitespace;

use PHP_CodeSniffer\Tests\Standards\AbstractSniffUnitTest;

class MultipleEmptyLinesUnitTest extends AbstractSniffUnitTest
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
            6 => 1,
            12 => 1,
        ];
    }
}
