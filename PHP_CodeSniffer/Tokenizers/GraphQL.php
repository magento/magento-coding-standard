<?php
/**
 * Copyright © Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace PHP_CodeSniffer\Tokenizers;

use GraphQL\Language\Lexer;
use GraphQL\Language\Source;
use GraphQL\Language\Token;
use PHP_CodeSniffer\Config;
use PHP_CodeSniffer\Exceptions\TokenizerException;

/**
 * Implements a tokenizer for GraphQL files.
 *
 * @todo Reimplement using the official GraphQL implementation
 */
class GraphQL extends Tokenizer
{

    /**
     * Defines how GraphQL token types are mapped to PHP token types.
     *
     * @var array
     */
    private $tokenTypeMap = [
        Token::AMP          => null, //TODO
        Token::AT           => 'T_DOC_COMMENT_TAG',
        Token::BANG         => null, //TODO
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
        Token::FLOAT        => null, //TODO
        Token::INT          => null, //TODO
        Token::NAME         => 'T_STRING',
        Token::PAREN_L      => 'T_OPEN_PARENTHESIS',
        Token::PAREN_R      => 'T_CLOSE_PARENTHESIS',
        Token::PIPE         => null, //TODO
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
        //TODO Add further types
    ];

    /**
     * Constructor.
     *
     * @param string $content
     * @param Config $config
     * @param string $eolChar
     * @throws TokenizerException
     */
    public function __construct($content, Config $config, $eolChar = '\n')
    {
        //TODO We might want to delete this unless we need the constructor to work totally different

        //let parent do its job
        parent::__construct($content, $config, $eolChar);
    }

    /**
     * @inheritDoc
     */
    public function processAdditional()
    {
        //NOP: Does nothing intentionally
    }

    /**
     * {@inheritDoc}
     *
     * @throws TokenizerException
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
            //tokens content otherwise PHP_CodeSniffer will screw up line numbers
            if ($lexer->token->line !== $line && $kind !== Token::SOF) {
                $token['content'] .= $this->eolChar;
            }
            $tokens[] = $token;
            $tokens = array_merge(
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
