<?php

final class ImABadExample {}

class ImAlsoABadExample {
    final public function badFinalFunction(){}
}

class ImAGoodExample {}

class ImAlsoAGoodExample {
    private function emptyFunction(){}
}
