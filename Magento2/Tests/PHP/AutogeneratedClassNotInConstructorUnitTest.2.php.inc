<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types = 1);

namespace Magento2\Tests\PHP;

use Magento\Catalog\Model\Product;
use Magento\Eav\Api\AttributeRepositoryInterface;
use Magento\Eav\Setup\AddOptionToAttribute;
use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\Setup\ModuleDataSetupInterface;

class Bad
{
    public function __construct()
    {
        $this->model = ObjectManager::getInstance()->get(ModelFactory::class);
    }

    protected function setUp(): void
    {
        ObjectManager::getInstance()
            ->get(EavSetupFactory::class);
        $objectManager = ObjectManager::getInstance();

        /** @var EavSetup $eavSetup */
        $this->eavSetup = $objectManager
            ->get(EavSetupFactory::class)
            ->create(['setup' => $this->setup]);

        ObjectManager::getInstance()
            ->get(\Full\Class\NameFactory::class);
    }

    private function foo(): void
    {
        ObjectManager::getInstance() ;
    }
}

