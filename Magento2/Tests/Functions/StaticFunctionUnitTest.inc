<?php

namespace Foo\Bar;

interface  FooInterface
{
    public static
    function aStaticMethod();

    public function normalMethod();
}

class Foo implements FooInterface
{
    private static $property;

    public static function aStaticMethod()
    {
        return self::$property;
    }

    public function normalMethod()
    {
        return $this;
    }
}
