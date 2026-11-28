<?php
namespace Vendor\Module\Controller\Adminhtml;

use Magento\Backend\App\Action\Context;

class CustomBaseChild extends AbstractAdminAction
{
    public function __construct(Context $context)
    {
        parent::__construct($context);
    }
}
