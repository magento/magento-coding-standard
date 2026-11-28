<?php
namespace Vendor\Module\Controller\Adminhtml;

use Magento\Backend\App\Action;

interface MultipleClassesInterface
{
}

trait MultipleClassesTrait
{
}

class ValidController extends Action implements MultipleClassesInterface
{
    public const ADMIN_RESOURCE = 'Vendor_Module::entity';

    public function execute()
    {
        return new class extends \Magento\Framework\App\Action\Action {
        };
    }
}

class InvalidController extends \Magento\Framework\DataObject
{
    public function execute()
    {
    }
}

abstract class SameFileBase extends Action
{
    public const ADMIN_RESOURCE = 'Vendor_Module::entity';
}

class SameFileChild extends SameFileBase
{
}
