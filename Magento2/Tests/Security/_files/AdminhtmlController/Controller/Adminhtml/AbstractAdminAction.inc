<?php
namespace Vendor\Module\Controller\Adminhtml;

use Magento\Backend\App\Action;

abstract class AbstractAdminAction extends Action
{
    public const ADMIN_RESOURCE = 'Vendor_Module::entity';
}
