<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento2\Tests\Less;

class CommentLevelsUnitTest extends AbstractLessSniffUnitTestCase
{
    /**
     * @inheritdoc
     */
    public function getErrorList()
    {
        return [
            16 => 1,
            30 => 1,
            31 => 1,
            44 => 1,
            46 => 1,
            47 => 1
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
