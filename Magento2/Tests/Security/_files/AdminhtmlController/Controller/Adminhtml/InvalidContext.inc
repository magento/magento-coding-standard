<?php
namespace Vendor\Module\Controller\Adminhtml;

use Magento\Backend\App\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Element\Template\Context as TemplateContext;

class InvalidContext extends Action
{
    public const ADMIN_RESOURCE = 'Vendor_Module::entity';

    public function __construct(TemplateContext $context)
    {
        parent::__construct($context);
    }
}

class FrameworkContextSharedImport extends Action
{
    public const ADMIN_RESOURCE = 'Vendor_Module::entity';

    public function __construct(Context $context)
    {
        parent::__construct($context);
    }
}

class FrameworkContextNotPassed extends Action
{
    public const ADMIN_RESOURCE = 'Vendor_Module::entity';

    public function __construct(Context $context, TemplateContext $templateContext)
    {
        $this->context = $context;
    }
}
