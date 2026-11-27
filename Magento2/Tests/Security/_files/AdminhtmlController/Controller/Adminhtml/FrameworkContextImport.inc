<?php
namespace Vendor\Module\Controller\Adminhtml;

use Magento\Backend\App\Action;
use Magento\Framework\App\Action\Context;

class FrameworkContextImport extends Action
{
    public const ADMIN_RESOURCE = 'Vendor_Module::entity';

    public function __construct(Context $context)
    {
        parent::__construct($context);
    }
}
