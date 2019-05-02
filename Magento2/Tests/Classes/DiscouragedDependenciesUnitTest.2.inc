<?php

namespace Vendor\Module\Anyname;

use \Vendor\Module\AnyName\Proxy as ProxAlias;
use \Exception as SafeAlias;

class Proxy {}

/**
 * // Rule find: constructor use of proxy class
 */
class Foo
{
    public function __construct(
            $first,
            \Vendor\Module\AnyName\Proxy $anything,
            $proxyOnlyInName,
            ProxAliasNope $notAProblem, // should not match
            $another = []
    )
    {

    }
    public function notAConstruct(
        \Vendor\Module\Anyname\Proxy $anything
    )
    {

    }
}

/**
 * // Rule find: constructor use of proxy class with alias
 */
class Foo2 {
    public function __construct(ProxAlias $anything, $aProxyInName) {}
}

/**
 * // Rule find: constructor use of proxy class with use statement
 */
class Foo3 {
    public function __construct(Proxy $anything, InterAlias $oldAliasInName) {}
}

/**
 * // Rule find: This is fine
 */
class Foo4
{
    public function __construct(SafeAlias $other) {

    }
}

