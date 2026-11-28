<?php
namespace Vendor\Module\Controller\Adminhtml;

use Magento\Backend\App;

class RelativeParent extends App\Action
{
    public const ADMIN_RESOURCE = 'Vendor_Module::entity';
}

class NamespaceRelativeParent extends namespace\AbstractAdminAction
{
}
