<?php
namespace Vendor\Module\Model;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;

class NotAController extends Action
{
    public function __construct(Context $context)
    {
        parent::__construct($context);
    }
}
