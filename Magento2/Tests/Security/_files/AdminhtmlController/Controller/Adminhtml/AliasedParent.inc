<?php
namespace Vendor\Module\Controller\Adminhtml;

use Magento\Backend\App\Action as BackendAction;
use Magento\Backend\App\Action\Context as BackendContext;

class AliasedParent extends BackendAction
{
    public const ADMIN_RESOURCE = 'Vendor_Module::entity';
}

class AliasedContext extends BackendAction
{
    public const ADMIN_RESOURCE = 'Vendor_Module::entity';

    public function __construct(BackendContext $context)
    {
        parent::__construct($context);
    }
}
