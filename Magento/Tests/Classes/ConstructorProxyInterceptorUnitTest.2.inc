<?php

namespace Vendor\Module\Proxy;

use \Vendor\Module\Proxy\AnyName as ProxAlias;
use \Exception as SafeAlias;

class AnyName {}

/**
 * // Rule find: constructor use of proxy class
 */
class Foo
{
    public function __construct(
            $first,
            \Vendor\Module\Proxy\AnyName $anything,
            $proxy,
            $another = []
    )
    {

    }
    public function notAConstruct(
        \Vendor\Module\Proxy\AnyName $anything
    )
    {

    }
}

/**
 * // Rule find: constructor use of proxy class with alias
 */
class Foo2 {
    public function __construct(ProxAlias $anything, $aProxy) {}
}

/**
 * // Rule find: constructor use of proxy class with use statement
 */
class Foo3 {
    public function __construct(AnyName $anything) {}
}

/**
 * // Rule find: This is fine
 */
class Foo4
{
    public function __construct(SafeAlias $other) {

    }
}