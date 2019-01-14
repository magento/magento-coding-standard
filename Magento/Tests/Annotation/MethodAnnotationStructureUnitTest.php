<?php
/**
 * Copyright © Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\Tests\Annotation;

use PHP_CodeSniffer\Tests\Standards\AbstractSniffUnitTest;

/**
 * Class MethodAnnotationStructureUnitTest
 */
class MethodAnnotationStructureUnitTest extends AbstractSniffUnitTest
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
    public function getWarningList()
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
            111 => 1,
            117 => 1,
            136 => 1,
            144 => 2,
            184 => 1,
            227 => 1,
            235 => 1,
            268 => 2,
            269 => 1,
            277 => 1,
            278 => 1,
            288 => 1,
            289 => 1,
            298 => 1,
        ];
    }
}
