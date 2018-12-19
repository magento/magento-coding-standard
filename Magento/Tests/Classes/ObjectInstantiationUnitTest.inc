<?php

// not allowed
$splInstance = new \SplFixedArray();

$magentoNamespaceInstance = new Magento\Sales\Model\Order();

$magentoInstance = new Order();

$selfInstance = new self();

$staticInstance = new static();

//allowed
if ($somethingBad === true) {
    throw new \Magento\Framework\Exception\LocalizedException(__('Oops'));
}

if ($somethingVeryBad === true) {
    throw new \Exception('Ooooops');
}
