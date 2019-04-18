<?php

/**
 * Interface FooInterface
 * @api
 */
interface FooInterface
{
    public function execute();
}

/**
 * // Rule find: api annotation for this class
 * @api
 */
abstract class Foo implements FooInterface
{

}

/**
 * // Rule find: api annotation for this class
 * @api
 */
abstract
class FooBar implements FooInterface
{

}

/**
 * Class Bar
 */
class Bar extends Foo
{
    public function execute()
    {
        // TODO: Implement execute() method.
    }
}
