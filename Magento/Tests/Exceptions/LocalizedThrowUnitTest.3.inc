<?php
/**
 *
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magento\Catalog\Block\Test\SubFolder;


/**
 * Class Product
 */
class Product
{
    public function execute()
    {
        throw new LocalizedException(__('Cant find %1 doesn\'t exists'));
    }
}
