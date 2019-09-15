<?php

class EverythingIsGoodHere
{

    public function __construct(string $arg1)
    {
    }

    private function executeSimpleFunctionNoDoc(): void
    {
    }

    /**
     * We have an wounderfull meaning desciption there also
     *
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
        throw new Exception();
    }

    /**
     * We have an additional wonderful message here.
     *
     * @return void
     */
    private function presentGoodDescription(string $arg1, bool $arg2)
    {
    }

    /**
     * @param bool $arg1
     * @return string
     */
    private function docBlockIsEquels(bool $arg1): string
    {

        return '';
    }
}
