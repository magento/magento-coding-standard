<?php
namespace Vendor\Module\Controller\Adminhtml;

class FrameworkContextFqcn extends \Magento\Backend\App\Action
{
    public const ADMIN_RESOURCE = 'Vendor_Module::entity';

    public function __construct(\Magento\Framework\App\Action\Context $context)
    {
        parent::__construct($context);
    }
}
