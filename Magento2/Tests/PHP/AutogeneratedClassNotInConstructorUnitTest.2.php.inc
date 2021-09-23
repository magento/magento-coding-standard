<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types = 1);

namespace Magento2\Tests\PHP;

class Bad
{
    public function __construct()
    {
        $this->model = ObjectManager::getInstance()->get(Model::class);
    }
}

