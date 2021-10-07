<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

$this->_getReadConnection();

$connection = new Connection();
return $connection->_getWriteConnection();

$this->getMethod(
    function($param){
        $param->_getWriteAdapter();
    }
);

$writeAdapter = $this->getWriteAdapter();

protected function getConnection()
{
    return $this->_resource->getReadConnection($this->connection);
}

return $this->_getReadAdapter();

$this->getReadAdapterMyMehtod();

private function getReadAdapter()
{

}

$getWriteAdapter = new WriteAdapter();

$getWriteAdapter = $this->getWriteAdapter();
