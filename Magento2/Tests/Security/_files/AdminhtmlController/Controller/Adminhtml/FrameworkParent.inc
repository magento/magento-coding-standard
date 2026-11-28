<?php
namespace Vendor\Module\Controller\Adminhtml;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;

class FrameworkParent extends Action
{
    const ADMIN_RESOURCE = 'Magento_Config::config';

    private $resultJson;

    public function __construct(Context $context, JsonFactory $resultJsonFactory)
    {
        $this->resultJson = $resultJsonFactory;
        parent::__construct($context);
    }
}
