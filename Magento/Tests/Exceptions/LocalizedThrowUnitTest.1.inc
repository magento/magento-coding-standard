<?php
/**
 *
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magento\Catalog\Controller\Product;

use Magento\Framework\App\Action\HttpPostActionInterface as HttpPostActionInterface;
use Magento\Framework\App\Action\HttpGetActionInterface as HttpGetActionInterface;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Catalog\Controller\Product as ProductAction;

/**
 * View a product on storefront. Needs to be accessible by POST because of the store switching.
 */
class View extends ProductAction implements HttpGetActionInterface, HttpPostActionInterface
{
    /**
     *
     */
    public function execute()
    {
        throw new LocalizedException(__('%1 doesn\'t exists'));
    }
}
