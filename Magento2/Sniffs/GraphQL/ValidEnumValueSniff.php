<?php
/**
 * Copyright © Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento2\Sniffs\GraphQL;

use PHP_CodeSniffer\Files\File;

/**
 * Detects enum values that are not specified in <kbd>SCREAMING_SNAKE_CASE</kbd>.
 */
class ValidEnumValueSniff extends AbstractGraphQLSniff
{

    /**
     * @inheritDoc
     */
    public function register()
    {
        return [T_CLASS];
    }

    /**
     * @inheritDoc
     */
    public function process(File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();

        //bail out if we're not inspecting an enum
        if ($tokens[$stackPtr]['content'] !== 'enum') {
            return;
        }

        $openingCurlyPointer = $this->getOpeningCurlyBracketPointer($stackPtr, $tokens);
        $closingCurlyPointer = $this->getClosingCurlyBracketPointer($stackPtr, $tokens);

        //if we could not find the closing curly bracket pointer, we add a warning and terminate
        if ($openingCurlyPointer === false || $closingCurlyPointer === false) {
            $error = 'Possible parse error: %s missing opening or closing brace';
            $data  = [$tokens[$stackPtr]['content']];
            $phpcsFile->addWarning($error, $stackPtr, 'MissingBrace', $data);
            return;
        }

        $values = $this->getValues($openingCurlyPointer, $closingCurlyPointer, $tokens, $phpcsFile->eolChar);

        foreach ($values as $value) {
            $pointer = $value[0];
            $name    = $value[1];

            if (!$this->isSnakeCase($name, true)) {
                $type  = 'Enum value';
                $error = '%s "%s" is not in SCREAMING_SNAKE_CASE format';
                $data  = [
                    $type,
                    $name,
                ];

                $phpcsFile->addError($error, $pointer, 'NotScreamingSnakeCase', $data);
                $phpcsFile->recordMetric($pointer, 'SCREAMING_SNAKE_CASE enum value', 'no');
            } else {
                $phpcsFile->recordMetric($pointer, 'SCREAMING_SNAKE_CASE enum value', 'yes');
            }
        }

        return $closingCurlyPointer;
    }

    /**
     * Seeks the next available token of type {@link T_CLOSE_CURLY_BRACKET} in <var>$tokens</var> and returns its
     * pointer.
     *
     * @param int $startPointer
     * @param array $tokens
     * @return bool|int
     */
    private function getClosingCurlyBracketPointer($startPointer, array $tokens)
    {
        return $this->seekToken(T_CLOSE_CURLY_BRACKET, $tokens, $startPointer);
    }

    /**
     * Seeks the next available token of type {@link T_OPEN_CURLY_BRACKET} in <var>$tokens</var> and returns its
     * pointer.
     *
     * @param $startPointer
     * @param array $tokens
     * @return bool|int
     */
    private function getOpeningCurlyBracketPointer($startPointer, array $tokens)
    {
        return $this->seekToken(T_OPEN_CURLY_BRACKET, $tokens, $startPointer);
    }

    /**
     * Finds all enum values contained in <var>$tokens</var> in range <var>$startPointer</var> to
     * <var>$endPointer</var>.
     *
     * @param int $startPointer
     * @param int $endPointer
     * @param array $tokens
     * @param string $eolChar
     * @return array[]
     */
    private function getValues($startPointer, $endPointer, array $tokens, $eolChar)
    {
        $valueTokenPointer = null;
        $enumValue         = '';
        $values            = [];
        $skipTypes         = [T_COMMENT, T_WHITESPACE];

        for ($i = $startPointer + 1; $i < $endPointer; ++$i) {
            //skip some tokens
            if (in_array($tokens[$i]['code'], $skipTypes)) {
                continue;
            }
            $enumValue .= $tokens[$i]['content'];

            if ($valueTokenPointer === null) {
                $valueTokenPointer = $i;
            }

            if (strpos($enumValue, $eolChar) !== false) {
                $values[]          = [$valueTokenPointer, rtrim($enumValue, $eolChar)];
                $enumValue         = '';
                $valueTokenPointer = null;
            }
        }

        return $values;
    }
}
