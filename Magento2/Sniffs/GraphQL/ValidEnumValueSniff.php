<?php
/**
 * Copyright 2019 Adobe
 * All Rights Reserved.
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

        foreach ($values as $pointer => $value) {

            if (!$this->isSnakeCase($value, true)) {
                $type  = 'Enum value';
                $error = '%s "%s" is not in SCREAMING_SNAKE_CASE format';
                $data  = [
                    $type,
                    $value,
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
     * Find the closing curly bracket pointer
     *
     * Seeks the next available token of type {@link T_CLOSE_CURLY_BRACKET}
     * in <var>$tokens</var> and returns its pointer.
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
     * Find the opening curly bracket pointer
     *
     * Seeks the next available token of type {@link T_OPEN_CURLY_BRACKET}
     * in <var>$tokens</var> and returns its pointer.
     *
     * @param int $startPointer
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
     * The returned array uses token pointers as keys and value names as values.
     *
     * @param int $startPointer
     * @param int $endPointer
     * @param array $tokens
     * @param string $eolChar
     * @return array<int,string>
     */
    private function getValues($startPointer, $endPointer, array $tokens, $eolChar)
    {
        $valueTokenPointer = null;
        $enumValue         = '';
        $values            = [];
        $skipTypes         = [T_COMMENT, T_WHITESPACE];

        for ($i = $startPointer + 1; $i < $endPointer; ++$i) {
            if (in_array($tokens[$i]['code'], $skipTypes)) {
                //NOP This is a token that we have to skip
                continue;
            }

            //add current tokens content to enum value if we have a string
            if ($tokens[$i]['code'] === T_STRING) {
                $enumValue .= $tokens[$i]['content'];

                //and store the pointer if we have not done it already
                if ($valueTokenPointer === null) {
                    $valueTokenPointer = $i;
                }
            }

            //consume directive if we have found one
            if ($tokens[$i]['code'] === T_DOC_COMMENT_TAG) {
                $i = $this->seekEndOfDirective($tokens, $i);
            }

            //if current token has a line break, we have found the end of the value definition
            if (strpos($tokens[$i]['content'], $eolChar) !== false) {
                $values[$valueTokenPointer] = trim($enumValue);
                $enumValue                  = '';
                $valueTokenPointer          = null;
            }
        }

        return $values;
    }
}
