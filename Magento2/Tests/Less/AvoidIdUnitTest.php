<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento2\Tests\Less;

class AvoidIdUnitTest extends AbstractLessSniffUnitTestCase
{
    /**
     * @inheritdoc
     */
    public function getErrorList()
    {
        return [
            6 => 1,
            7 => 1,
            8 => 1,
            9 => 1,
            10 => 1,
            11 => 1,
            12 => 1,
            13 => 1,
            14 => 1,
            15 => 1,
            16 => 1,
            17 => 1,
            18 => 1,
            19 => 1,
            20 => 1,
            21 => 1,
            22 => 1,
            26 => 1,
            27 => 1,
            28 => 1
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
