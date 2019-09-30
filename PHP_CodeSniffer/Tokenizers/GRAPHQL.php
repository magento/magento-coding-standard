<?php
/**
 * Copyright © Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace PHP_CodeSniffer\Tokenizers;

use GraphQL\Language\Lexer;
use GraphQL\Language\Source;
use GraphQL\Language\Token;

/**
 * Implements a tokenizer for GraphQL files.
 */
class GRAPHQL extends Tokenizer
{

    /**
     * Defines how GraphQL token types are mapped to PHP token types.
     *
     * This is a complete list of all token types supported by <kbd>webonyx/graphql-php</var>. <knd>null</kbd> values
     * are automatically mapped to <kbd>T_STRING</kbd> but are noted as <kbd>null</kbd> in this list to improve
     * maintenance at a glance.
     *
     * @var array
     */
    private $tokenTypeMap = [
        Token::AT           => 'T_DOC_COMMENT_TAG',
        Token::BANG         => 'T_BOOLEAN_NOT',
        Token::BLOCK_STRING => 'T_COMMENT',
        Token::BRACE_L      => 'T_OPEN_CURLY_BRACKET',
        Token::BRACE_R      => 'T_CLOSE_CURLY_BRACKET',
        Token::BRACKET_L    => 'T_OPEN_SQUARE_BRACKET',
        Token::BRACKET_R    => 'T_CLOSE_SQUARE_BRACKET',
        Token::COLON        => 'T_COLON',
        Token::COMMENT      => 'T_COMMENT',
        Token::DOLLAR       => 'T_DOLLAR',
        Token::EOF          => 'T_CLOSE_TAG',
        Token::EQUALS       => 'T_EQUAL',
        Token::FLOAT        => null,
        Token::INT          => null,
        Token::NAME         => 'T_STRING',
        Token::PAREN_L      => 'T_OPEN_PARENTHESIS',
        Token::PAREN_R      => 'T_CLOSE_PARENTHESIS',
        Token::PIPE         => null,
        Token::SPREAD       => 'T_ELLIPSIS',
        Token::SOF          => 'T_OPEN_TAG',
        Token::STRING       => 'T_STRING',
    ];

    /**
     * Defines how special keywords are mapped to PHP token types
     *
     * @var array
     */
    private $keywordTokenTypeMap = [
        'enum'       => 'T_CLASS',
        'extend'     => 'T_EXTENDS',
        'interface'  => 'T_INTERFACE',
        'implements' => 'T_IMPLEMENTS',
        'type'       => 'T_CLASS',
        'union'      => 'T_CLASS',
        'query'      => 'T_FUNCTION',
        'mutation'   => 'T_FUNCTION',
    ];

    /**
     * @inheritDoc
     */
    public function processAdditional()
    {
        $this->logVerbose('*** START ADDITIONAL GRAPHQL PROCESSING ***');

        $this->fixErroneousKeywordTokens();
        $this->processFields();

        $this->logVerbose('*** END ADDITIONAL GRAPHQL PROCESSING ***');
    }

    /**
     * @inheritDoc
     */
    protected function tokenize($string)
    {
        $this->logVerbose('*** START GRAPHQL TOKENIZING ***');

        $string = str_replace($this->eolChar, "\n", $string);
        $tokens = [];
        $source = new Source($string);
        $lexer  = new Lexer($source);

        do {
            $kind  = $lexer->token->kind;
            $value = $lexer->token->value ?: '';

            //if we have encountered a keyword, we convert it
            //otherwise we translate the token or default it to T_STRING
            if ($kind === Token::NAME && isset($this->keywordTokenTypeMap[$value])) {
                $tokenType = $this->keywordTokenTypeMap[$value];
            } elseif (isset($this->tokenTypeMap[$kind])) {
                $tokenType = $this->tokenTypeMap[$kind];
            } else {
                $tokenType = 'T_STRING';
            }

            //some GraphQL tokens need special handling
            switch ($kind) {
                case Token::AT:
                case Token::BRACE_L:
                case Token::BRACE_R:
                case Token::PAREN_L:
                case Token::PAREN_R:
                case Token::COLON:
                case Token::BRACKET_L:
                case Token::BRACKET_R:
                case Token::BANG:
                    $value = $kind;
                    break;
                default:
                    //NOP
            }

            //finally we create the PHP token
            $token = [
                'code'    => constant($tokenType),
                'type'    => $tokenType,
                'content' => $value,
            ];
            $line  = $lexer->token->line;

            $lexer->advance();

            //if line has changed (and we're not on start of file) we have to append at least one line break to current
            //token's content otherwise PHP_CodeSniffer will screw up line numbers
            if ($lexer->token->line !== $line && $kind !== Token::SOF) {
                $token['content'] .= $this->eolChar;
            }
            $tokens[] = $token;
            $tokens   = array_merge(
                $tokens,
                $this->getNewLineTokens($line, $lexer->token->line)
            );
        } while ($lexer->token->kind !== Token::EOF);

        $this->logVerbose('*** END GRAPHQL TOKENIZING ***');
        return $tokens;
    }

