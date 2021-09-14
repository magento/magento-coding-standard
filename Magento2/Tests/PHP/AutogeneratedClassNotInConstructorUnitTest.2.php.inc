<?php
/**
 * Copyright © Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magento2\Tests\PHP;

class Bad
{
    public function __construct()
    {
        $this->model = ObjectManager::getInstance()->get(Model::class);
    }
}

