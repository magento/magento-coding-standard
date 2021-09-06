<?php

namespace Magento;

class foo_baz{};

$model = Mage::getModel('Magento\foo_bar');
$model = Mage::getModel('baz\FooBar');
$model = Mage::getModel('Magento\FooBar');
$model = Mage::getModel('MAGENTO\FooBar');
