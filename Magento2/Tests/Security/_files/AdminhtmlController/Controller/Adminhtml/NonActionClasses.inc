<?php
namespace Vendor\Module\Controller\Adminhtml\Entity;

use Magento\Framework\App\Action\Context;

class Builder
{
    public function __construct(Context $context)
    {
    }

    public function build()
    {
    }
}

class EntityLoader extends \Magento\Framework\DataObject
{
}

class Composite implements \Vendor\Module\Model\HandlerInterface
{
}

class SavePlugin
{
    public function aroundExecute($subject, callable $proceed)
    {
        return $proceed();
    }
}
