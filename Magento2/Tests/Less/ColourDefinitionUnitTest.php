<?php
/**
 * Copyright © Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento2\Tests\Less;

class ColourDefinitionUnitTest extends AbstractLessSniffUnitTestCase
{
    /**
     * @inheritdoc
     */
    public function getErrorList()
    {
        return [
            6 => 1,
            7 => 1,
            15 => 1,
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
