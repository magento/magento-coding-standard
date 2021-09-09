<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento2\Tests\Less;

class ImportantPropertyUnitTest extends AbstractLessSniffUnitTestCase
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
