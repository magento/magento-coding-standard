<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento2\Tests\Annotation;

use PHP_CodeSniffer\Tests\Standards\AbstractSniffUnitTest;

class MethodAnnotationStructureUnitTest extends AbstractSniffUnitTest
{
    /**
     * @inheritdoc
     */
    public function getErrorList()
    {
        return [
            10 => 1,
            18 => 1,
            30 => 1,
            36 => 1,
            45 => 2,
            47 => 1,
            55 => 1,
            63 => 1,
            80 => 1,
            112 => 1,
            118 => 1,
            137 => 1,
            145 => 2,
            185 => 1,
            227 => 1,
            235 => 1,
            268 => 2,
            269 => 1,
            277 => 1,
            278 => 1,
            288 => 1,
            289 => 1,
            298 => 1
        ];
    }

    /**
     * @inheritdoc
     */
    public function getWarningList()
    {
        return [
            326 => 1,
            336 => 1,
            347 => 1,
            358 => 1
        ];
    }
}
