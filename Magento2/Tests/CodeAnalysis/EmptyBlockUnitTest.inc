<?php

switch ($foo) {
    // Empty switch statement body
}

switch ($foo) {
    case 'bar':
        break;
    default:
        break;
}


if ($foo) {
    // Just a comment
} elseif ($bar) {
    // Yet another comment
} else {

}

if ($foo) {
    $foo = 'bar';
} else if ($bar) {
    $bar = 'foo';
}

for ($i = 0; $i < 10; $i++) {
    for ($j = 0; $j < 10; $j++) {
        // Just a comment
    }
}

foreach ($foo as $bar) {}

foreach ($foo as $bar) {
    $bar *= 2;
}

do {
    // Just a comment
    // Just another comment
} while ($foo);

do {
    while ($bar) {

    }
} while (true);

while ($foo) { /* Comment in the same line */}

while ($foo) {
    try {

    } catch (Exception $e) {
        echo $e->getTraceAsString();
    }
}

try {
    throw Exception('Error...');
} catch (Exception $e) {}

try {
    throw Exception('Error...');
} catch (Exception $e) {
    // Handle this exception later :-)
}

if (true) {} elseif (false) {}

function emptyFunction () { /*Empty function block*/ }

function nonEmptyFunction () { return true; }

function aroundEmptyFunction ($foo, $bar) { }

class Foo {
    public function __construct(private $bar) {}
}

class Foo2 {
    public function __construct() {}
}

class Foo3 {
    public function __construct(private $bar, $baz) {}
}
