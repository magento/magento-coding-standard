<?php
namespace Vendor\Module\Controller\Adminhtml\Backend {
    use Magento\Backend\App\Action;

    class BackendNamespaceController extends Action
    {
        public const ADMIN_RESOURCE = 'Vendor_Module::entity';
    }
}

namespace Vendor\Module\Controller\Adminhtml\Other {
    class OtherNamespaceController extends Action
    {
        public const ADMIN_RESOURCE = 'Vendor_Module::entity';
    }
}
