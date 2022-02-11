<?php

final class CrossVersionInValid
{
    private final function __construct() {}
    final private function privateFinal();
    static private final function privateStaticFinal();
    static protected final function protectedStaticFinal();
    final protected function protectedFinal();
}

$anon = new class() {
    private final function __construct() {}
    final private function privateFinal();
    static final private function privateStaticFinal();
    final protected function protectedFinal();
    static final protected function protectedStaticFinal();
};

trait CrossVersionInValidTrait
{
    private final function __construct() {}
    final private function privateFinal();
    final protected function protectedFinal();
    static private final function privateStaticFinal();
    static protected final function protectedStaticFinal();
}
