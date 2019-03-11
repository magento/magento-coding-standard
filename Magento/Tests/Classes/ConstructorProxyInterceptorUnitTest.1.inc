<?php

namespace Vendor\Module\Plugin;

use \Vendor\Module\Plugin\AnyName as PlugAlias;
use \Exception as SafeAlias;

class AnyName {}

/**
 * // Rule find: constructor use of plugin class
 */
class Foo
{
    public function __construct(
            $first,
            \Vendor\Module\Plugin\AnyName $anything,
            $plugin,
            $another = []
    )
    {

    }
    public function notAConstruct(
        \Vendor\Module\Plugin\AnyName $anything
    )
    {

    }
}

/**
 * // Rule find: constructor use of plugin class with alias
 */
class Foo2 {
    public function __construct(PlugAlias $anything, $aPlugin) {}
}

/**
 * // Rule find: constructor use of plugin class with use statement
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