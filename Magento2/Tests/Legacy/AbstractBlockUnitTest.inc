<?php

return $this->getChildHtml(
    function($param){
        $param->something();
    },
    'aa'
);

$this->getChildHtml(
    function($param){
        $param->something();
    },
    'aa',
    2
);

return $this->getChildHtml('aa', 'bb');

return $this->getChildHtml('aa', 'bb', 1, true);

$this->getChildHtml();

$this->testMethod()->getChildHtml('aa', 'bb', 'cc');

$this->getChildChildHtml('aa', true, 'cc');

$this->getChildChildHtml('aa', true, 'cc', 1);

$this->getChildChildHtml('aa' . 'bb', !(1 + 1) * (int) $this, 'cc', 1);

private function getChildHtml($aa, $bb, $cc = 'cc')
{
}

$this->getChilChilddHtml();
