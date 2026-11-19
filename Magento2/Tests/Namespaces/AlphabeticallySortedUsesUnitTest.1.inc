<?php
namespace Vendor\Module\Model;

use Magento\Framework\App;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\AppInterface;
use magento\framework\Data\Collection;
use Magento\Framework\DataObject as MagentoDataObject;
use Psr\Log\LoggerInterface;
use function array_map;
use function Vendor\Module\helper;
use const PHP_EOL;

class Sorted
{
    use Zeta\ZetaTrait;
    use Alpha\AlphaTrait;

    public function run(array $items): array
    {
        $prefix = PHP_EOL;

        return array_map(function ($item) use ($prefix) {
            return $prefix . $item;
        }, $items);
    }
}
