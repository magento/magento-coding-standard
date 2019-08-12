<?php
/**
 * Copyright © Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magento2\Sniffs\Commenting;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;
use PHP_CodeSniffer\Util\Tokens;

/**
 * Detects PHPDoc formatting.
 */
class FunctionsPHPDocFormattingSniff implements Sniff
{
    /**
     * Warning violation code.
     *
     * @var string
     */
    protected $warningCode = 'FunctionsPHPDocFormattingSniff';
    /**
     * @var FunctionPHPDocBlock
     */
    private $functionPHPDocBlock;

    public function __construct()
    {
        $this->functionPHPDocBlock = new FunctionPHPDocBlock();
    }

    /**
     * @inheritDoc
     */
    public function register()
    {
        return [T_FUNCTION];
    }

    /**
     * @inheritDoc
     */
    public function process(File $phpcsFile, $stackPtr)
    {
        $funcReturnType = $this->anaylsePhp7ReturnDeclaration($phpcsFile, $stackPtr);
        $funcParamTypeList = $this->analysePhp7ParamDeclarations($phpcsFile, $stackPtr);
        $phpDocTokens = $this->getPhpDocTokens($phpcsFile, $stackPtr);

        if ($phpDocTokens === false && $funcReturnType === false && count($funcParamTypeList['missing_type'] !== 0)) {
            $phpcsFile->addWarning('Use php 7 type declarations or an php doc block', $stackPtr, $this->warningCode);

            // @fixme find also __constuct that dont have return type
            return;
        }

        if ($phpDocTokens === false) {
            // @todo impelement checks
            return;
        }

        $parsePhpDocTokens = $this->functionPHPDocBlock->execute(
            $phpcsFile->getTokens(),
            $phpDocTokens[0],
            $phpDocTokens[1]
        );

        $warning = $parsePhpDocTokens['warning'];

        if ($warning !== false) {
            $phpcsFile->addWarning($warning[0], $warning[1], $this->warningCode);
            return;
        }


        // @todo impelement checks
    }

    /**
     * Search for php7 return type declarations like func() : string {}
     * @param File $phpcsFile
     * @param $stackPtr
     * @return bool|string
     */
    private function anaylsePhp7ReturnDeclaration(File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();
        $funcParamCloser = $tokens[$stackPtr]['parenthesis_closer'];
        $funcReturnTypePos = $phpcsFile->findNext([T_STRING], $funcParamCloser, $tokens[$stackPtr]['scope_opener']);

        $funcReturnType = false;
        if ($funcReturnTypePos !== false) {
            $funcReturnType = $tokens[$funcReturnTypePos]['content'];
        }

        return $funcReturnType;
    }

    /**
     * Search for php7 return type declarations like func(bool $arg1) {}
     * @param File $phpcsFile
     * @param $stackPtr
     * @return array
     */
    private function analysePhp7ParamDeclarations(File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();

        $funcParamStart = $tokens[$stackPtr]['parenthesis_opener'];
        $funcParamCloser = $tokens[$stackPtr]['parenthesis_closer'];

        $functionParameterTokens = array_slice(
            $tokens,
            $funcParamStart + 1,
            $funcParamCloser - ($funcParamStart + 1)
        );

        return $this->parseFunctionTokens($functionParameterTokens);
    }

    /**
     * Returns all parameter as list with there php 7 type declarations like
     * func(string $arg1, int $arg2)
     *
     * @param array $tokens
     * @return array
     */
    private function parseFunctionTokens(array $tokens)
    {
        $paramType = null;
        $functionParameterList = [
            'missing_type' => [],
            'has_type' => [],
        ];

        foreach ($tokens as $token) {
            $type = $token['code'];
            $content = $token['content'];

            if ($type === T_COMMA) {
                $paramType = null;
                continue;
            }

            if ($type === T_STRING) {
                $paramType = $content;
                continue;
            }
            if ($content === ' ') {
                continue;
            }

            $key = $paramType !== null ? 'has_type' : 'missing_type';
            $functionParameterList[$key][] =
                [
                    'content' => $content,
                    'type' => $paramType,
                ];
        }

        return $functionParameterList;
    }

    /**
     * Parse the doc block for type and return declarations
     * @param File $phpcsFile
     * @param $stackPtr
     * @return array|bool
     */
    private function getPhpDocTokens(File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();

        // search for php doc block
        $find = Tokens::$methodPrefixes;
        $find[] = T_WHITESPACE;

        $commentEnd = $phpcsFile->findPrevious($find, $stackPtr - 1, null, true);
        $commentStart = false;

        if ($commentEnd !== false) {
            $endToken = $tokens[$commentEnd];
            if ($endToken['code'] === T_DOC_COMMENT_CLOSE_TAG) {
                $commentStart = $tokens[$commentEnd]['comment_opener'];
            }
        }

        if ($commentStart === false) {
            return false;
        }

        return [$commentStart + 1, $commentEnd - 1];
    }
}
