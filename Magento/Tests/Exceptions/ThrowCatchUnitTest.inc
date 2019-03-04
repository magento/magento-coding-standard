<?php

namespace Foo\Bar;

use ArithmeticError;
use BadFunctionCallException;
use Exception;
use LogicException;

abstract class Calculator
{
    abstract public function complexNotRelevantToCheck(array $data);
}

class CustomFooException extends Exception {}

class Foo extends Calculator
{

    /**
     * @var CallulationService
     */
    private $calculationService;

    public function __construct(CallulationService $calculationService)
    {
        $this->calculationService = $calculationService;
    }

    /**
     * @param array $data
     * @return array|mixed
     */
    private function vaildateFunction(array $data)
    {
        try {
            if (!isset($data['formData'])) {
                throw new CustomFooException('Bar is not set.');
            }
            return $data['formData'];
        } catch (CustomFooException $exception) {
            // Rule find: Exceptions MUST NOT handled in same function
            // handle $exception code
        }

        return [];
    }

    /**
     * @param array $data
     * @return int
     */
    public function complexNotRelevantToCheck(array $data)
    {
        $result = $this->vaildateFunction($data);
        $previous = 1;

        foreach ($result as $number) {
            if ($number === 0) {
                throw new LogicException('Cant not deviated by null');
            }

            $previous /= $number;

            // more complex code

            if ($previous === 0) {
                throw new ArithmeticError('Calculation error');
            }

            // more complex code

            $result = $this->calculationService->call($previous);

            if ($result === false) {
                throw new BadFunctionCallException('Cant not reach calculationService');
            }
        }

        return (int)$previous;
    }

    /**
     * @param array $data
     * @return int
     * @throws  BadFunctionCallException
     */
    public function complexDivisionFunction(array $data)
    {
        try {
            try {

                $result = $this->vaildateFunction($data);
                $previous = 1;

                foreach ($result as $number) {
                    if ($number === 0) {
                        throw new LogicException('Cant not deviated by null');
                    }

                    $previous /= $number;

                    // more complex code

                    if ($previous === 0) {
                        throw new ArithmeticError('Calculation error');
                    }

                    // more complex code

                    $result = $this->calculationService->call($previous);

                    if ($result === false) {
                        throw new BadFunctionCallException('Cant not reach calculationService');
                    }
                }

                return (int)$previous;

            } catch (LogicException $logicException) {
                // Rule find: Exceptions MUST NOT handled in same function
                // handle $exception code
            } catch (CustomFooException $exception) {
                // handle $exception code
            }
        } catch (ArithmeticError $arithmeticError) {
            // Rule find: Exceptions MUST NOT handled in same function
            // handle $exception code
        }

        return 0;
    }
}


// bad logic function in .phtml 

function formatFunction(array $data)
{
    try {
        if (!isset($data['formData'])) {
            throw new CustomFooException('Bar is not set.');
        }
        return $data['formData'];
    } catch (CustomFooException $exception) {
        // Rule find: Exceptions MUST NOT handled in same function
        // handle $exception code
    }

    return [];
}

$d = function ($data) {
    try {
        throw new CustomFooException('Bar is not set.');
    } catch (CustomFooException $exception) {
        // Rule find: Exceptions MUST NOT handled in same function
        // handle $exception code
    }
};
