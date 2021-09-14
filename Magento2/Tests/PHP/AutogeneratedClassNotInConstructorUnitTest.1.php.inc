<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types = 1);

namespace Magento2\Tests\PHP;

use Magento2\Model;

class Good
{
    public function __construct(
        Model $model = null
    )
    {
        $this->model = $model ?? ObjectManager::getInstance()->get(Model::class);
    }

    /**
     * @return Model
     */
    public function otherMethodThatCallsGetInstance(): void
    {
        $model = ObjectManager::getInstance()->get(Model::class);
        $model->something();
    }
}
