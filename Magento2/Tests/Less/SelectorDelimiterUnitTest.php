<?php
/**
 * Copyright © Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento2\Tests\Less;

class SelectorDelimiterUnitTest extends AbstractLessSniffUnitTestCase
{
    /**
     * @inheritdoc
     */
    public function getErrorList()
    {
        return [
            11 => 1
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
