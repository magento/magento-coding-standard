<?php
namespace Vendor\Module\Controller\Adminhtml;

use Magento\Backend\App\Action;

class EmptyAdminResource extends Action
{
    public const ADMIN_RESOURCE = '';
}

class TypedAdminResource extends Action
{
    public const string ADMIN_RESOURCE = 'Vendor_Module::entity';
}

class IsAllowedOverride extends Action
{
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Vendor_Module::entity');
    }
}

class MissingAdminResource extends Action
{
}
