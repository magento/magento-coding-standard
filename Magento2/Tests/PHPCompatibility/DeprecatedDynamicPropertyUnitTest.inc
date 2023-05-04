<?php
/*
 * Test: Creation of dynamic property when class cannot be autoloaded
 */

trait TraitA
{
    private bool $prop2;
}

trait TraitB
{
    private bool $prop3;
}

class Bar
{
    public bool $prop1;

    public function resetProp1()
    {
        $this->prop1 = false;
    }
}

/**
 * @property bool $prop6 full format
 * @property $prop7 prop without type
 * @property bool prop8 prop with comment
 */
class Foo1 extends Bar
{
    use TraitA, TraitB;
    private bool $prop4;
    public function __construct(
        private bool $prop5
    ) {
    }

    private function reset(): void
    {
        $this->resetProp1();
        $this->prop1 = false;
        $this->prop2 = false;
        $this->prop3 = false;
        $this->prop4 = false;
        $this->prop5 = false;
        $this->prop6 = false;
        $this->prop7 = false;
        $this->prop8 = false;
        $this->prop9 = false;
    }
}

/**
 * @property bool $prop6 full format
 * @property $prop7 prop without type
 * @property bool prop8 prop with comment
 */
class Foo2
{
    use TraitA, TraitB;
    private bool $prop4;
    public function __construct(
        private bool $prop5
    ) {
    }

    private function reset(): void
    {
        $this->resetProp1();
        $this->prop1 = false;
        $this->prop2 = false;
        $this->prop3 = false;
        $this->prop4 = false;
        $this->prop5 = false;
        $this->prop6 = false;
        $this->prop7 = false;
        $this->prop8 = false;
        $this->prop9 = false;
    }
}

/**
 * @property bool $prop6 full format
 * @property $prop7 prop without type
 * @property bool prop8 prop with comment
 */
class Foo3 extends Bar
{
    private bool $prop4;
    public function __construct(
        private bool $prop5
    ) {
    }

    private function reset(): void
    {
        $this->resetProp1();
        $this->prop1 = false;
        $this->prop2 = false;
        $this->prop3 = false;
        $this->prop4 = false;
        $this->prop5 = false;
        $this->prop6 = false;
        $this->prop7 = false;
        $this->prop8 = false;
        $this->prop9 = false;
    }
}

/**
 * @property bool $prop6 full format
 * @property $prop7 prop without type
 * @property bool prop8 prop with comment
 */
class Foo4
{
    private bool $prop4;
    public function __construct(
        private bool $prop5
    ) {
    }

    private function reset(): void
    {
        $this->resetProp1();
        $this->prop1 = false;
        $this->prop2 = false;
        $this->prop3 = false;
        $this->prop4 = false;
        $this->prop5 = false;
        $this->prop6 = false;
        $this->prop7 = false;
        $this->prop8 = false;
        $this->prop9 = false;
    }
}

class Foo5
{
    private bool $prop4;
    public function __construct(
        private bool $prop5
    ) {
    }

    private function reset(): void
    {
        $this->resetProp1();
        $this->prop1 = false;
        $this->prop2 = false;
        $this->prop3 = false;
        $this->prop4 = false;
        $this->prop5 = false;
        $this->prop6 = false;
        $this->prop7 = false;
        $this->prop8 = false;
        $this->prop9 = false;
        $this/** a comment */ ->/** another comment*/ prop9 = false;
        $this->setSomething($this->prop9);
        $prop9 = $this->prop9;
        $this::$prop9 = false;
        $this->prop4->prop9 = false;
        $thisVar = $this;
        $thisVar->prop9 = false; // undetermined context
        $thisVar->$this->prop9 = false; // false positive
    }

    public function setSomething()
    {

    }
}

$object->prop9 = false;
$object->reset();
