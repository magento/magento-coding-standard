<?php

class MyExampleClass implements \ArrayAccess
{
    public function offsetExists($offset)
    {
    }
    public function offsetGet($offset)
    {
    }
    public function offsetSet($offset, $value)
    {
    }
    public function offsetUnset($offset)
    {
    }
}

?>
-----
<?php

class MyExampleClass implements \ArrayAccess
{
    public function offsetExists($offset): bool
    {
    }
    public function offsetGet($offset)
    {
    }
    public function offsetSet($offset, $value): void
    {
    }
    public function offsetUnset($offset): void
    {
    }
}

?>
