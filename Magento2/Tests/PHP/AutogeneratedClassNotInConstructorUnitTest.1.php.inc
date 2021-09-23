<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types = 1);

namespace Magento2\Tests\PHP;

use Magento2\OneModel as Model;

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
    public function otherMethodThatCallsGetInstanceBad(): void
    {
        $model = ObjectManager::getInstance()->get(Model::class);
        $model->something();
    }

    /**
     * @return Model
     */
    public function otherMethodThatCallsGetInstanceGood(): void
    {
        $model = $this->model ?? ObjectManager::getInstance()->get(Model::class);
        $model->something();
    }
}
