<?php
namespace Vendor\Module\Anyname;

use Vendor\Module\Anyname\Exception;

class Foo
{
    protected $isEnabled = true;

    public function go()
    {
        if (!$this->isEnabled) {
            throw new Exception('Action disabled.');
        }
    }

    public function exceptionTest()
    {
        if (!$this->isEnabled) {
            throw new \Exception('Action disabled.');
        }
    }

    public function localizedExceptionTest()
    {

        if (!$this->isEnabled) {
            throw new LocalizedException('Localized exception.');
        }
    }
}
