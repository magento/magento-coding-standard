<?php

class Fixture
{
    public function ok()
    {
        $this->create(Magento\CustomerSegment\Model\Segment\Condition\Customer\Address::class);
    }

    public function notOk()
    {
        $this->create('Magento\CustomerSegment\Model\Segment\Condition\Customer\Address');
    }
}
