<?php

class CrossVersionInValid
{
    private final function __construct() {}
    final private function privateFinal();
    static private final function privateStaticFinal();
}

$anon = new class() {
    private final function __construct() {}
    final private function privateFinal();
    static final private function privateStaticFinal();
};

trait CrossVersionInValidTrait
{
    private final function __construct() {}
    final private function privateFinal();
    static private final function privateStaticFinal();
}
