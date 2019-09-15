<?php


class EverythingIsBadHere
{


    /**
     * @param string $arg1
     */
    private function removeParam ()
    {
    }

    /**
     * @param bool $arg2
     * @param string $arg1
     */
    private function wrongParamOrder($arg1, $arg2): bool
    {
    }

    /**
     * @param bool $arg2
     */
    private function missingParamAnnotation($arg1, $arg2): bool
    {
    }

    private function missingArgumentAnnotations($arg1, $arg2): bool
    {

    }

    /**
     * @param string $arg1
     * @param bool $arg2
     * @param bool $arg2
     */
    private function paramDuplication($arg1, $arg2): bool
    {
    }

    /**
     * @inheritdoc
     */
    private function inheritDocShouldNotBeUsed(string $arg1, bool $arg2)
    {
    }

    /**
     * @param $arg1
     * @param $arg2
     */
    private function missingParamType($arg1, $arg2): bool
    {
    }

    /**
     * Useless description
     */
    private function uselessDescription(string $arg1, bool $arg2): bool
    {
    }

    /**
     *
     */
    private function dockBlockIsEmpty(string $arg1, bool $arg2): bool
    {
    }
}
