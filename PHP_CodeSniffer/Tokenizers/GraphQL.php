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
class GraphQL extends Tokenizer
{

    /**
     * Defines how GraphQL token types are mapped to PHP token types.
     *
     * @var array
     */
    private $tokenTypeMap = [
        Token::AMP          => null, //TODO Should we map this to a specific type
        Token::AT           => 'T_DOC_COMMENT_TAG',
        Token::BANG         => null, //TODO Should we map this to a specific type
        Token::BLOCK_STRING => 'T_COMMENT',
        Token::BRACE_L      => 'T_OPEN_CURLY_BRACKET',
        Token::BRACE_R      => 'T_CLOSE_CURLY_BRACKET',
        Token::BRACKET_L    => 'T_OPEN_SQUARE_BRACKET',
        Token::BRACKET_R    => 'T_CLOSE_CURLY_BRACKET',
        Token::COLON        => 'T_COLON',
        Token::COMMENT      => 'T_COMMENT',
        Token::DOLLAR       => 'T_DOLLAR',
        Token::EOF          => 'T_CLOSE_TAG',
        Token::EQUALS       => 'T_EQUAL',
        Token::FLOAT        => null, //TODO Should we map this to a specific type
        Token::INT          => null, //TODO Should we map this to a specific type
        Token::NAME         => 'T_STRING',
        Token::PAREN_L      => 'T_OPEN_PARENTHESIS',
        Token::PAREN_R      => 'T_CLOSE_PARENTHESIS',
        Token::PIPE         => null, //TODO Should we map this to a specific type
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
        'extend'     => 'T_EXTENDS', //TODO This might not be the appropriate equivalent
        'interface'  => 'T_INTERFACE',
        'implements' => 'T_IMPLEMENTS',
        'type'       => 'T_CLASS',
        'union'      => 'T_CLASS',
        //TODO We may have to add further types
    ];

    /**
     * @inheritDoc
     */
    public function processAdditional()
    {
        $this->logVerbose('*** START ADDITIONAL GRAPHQL PROCESSING ***');

        $processingEntity = false;
        $numTokens        = count($this->tokens);
        $entityTypes      = [T_CLASS, T_INTERFACE];

        for ($i = 0; $i < $numTokens; ++$i) {
            $tokenCode = $this->tokens[$i]['code'];

            //have we found a new entity or its end?
            if (in_array($tokenCode, $entityTypes) && $this->tokens[$i]['content'] !== 'enum') {
                $processingEntity = true;
                continue;
            } elseif ($tokenCode === T_CLOSE_CURLY_BRACKET) {
                $processingEntity = false;
                continue;
            }

            //if we are processing an entity, are we currently seeing a field?
            if ($processingEntity && $this->isFieldToken($i)) {
                $this->tokens[$i]['code'] = T_VARIABLE;
                $this->tokens[$i]['type'] = 'T_VARIABLE';
                continue;
            }
        }

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
        $lexer  = new Lexer(
            new Source($string)
        );

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
        $nextToken = $this->tokens[$stackPointer + 1];

        //if next token is an opening parenthesis, we seek for the closing parenthesis
        if ($nextToken['code'] === T_OPEN_PARENTHESIS) {
            $nextPointer = $stackPointer + 1;
            $numTokens = count($this->tokens);

            for ($i=$nextPointer; $i<$numTokens; ++$i) {
                if ($this->tokens[$i]['code'] === T_CLOSE_PARENTHESIS) {
                    $nextToken = $this->tokens[$i + 1];
                    break;
                }
            }
        }

        //return whether next token is a colon
        return $nextToken['code'] === T_COLON;
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
}
