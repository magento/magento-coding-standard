<?php
/**
 * Copyright © Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento2\Tests\Legacy;

use PHP_CodeSniffer\Tests\Standards\AbstractSniffUnitTest;

class ObsoleteSystemConfigurationUnitTest extends AbstractSniffUnitTest
{
    /**
     * @inheritdoc
     */
    public function getErrorList($testFile = '')
    {
        return [];
    }

    /**
     * @inheritdoc
     */
    public function getWarningList($testFile = '')
    {
        if ($testFile === 'ObsoleteSystemConfigurationUnitTest.1.xml') {
            return [
                9 => 1,
                10 => 1,
            ];
        }
        if ($testFile === 'ObsoleteSystemConfigurationUnitTest.2.xml') {
            return [];
        }
        return [];
    }
}
