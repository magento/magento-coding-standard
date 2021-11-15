<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento2\Tests\PHP;

/**
 * Class to test array avtovivification.
 */
class Avtovivification
{
    /**
     * @return array
     */
    public function testNullAvtovivification()
    {
        $productIds = null;

        $productIds[] = 'test_array_value';

        return $productIds;
    }

    /**
     * @return array
     */
    public function testArrayAvtovivification()
    {
        $productIds = [];

        $productIds[] = 'test_array_value';

        return $productIds;
    }

    /**
     * @return array
     */
    public function testFalseAvtovivification()
    {
        $productIds = false;

        $productIds[] = 'test_array_value';

        return $productIds;
    }

    /**
     * @return array
     */
    public function testUndefineAvtovivification()
    {
        $productIds[] = 'test_array_value';

        return $productIds;
    }

    /**
     * @return array
     */
    public function testAvtovivification($testData)
    {
        $productIds = false !== $testData ? $testData : null;

        $productIds[] = 'test_array_value';

        return $productIds;
    }

    /**
     * @param array $productIds
     *
     * @return array
     */
    public function testWithParameterArray($productIds)
    {
        if (!empty($productIds['test_array_key'])) {
            $productIds['test_array_key'] = 'test_array_value';
        }

        return $productIds;
    }

    /**
     * @param false|array $productIds
     *
     * @return false|array
     */
    public function testWithParameterFalse($productIds = false)
    {
        if ($productIds !== false) {
            $productIds[] = 'test_array_value';
        }

        return $productIds;
    }
}
