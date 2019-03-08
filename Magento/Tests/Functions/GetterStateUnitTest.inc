<?php

namespace Foo\Bar;


abstract class Bar{

    public static $foobar  = 100;
}

class Foo extends Bar
{
    /**
     * @var int
     */
    private static $staticProperty;

    /**
     * @var int
     */
    private $property;

    /**
     * @return int
     */
    public function getStaticProperty()
    {
        self::$staticProperty = 12;
        static::$staticProperty -= 12;
        self::$staticProperty .= 12;
        return self::$staticProperty;
    }

    /**
     * @return int
     */
    public function getProperty()
    {
        $this->property = 1223;
        return $this->property;
    }

    public function TestigetFoo()
    {
        $this->property = 1223;
        return $this->property;
    }

    /**
     * @return int
     */
    public function normalMethod()
    {
        $localVariable = 12;
        return $localVariable;
    }
}

$d = function ($test) {
    $test = 123;
};

