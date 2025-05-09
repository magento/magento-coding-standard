<?php
/**
 * Copyright 2021 Adobe
 * All Rights Reserved.
 */
namespace Magento2\Sniffs\Less;

use PHP_CodeSniffer\Sniffs\Sniff;
use PHP_CodeSniffer\Files\File;

/**
 * Class ClassNamingSniff
 *
 * Ensure that class name responds to the following requirements:
 *
 * - names should be lowercase;
 * - start with a letter (except helper classes);
 * - words should be separated with dash '-';
 *
 * @link https://devdocs.magento.com/guides/v2.4/coding-standards/code-standard-less.html#standard-classes
 */
class ClassNamingSniff implements Sniff
{
    private const STRING_HELPER_CLASSES_PREFIX = '_';

    /**
     * A list of tokenizers this sniff supports.
     *
     * @var array
     */
    public $supportedTokenizers = [TokenizerSymbolsInterface::TOKENIZER_CSS];

    /**
     * @inheritdoc
     */
    public function register()
    {
        return [T_STRING_CONCAT];
    }

    /**
     * @inheritdoc
     */
    public function process(File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();

        if (T_WHITESPACE !== $tokens[$stackPtr - 1]['code']
            && !in_array(
                $tokens[$stackPtr - 1]['content'],
                [
                    TokenizerSymbolsInterface::INDENT_SPACES,
                    TokenizerSymbolsInterface::NEW_LINE,
                ]
            )
        ) {
            return;
        }

        $className = $tokens[$stackPtr + 1]['content'];
        if (preg_match_all('/[^a-z0-9\-_]/U', $className, $matches)) {
            $phpcsFile->addError(
                'CSS class name does not follow class naming requirements: %s',
                $stackPtr,
                'NotAllowedSymbol',
                [implode("", $matches[0])]
            );
        }

        if (strlen($className) > 1 && strpos($className, self::STRING_HELPER_CLASSES_PREFIX, 2) !== false
            && !str_starts_with($className, 'admin__')
        ) {
            $phpcsFile->addError(
                'CSS class names should be separated with "-" (dash) instead of "_" (underscore)',
                $stackPtr,
                'NotAllowedSymbol'
            );
        }
    }
}
