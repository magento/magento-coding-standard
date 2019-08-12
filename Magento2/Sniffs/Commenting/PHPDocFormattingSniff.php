<?php
/**
 * Copyright © Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magento2\Sniffs\Commenting;

use Magento2\Sniffs\Legacy\MageEntitySniff;
use PHP_CodeSniffer\Sniffs\Sniff;
use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Util\Tokens;

/**
 * Detects PHPDoc formatting for constants.
 */
class PHPDocFormattingSniff implements Sniff
{
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
        $tokens = $phpcsFile->getTokens();

        $funcParamStart = $tokens[$stackPtr]['parenthesis_opener'];
        $funcParamCloser = $tokens[$stackPtr]['parenthesis_closer'];
        $funcBodyStart = $tokens[$stackPtr]['scope_opener'];

        // search for php7 return type declarations like  func() : string {}
        $funcReturnTypePos = $phpcsFile->findNext([T_STRING], $funcParamCloser, $funcBodyStart);
        $funcParamType = null;
        if ($funcReturnTypePos !== false) {
            $funcReturnType = $tokens[$funcReturnTypePos]['content'];
        }

        $funcParamTypeList = $this->getFunctionParameterWithType(
            array_slice(
                $tokens,
                $funcParamStart + 1,
                $funcParamCloser - $funcParamStart
            )
        );
        $paramType = null;

        if (isset($funcReturnType) && count($funcParamTypeList) !== 0) {
            // function use php7 return type declarations - no check required
            return;
        }

        // search for php doc block
        $find   = Tokens::$methodPrefixes;
        $find[] = T_WHITESPACE;
        $commentEnd = $phpcsFile->findPrevious($find, $stackPtr - 1, null, true);
        $commentStart = false;
        if($commentEnd !== false)
        {
            $commentStart = '';
        }
    }


    /**
     * Returns all parameter as list with there php 7 type declarations like
     * func(string $arg1, int $arg2)
     *
     * @param array $tokens
     * @return array
     */
    private function getFunctionParameterWithType(array $tokens)
    {
        $paramType = null;
        $functionParameterList = [];

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

            if ($type === T_VARIABLE && $paramType !== null) {
                $functionParameterList[] =
                    [
                        'content' => $content,
                        'type' => $paramType
                    ];
            }
        }

        return $functionParameterList;
    }
}
