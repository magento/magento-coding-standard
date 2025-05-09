<?php
/************************************************************************
 *
 * Copyright 2024 Adobe
 * All Rights Reserved.
 *
 * NOTICE: All information contained herein is, and remains
 * the property of Adobe and its suppliers, if any. The intellectual
 * and technical concepts contained herein are proprietary to Adobe
 * and its suppliers and are protected by all applicable intellectual
 * property laws, including trade secret and copyright laws.
 * Dissemination of this information or reproduction of this material
 * is strictly forbidden unless prior written permission is obtained
 * from Adobe.
 * **********************************************************************
 */
declare(strict_types = 1);

namespace Magento2\Tests\Templates;

use PHP_CodeSniffer\Tests\Standards\AbstractSniffUnitTest;

class ObjectManagerUnitTest extends AbstractSniffUnitTest
{
    /**
     * @inheritdoc
     */
    public function getWarningList($filename = '')
    {
        if ($filename === 'ObjectManagerUnitTest.1.phtml.inc') {
            return [
                18 => 1
            ];
        }
        return [];
    }

    /**
     * @inheritdoc
     */
    public function getErrorList($filename = '')
    {
        return [];
    }
}
