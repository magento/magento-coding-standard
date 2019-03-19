<?php

require 'a.inc';
require_once 'b.inc';

require_once('c.inc');
require('d.inc');

include 'a1.inc';
include_once 'b1.php';

include_once('http://c1.inc');
include('ftp://d1/file.php');

include('a' . 'b');

require_once 'a' . 'b';

class TestInclude
{
    public function go($a)
    {
        include "$a";
        include "$a" . 'test';
    }
}

require_once 'test.php';

class Some_MagentoController extends Mage_Adminhtml_Controller_Action
{
    public function a()
    {
        require_once "o.inc";
    }
}

require_once 'controller.php';

class Some_MagentoController2 extends Some_OtherClass
{
}
