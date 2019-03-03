<?php

namespace Magento\Catalog\Model\Test\SubFolder;

class Foo
{
    public function execute()
    {
        throw new \InvalidArgumentException(__('Oops'));
    }
}


