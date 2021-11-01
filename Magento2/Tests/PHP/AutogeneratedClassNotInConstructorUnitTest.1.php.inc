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
        ModelFactory $model = null
    )
    {
        $this->model = $model ?? ObjectManager::getInstance()->get(ModelFactory::class);
    }

    /**
     * @return Model
     */
    public function otherMethodThatCallsGetInstanceBad(): void
    {
        $modelFactory = ObjectManager::getInstance()->get(OtherFactory::class);
        $modelFactory->create();
    }

    /**
     * @return Model
     */
    public function otherMethodThatCallsGetInstanceGood(): void
    {
        $model = $this->model ?? ObjectManager::getInstance()->get(Model::class);
        $model->something();
    }

    public function variablePositive(): void
    {
        $objectManager = ObjectManager::getInstance();
        $this->_entityFactory = $objectManager->get(EntityFactoryInterface::class);
    }

    public function variableNegative(): void
    {
        $objectManager = ObjectManager::getInstance();
        $this->_entityFactory = $objectManager->get(EntityFactory::class);
    }
}


