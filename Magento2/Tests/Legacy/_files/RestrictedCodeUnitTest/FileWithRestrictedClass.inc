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
