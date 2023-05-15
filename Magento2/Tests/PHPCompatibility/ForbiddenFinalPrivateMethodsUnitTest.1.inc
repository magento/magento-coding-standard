<?php
class ForbiddenFinalPrivateMethodsUnitTest1
{
    private final function __construct() {}
    private final function privateFinalMethod() {}
    final private function finalPrivateMethod() {}
    protected final function protectedFinalMethod() {}
    final protected function finalProtectedMethod() {}
    public final function publicFinalMethod() {}
    final public function finaPublicMethod() {}
    final private static function finalPrivateStaticMethod() {}
    private final static function privateFinalStaticMethod() {}
    private static final function privateStaticFinalMethod() {}
    final protected static function finalProtectedStaticMethod() {}
    protected final static function protectedFinalStaticMethod() {}
    protected static final function protectedStaticFinalMethod() {}
    final public static function finalPublicStaticMethod() {}
    public final static function publicFinalStaticMethod() {}
    public static final function publicStaticFinalMethod() {}
}
