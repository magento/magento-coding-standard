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
        $this->create('Magento\\CustomerSegment\\Model\\Segment\\Condition\\Customer\\Address');
        $this->create("Magento\\CustomerSegment\\Model\\Segment\\Condition\\Customer\\Address");
        $this->create('\Magento\CustomerSegment\Model\Segment\Condition\Customer\Address');
        $this->create('\Magento\\CustomerSegment\\Model\\Segment\\Condition\\Customer\\Address');
        $this->create("\Magento\\CustomerSegment\\Model\\Segment\\Condition\\Customer\\Address");
    }

    public function thisIsFine(string $class)
    {
        $this->create('Magento\\Module\\' . $class);
        $this->create("Magento\\Module\\" . $class);
        $this->create("Magento\\Module\\$class");
    }
}
