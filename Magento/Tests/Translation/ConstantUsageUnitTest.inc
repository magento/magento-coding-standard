<?php
class Foo
{
    const FOO = 'foo';
    public function test()
    {
        $bar = 'bar';
        __($bar);
        __(self::FOO);
        \Phrase($bar);
        \Phrase(self::FOO);
        __(
            static::FOO
        );
        \Phrase(
            SOME_CLASS::FOO
        );
    }
}