    /**
     * Fixes that keywords may be used as field, argument etc. names and could thus have been marked as special tokens
     * while tokenizing.
     */
    private function fixErroneousKeywordTokens()
    {
        $processingCodeBlock = false;
        $numTokens           = count($this->tokens);

        for ($i = 0; $i < $numTokens; ++$i) {
            $tokenCode    = $this->tokens[$i]['code'];
            $tokenContent = $this->tokens[$i]['content'];

            switch (true) {
                case $tokenCode === T_OPEN_CURLY_BRACKET:
                    //we have hit the beginning of a code block
                    $processingCodeBlock = true;
                    break;
                case $tokenCode === T_CLOSE_CURLY_BRACKET:
                    //we have hit the end of a code block
                    $processingCodeBlock = false;
                    break;
                case $processingCodeBlock
                     && $tokenCode !== T_STRING
                     && isset($this->keywordTokenTypeMap[$tokenContent]):
                    //we have hit a keyword within a code block that is of wrong token type
                    $this->tokens[$i]['code'] = T_STRING;
                    $this->tokens[$i]['type'] = 'T_STRING';
                    break;
                default:
                    //NOP All operations have already been executed
            }
        }
    }

    /**
     * Returns tokens of empty new lines for the range <var>$lineStart</var> to <var>$lineEnd</var>
     *
     * @param int $lineStart
     * @param int $lineEnd
     * @return array
     */
    private function getNewLineTokens($lineStart, $lineEnd)
    {
        $amount = ($lineEnd - $lineStart) - 1;
        $tokens = [];

        for ($i = 0; $i < $amount; ++$i) {
            $tokens[] = [
                'code'    => T_WHITESPACE,
                'type'    => 'T_WHITESPACE',
                'content' => $this->eolChar,
            ];
        }

        return $tokens;
    }

    /**
     * Returns whether the token under <var>$stackPointer</var> is a field.
     *
     * We consider a token to be a field if:
     * <ul>
     *   <li>its direct successor is of type {@link T_COLON}</li>
     *   <li>it has a list of arguments followed by a {@link T_COLON}</li>
     * </ul>
     *
     * @param int $stackPointer
     * @return bool
     */
    private function isFieldToken($stackPointer)
    {
        //bail out if current token is nested in a parenthesis, since fields cannot be contained in parenthesises
        if (isset($this->tokens[$stackPointer]['nested_parenthesis'])) {
            return false;
        }

        $nextToken = $this->tokens[$stackPointer + 1];

        //if next token is an opening parenthesis, we advance to the token after the closing parenthesis
        if ($nextToken['code'] === T_OPEN_PARENTHESIS) {
            $nextPointer = $nextToken['parenthesis_closer'] + 1;
            $nextToken   = $this->tokens[$nextPointer];
        }

        //return whether current token is a string and next token is a colon
        return $this->tokens[$stackPointer]['code'] === T_STRING && $nextToken['code'] === T_COLON;
    }

    /**
     * Logs <var>$message</var> if {@link PHP_CODESNIFFER_VERBOSITY} is greater than <var>$level</var>.
     *
     * @param string $message
     * @param int $level
     */
    private function logVerbose($message, $level = 1)
    {
        if (PHP_CODESNIFFER_VERBOSITY > $level) {
            printf("\t%s" . PHP_EOL, $message);
        }
    }

    /**
     * Processes field tokens, setting their type to {@link T_VARIABLE}.
     */
    private function processFields()
    {
        $processingEntity = false;
        $numTokens        = count($this->tokens);
        $entityTypes      = [T_CLASS, T_INTERFACE];
        $skipTypes        = [T_COMMENT, T_WHITESPACE];

        for ($i = 0; $i < $numTokens; ++$i) {
            $tokenCode = $this->tokens[$i]['code'];

            //process current token
            switch (true) {
                case in_array($tokenCode, $skipTypes):
                    //we have hit a token that needs to be skipped -> NOP
                    break;
                case in_array($tokenCode, $entityTypes) && $this->tokens[$i]['content'] !== 'enum':
                    //we have hit an entity declaration
                    $processingEntity = true;
                    break;
                case $tokenCode === T_CLOSE_CURLY_BRACKET:
                    //we have hit the end of an entity declaration
                    $processingEntity = false;
                    break;
                case $processingEntity && $this->isFieldToken($i):
                    //we have hit a field
                    $this->tokens[$i]['code'] = T_VARIABLE;
                    $this->tokens[$i]['type'] = 'T_VARIABLE';
                    break;
                default:
                    //NOP All operations have already been executed
            }
        }
    }
}
