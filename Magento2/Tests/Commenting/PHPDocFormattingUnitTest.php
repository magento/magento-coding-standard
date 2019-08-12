<?php
/**
 * Copyright © Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento2\Tests\Commenting;

use PHP_CodeSniffer\Tests\Standards\AbstractSniffUnitTest;

/**
 * Class ConstantsPHPDocFormattingUnitTest
 */
class PHPDocFormattingUnitTest extends AbstractSniffUnitTest
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
    public function getWarningList($testFile = '')
    {
        if ($testFile === 'PHPDocFormattingUnitTest.1.inc') {
            return [];
        }


        return [];
    }
}
