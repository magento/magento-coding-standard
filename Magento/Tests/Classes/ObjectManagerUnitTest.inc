<?php

$this->_objectManager->get(\Magento\Sales\Model\Order::class);

$this->_om->get(\Magento\Sales\Model\Order::class);

$this->om->create(\Magento\Sales\Model\Order::class);

$shipment = $this->objectManager->create(\Magento\Sales\Model\Order::class);

$productModel = $this->_giftWrapHelper->getObjectManager()
    ->create(\Magento\Sales\Model\Order::class);

$order = $block->getObjectManager()->create(\Magento\Sales\Model\Order::class);

$order = $block->getObjectManager()->get(\Magento\Sales\Model\Order::class);

$om = $block->get(\Magento\Sales\Model\Order::class);

$om = $objectManager::get(\Magento\Sales\Model\Order::class);

$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
$product = $objectManager->create(\Magento\Sales\Model\Order::class);
