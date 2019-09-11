<?php
/**
 * Copyright © Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento2\Sniffs\GraphQL;

use PHP_CodeSniffer\Files\File;

/**
 * Detects argument names that are not specified in <kbd>cameCase</kbd>.
 */
class ValidArgumentNameSniff extends AbstractGraphQLSniff
{
    /**
     * @inheritDoc
     */
    public function register()
    {
        return [T_OPEN_PARENTHESIS];
    }

    /**
     * @inheritDoc
     */
    public function process(File $phpcsFile, $stackPtr)
    {
        $tokens                  = $phpcsFile->getTokens();
        $closeParenthesisPointer = $this->getCloseParenthesisPointer($stackPtr, $tokens);

        //if we could not find the closing parenthesis pointer, we add a warning and terminate
        if ($closeParenthesisPointer === false) {
            $error = 'Possible parse error: Missing closing parenthesis for argument list in line %d';
            $data  = [
                $tokens[$stackPtr]['line'],
            ];
            $phpcsFile->addWarning($error, $stackPtr, 'UnclosedArgumentList', $data);
            return;
        }

        $arguments = $this->getArguments($stackPtr, $closeParenthesisPointer, $tokens);

        foreach ($arguments as $argument) {
            $pointer = $argument[0];
            $name    = $argument[1];

            if (!$this->isCamelCase($name)) {
                $type  = 'Argument';
                $error = '%s name "%s" is not in CamelCase format';
                $data  = [
                    $type,
                    $name,
                ];

                $phpcsFile->addError($error, $pointer, 'NotCamelCase', $data);
                $phpcsFile->recordMetric($pointer, 'CamelCase argument name', 'no');
            } else {
                $phpcsFile->recordMetric($pointer, 'CamelCase argument name', 'yes');
            }
        }

        //return stack pointer of closing parenthesis
        return $closeParenthesisPointer;
    }

    /**
     * Finds all argument names contained in <var>$tokens</var> range <var>$startPointer</var> and
     * <var>$endPointer</var>.
     *
     * @param int $startPointer
     * @param int $endPointer
     * @param array $tokens
     * @return array[]
     */
    private function getArguments($startPointer, $endPointer, array $tokens)
    {
        $argumentTokenPointer = null;
        $argument             = '';
        $names                = [];
        $skipTypes            = [T_COMMENT, T_WHITESPACE];

        for ($i = $startPointer + 1; $i < $endPointer; ++$i) {
            //skip comment tokens
            if (in_array($tokens[$i]['code'], $skipTypes)) {
                continue;
            }
            $argument .= $tokens[$i]['content'];

            if ($argumentTokenPointer === null) {
                $argumentTokenPointer = $i;
            }

            if (preg_match('/^.+:.+$/', $argument)) {
                list($name, $type) = explode(':', $argument);
                $names[]              = [$argumentTokenPointer, $name];
                $argument             = '';
                $argumentTokenPointer = null;
            }
        }

        return $names;
    }

    /**
     * Seeks the next available token of type {@link T_CLOSE_PARENTHESIS} in <var>$tokens</var> and returns its pointer.
     *
     * @param int $stackPointer
     * @param array $tokens
     * @return bool|int
     */
    private function getCloseParenthesisPointer($stackPointer, array $tokens)
    {
        $numTokens = count($tokens);

        for ($i = $stackPointer + 1; $i < $numTokens; ++$i) {
            if ($tokens[$i]['code'] === T_CLOSE_PARENTHESIS) {
                return $i;
            }
        }

        //if we came here we could not find the closing parenthesis
        return false;
    }
}
