<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento2\Tests\Security;

use PHP_CodeSniffer\Tests\Standards\AbstractSniffUnitTest;

class LanguageConstructUnitTest extends AbstractSniffUnitTest
{
    /**
     * @inheritdoc
     */
    public function getErrorList()
    {
        return [
            7 => 1,
            8 => 1,
            10 => 1,
            14 => 1,
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
