<?php

namespace Vendor\Module\Anyname;

use \Vendor\Module\AnyName\Interceptor as InterAlias;
use \Exception as SafeAlias;

class Interceptor {}

/**
 * // Rule find: constructor use of interceptor class
 */
class Foo
{
    public function __construct(
        $first,
        \Vendor\Module\AnyName\Interceptor $anything,
        $interceptorOnlyInName,
        InterAliasMorethan $fine, // should not match
        $another = []
    )
    {

    }
    public function notAConstruct(
        \Vendor\Module\Anyname\Interceptor $anything
    )
    {

    }
}

/**
 * // Rule find: constructor use of interceptor class with alias
 */
class Foo2 {
    public function __construct(InterAlias $anything, $aInterceptorInName) {}
}

/**
 * // Rule find: constructor use of interceptor class with use statement
 */
class Foo3 {
    public function __construct(Interceptor $anything) {}
}

/**
 * // Rule find: This is fine
 */
class Foo4
{
    public function __construct(SafeAlias $other) {

    }
}