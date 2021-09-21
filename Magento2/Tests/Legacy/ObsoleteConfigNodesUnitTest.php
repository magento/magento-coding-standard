<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento2\Tests\Legacy;

use PHP_CodeSniffer\Tests\Standards\AbstractSniffUnitTest;

class ObsoleteConfigNodesUnitTest extends AbstractSniffUnitTest
{
    /**
     * @inheritdoc
     */
    public function getErrorList($testFile = ''): array
    {
        if ($testFile === 'ObsoleteConfigNodesUnitTest.1.xml') {
            return [
                35 => 1,
                37 => 1,
            ];
        }
        return [];
    }

    /**
     * @inheritdoc
     */
    public function getWarningList(): array
    {
        return [];
    }
}
