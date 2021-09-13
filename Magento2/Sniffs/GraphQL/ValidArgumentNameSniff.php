<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magento2\Sniffs\GraphQL;

use GraphQL\Error\SyntaxError;
use GraphQL\Language\AST\DocumentNode;
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
        return [T_VARIABLE];
    }

    /**
     * @inheritDoc
     */
    public function process(File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();

        //get the pointer to the argument list opener or bail out if none was found
        //since then the field does not have arguments
        $openArgumentListPointer = $this->getArgumentListOpenPointer($stackPtr, $tokens);
        if ($openArgumentListPointer === false) {
            return;
        }

        //get the pointer to the argument list closer or add a warning and terminate as we have an unbalanced file
        $closeArgumentListPointer = $this->getArgumentListClosePointer($openArgumentListPointer, $tokens);
        if ($closeArgumentListPointer === false) {
            $error = 'Possible parse error: Missing closing parenthesis for argument list in line %d';
            $data  = [
                $tokens[$stackPtr]['line'],
            ];
            $phpcsFile->addWarning($error, $stackPtr, 'UnclosedArgumentList', $data);
            return;
        }

        $arguments = $this->getArguments($openArgumentListPointer, $closeArgumentListPointer, $tokens);

        foreach ($arguments as $pointer => $argument) {
            if (!$this->isCamelCase($argument)) {
                $type  = 'Argument';
                $error = '%s name "%s" is not in CamelCase format';
                $data  = [
                    $type,
                    $argument,
                ];

                $phpcsFile->addError($error, $pointer, 'NotCamelCase', $data);
                $phpcsFile->recordMetric($pointer, 'CamelCase argument name', 'no');
            } else {
                $phpcsFile->recordMetric($pointer, 'CamelCase argument name', 'yes');
            }
        }

        //return stack pointer of closing parenthesis
        return $closeArgumentListPointer;
    }

    /**
     * Seeks the last token of an argument definition and returns its pointer.
     *
     * Arguments are defined as follows:
     * <pre>
     *   {ArgumentName}: {ArgumentType}[ = {DefaultValue}][{Directive}]*
     * </pre>
     *
     * @param int $argumentDefinitionStartPointer
     * @param array $tokens
     * @return int
     */
    private function getArgumentDefinitionEndPointer($argumentDefinitionStartPointer, array $tokens)
    {
        $endPointer = $this->seekToken(T_COLON, $tokens, $argumentDefinitionStartPointer);

        //the colon is always followed by the type, which we can consume. it could be a list type though, thus we check
        if ($tokens[$endPointer + 1]['code'] === T_OPEN_SQUARE_BRACKET) {
            //consume everything up to closing bracket
            $endPointer = $tokens[$endPointer + 1]['bracket_closer'];
        } else {
            //consume everything up to type
            ++$endPointer;
        }

        //the type may be non null, meaning that it is followed by an exclamation mark, which we consume
        if ($tokens[$endPointer + 1]['code'] === T_BOOLEAN_NOT) {
            ++$endPointer;
        }

        //if argument has a default value, we advance to the default definition end
        if ($tokens[$endPointer + 1]['code'] === T_EQUAL) {
            $endPointer += 2;
        }

        //while next token starts a directive, we advance to the end of the directive
        while ($tokens[$endPointer + 1]['code'] === T_DOC_COMMENT_TAG) {
            $endPointer = $this->seekEndOfDirective($tokens, $endPointer + 1);
        }

        return $endPointer;
    }

    /**
     * Returns the closing parenthesis for the token found at <var>$openParenthesisPointer</var> in <var>$tokens</var>.
     *
     * @param int $openParenthesisPointer
     * @param array $tokens
     * @return bool|int
     */
    private function getArgumentListClosePointer($openParenthesisPointer, array $tokens)
    {
        $openParenthesisToken = $tokens[$openParenthesisPointer];
        return $openParenthesisToken['parenthesis_closer'];
    }

    /**
     * Find the argument list open pointer
     *
     * Seeks the next available {@link T_OPEN_PARENTHESIS} token
     * that comes directly after <var>$stackPointer</var> token.
     *
     * @param int $stackPointer
     * @param array $tokens
     * @return bool|int
     */
    private function getArgumentListOpenPointer($stackPointer, array $tokens)
    {
        //get next open parenthesis pointer or bail out if none was found
        $openParenthesisPointer = $this->seekToken(T_OPEN_PARENTHESIS, $tokens, $stackPointer);
        if ($openParenthesisPointer === false) {
            return false;
        }

        //bail out if open parenthesis does not directly come after current stack pointer
        if ($openParenthesisPointer !== $stackPointer + 1) {
            return false;
        }

        //we have found the appropriate opening parenthesis
        return $openParenthesisPointer;
    }

    /**
     * Finds all argument names contained in <var>$tokens</var> in range <var>$startPointer</var> to
     * <var>$endPointer</var>.
     *
     * The returned array uses token pointers as keys and argument names as values.
     *
     * @param int $startPointer
     * @param int $endPointer
     * @param array $tokens
     * @return array<int, string>
     */
    private function getArguments($startPointer, $endPointer, array $tokens)
    {
        $argumentTokenPointer = null;
        $argument             = '';
        $names                = [];
        $skipTypes            = [T_COMMENT, T_WHITESPACE];

        for ($i = $startPointer + 1; $i < $endPointer; ++$i) {
            $tokenCode = $tokens[$i]['code'];

            switch (true) {
                case in_array($tokenCode, $skipTypes):
                    //NOP This is a token that we have to skip
                    break;
                case $tokenCode === T_COLON:
                    //we have reached the end of the argument name, thus we store its pointer and value
                    $names[$argumentTokenPointer] = $argument;

                    //advance to end of argument definition
                    $i = $this->getArgumentDefinitionEndPointer($argumentTokenPointer, $tokens);

                    //and reset temporary variables
                    $argument             = '';
                    $argumentTokenPointer = null;
                    break;
                default:
                    //this seems to be part of the argument name
                    $argument .= $tokens[$i]['content'];

                    if ($argumentTokenPointer === null) {
                        $argumentTokenPointer = $i;
                    }
            }
        }

        return $names;
    }
}
