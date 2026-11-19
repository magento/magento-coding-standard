<?php

function getCheckSql($expression, $true, $false)
{
    if ($expression instanceof \Zend_Db_Expr || $expression instanceof \Zend_Db_Select) {
        $expression = sprintf("IF((%s), %s, %s)", $expression, $true, $false);
    } else {
        $expression = sprintf("IF(%s, %s, %s)", $expression, $true, $false);
    }

    return new \Zend_Db_Expr($expression);
}

use Magento\Framework\Serialize\Serializer\Serialize;
use Magento\Framework\Serialize\Serializer\Json;
use Vendor\Magento\Framework\HTTP\ZendClient;
use Magento\Framework\HTTP\ZendClient\Adapter;

function getClient()
{
    return new \Magento\Framework\HTTP\ZendClient();
}

function getParser(): GraphQL\Language\Parser
{
    return new namespace\GraphQL\Language\Parser();
}

$select = Zend_Db_Select\Extended::class;
