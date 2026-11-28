<?php
namespace Vendor\Module\Controller\Adminhtml;

use Magento\Backend\App\{Action, Action\Context};
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\View\Element\Template\Context as TemplateContext;
use Vendor\Module\Model\EntityTrait;

class ImportedParent extends Action
{
    use EntityTrait;

    public const ADMIN_RESOURCE = 'Vendor_Module::entity';

    public function __construct(Context $context, TemplateContext $templateContext, ResultFactory $resultFactory)
    {
        parent::__construct($context);
    }
}
