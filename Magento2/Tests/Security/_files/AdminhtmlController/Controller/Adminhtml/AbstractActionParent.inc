<?php
namespace Vendor\Module\Controller\Adminhtml;

use Magento\Backend\App\AbstractAction;

class AbstractActionParent extends AbstractAction
{
    public const ADMIN_RESOURCE = 'Vendor_Module::entity';
}

class AbstractActionWithoutResource extends AbstractAction
{
}
