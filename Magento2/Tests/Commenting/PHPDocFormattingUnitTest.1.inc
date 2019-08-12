<?php

class EverythingIsGoodHere
{
    /**
     * @param string $arg1
     * @param bool $arg2
     */
    private function missingArgumentTypeSoParamsNeedToBeAdded($arg1, $arg2): bool
    {
    }

    /**
     * @return bool
     */
    private function presentArgumentTypeSoAnnotationNotNeededButMissingReturnType(string $arg1, bool $arg2)
    {
    }

    private function presentArgumentAndReturnTypes(string $arg1, bool $arg2): bool
    {
    }

    /**
     * @throws Exception
     */
    private function throwsAnException(): void
    {
        throw new \Exception();
    }

    /**
     * We have an additional wonderful message here.
     *
     * @return void
     */
    private function presentGoodDescription(string $arg1, bool $arg2)
    {
    }
}
