<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento2\Tests\Functions;

/**
 * Class to test PHP deprecated function.
 */
class DeprecatedFunction
{
    /**
     * Test deprecation function.
     *
     * @return bool
     */
    public function testDeprecatedMethod(): bool
    {
        // Warning: function is deprecated without argument.
        $testMethodParam = mb_check_encoding();

        if ($testMethodParam) {
            // The function is work correct.
            $testMethodParam = mb_check_encoding('test-argument', null);
        }

        return $testMethodParam;
    }
}
