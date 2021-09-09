<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento2\Tests\Less;

class ZeroUnitsUnitTest extends AbstractLessSniffUnitTestCase
{
    /**
     * @inheritdoc
     */
    public function getErrorList()
    {
        return [
            7 => 1,
            8 => 1,
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
