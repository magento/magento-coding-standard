<?php

$productTable = $this->_resource->getTableName('/catalog_category_product');

$collection->joinField(
    'inventory_in_stock',
    '/cataloginventory_stock_item',
    'is_in_stock',
    'product_id=entity_id',
    '(' . join(') OR (', $cond) . ')'
);

$collection->getFkName(
    'inventory_in_stock',
    $collection,
    '/is_in_stock'
);

$select = $connection->select()->from(
    ['main_table' => 'magento/sample_table']
);

$select = $connection->select()->from(
    ['main_table_name' => 'magento/sample_table']
);

$select = $connection->select()->from(
    ['main_table' => 'magento_sample_table']
);

class Collection extends \Magento\Sales\Model\ResourceModel\Report\Order\Collection
{
    /**
     * Aggregated Data Table
     *
     * @var string
     */
    protected $_aggregationTable = 'magento/sales_order_aggregated_updated';
}
