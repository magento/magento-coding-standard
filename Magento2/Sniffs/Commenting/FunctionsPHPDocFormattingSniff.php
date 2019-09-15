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
        $this->functionPHPDocBlock = new FunctionPHPDocBlockParser();
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
        $funcReturnType = $this->analysePhp7ReturnDeclaration($phpcsFile, $stackPtr);
        $funcParamTypeList = $this->analysePhp7ParamDeclarations($phpcsFile, $stackPtr);
        $phpDocTokens = $this->getPhpDocTokens($phpcsFile, $stackPtr);
        $hasPhp7TypeDeclarations = $funcReturnType !== false && count($funcParamTypeList['missing_type']) === 0;

        if ($phpDocTokens === false && $hasPhp7TypeDeclarations === true) {
            // NO check it use all php 7 type declarations and no php doc docblock
            return;
        }

        if ($phpDocTokens === false && $hasPhp7TypeDeclarations === false) {
            $phpcsFile->addWarning('Use php 7 type declarations or an php doc block', $stackPtr, $this->warningCode);

            return;
        }
        $tokens = $phpcsFile->getTokens();
        $phpDocTokensList = $this->functionPHPDocBlock->execute(
            $tokens,
            $phpDocTokens[0],
            $phpDocTokens[1]
        );

        if ($phpDocTokensList['is_empty']) {
            $phpcsFile->addWarning('Empty Docblock SHOULD NOT be used', $stackPtr, $this->warningCode);
            return;
        }

        $description = $phpDocTokensList['description'];

        if ($description !== false) {
            $functionNameToken = $phpcsFile->findNext(T_STRING, $stackPtr, $tokens[$stackPtr]['parenthesis_opener']);
            $functionName = str_replace(['_', ' ', '.', ','], '', strtolower($tokens[$functionNameToken]['content']));
            $description = str_replace(['_', ' ', '.', ','], '', strtolower($description));

            if ($functionName === $description) {
                $phpcsFile->addWarning(
                    sprintf(
                        '%s description should contain additional information beyond the name already supplies.',
                        ucfirst($phpDocTokensList['description'])
                    ),
                    $stackPtr,
                    'InvalidDescription'
                );
            }
        }

        if (array_key_exists('@inheritdoc', array_flip($phpDocTokensList['tags']))) {
            $phpcsFile->addWarning('The @inheritdoc tag SHOULD NOT be used', $stackPtr, $this->warningCode);
            return;
        }

        if (count($phpDocTokensList['parameters']) > 0) {
          $this->comparePhp7WithDocBlock(
                $funcParamTypeList,
                $phpDocTokensList['parameters'],
                $phpcsFile,
                $stackPtr
            );
        }


    }

    /**
     * Search for php7 return type declarations like func() : string {}
     * @param File $phpcsFile
     * @param $stackPtr
     * @return bool|string
     */
    private function analysePhp7ReturnDeclaration(File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();
        $functionNameToken = $phpcsFile->findNext(T_STRING, $stackPtr, $tokens[$stackPtr]['parenthesis_opener']);
        if (strpos($tokens[$functionNameToken]['content'], '__construct') === 0) {
            // magic functions start with __construct dont have php7 return type
            return 'void';
        }

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
            'count' => 0,
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

            $functionParameterList['count']++;
            $key = $paramType !== null ? 'has_type' : 'missing_type';
            $functionParameterList[$key][$content] =
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

    private function comparePhp7WithDocBlock(array $php7Tokens, array $docBlockTokens, File $phpcsFile, $stackPtr)
    {

        $parsedDocToken = [];
        foreach ($docBlockTokens as $token) {
            $parameterName = $token['content'];
            if (isset($parsedDocToken[$parameterName])) {
                $phpcsFile->addWarning(
                    sprintf('Parameter %s is definitely multiple', $parameterName),
                    $stackPtr,
                    $this->warningCode
                );
               return;
            }

            $parsedDocToken[$parameterName] = $token['type'];
        }

        if (count($parsedDocToken) > $php7Tokens['count']) {
            $phpcsFile->addWarning(
                'More documented parameter than real function parameter',
                $stackPtr,
                $this->warningCode
            );
            return;
        }

        $hasMissingTypes = count($php7Tokens['missing_type']) > 0;
        if ($hasMissingTypes === false) {
            return;
        }

        $php7ParamKey =  array_keys($php7Tokens['missing_type']);
        $parsedDocTokenKeys = array_keys($parsedDocToken);
        if ($php7ParamKey !== $parsedDocTokenKeys) {
            $phpcsFile->addWarning(
                'Documented parameter and real function parameter dont match',
                $stackPtr,
                $this->warningCode
            );
        }

        foreach ($php7ParamKey as $parameter) {
            if (!isset($parsedDocToken[$parameter]) || $parsedDocToken[$parameter] === false) {
                $phpcsFile->addWarning(
                    sprintf('Type for parameter %s is missing', $parameter),
                    $stackPtr,
                    $this->warningCode
                );
            }
        }
    }
}
