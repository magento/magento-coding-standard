<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types = 1);

namespace Magento2\Sniffs\Legacy;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

class PhtmlTemplateSniff implements Sniff
{
    private const WARNING_CODE_TEXT_JAVASCRIPT = 'TextJavascriptTypeFound';
    private const WARNING_CODE_PROTECTED_PRIVATE_BLOCK_ACCESS = 'ProtectedPrivateBlockAccess';
    
    /**
     * @inheritdoc
     */
    public function register(): array
    {
        return [
            T_OBJECT_OPERATOR,
            T_INLINE_HTML,
            T_HEREDOC
        ];
    }

    /**
     * @inheritdoc
     */
    public function process(File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();
        if ($tokens[$stackPtr]['code'] === T_OBJECT_OPERATOR) {
            $this->checkBlockVariable($phpcsFile, $stackPtr, $tokens);
        }
        if ($tokens[$stackPtr]['code'] === T_INLINE_HTML || $tokens[$stackPtr]['code'] === T_HEREDOC) {
            $this->checkHtml($phpcsFile, $stackPtr);
        }
    }
    
    /**
     * Check access to protected and private members of Block
     *
     * @param File $phpcsFile
     * @param int $stackPtr
     * @param array $tokens
     */
    private function checkBlockVariable(File $phpcsFile, int $stackPtr, array $tokens): void
    {
        $varPos = $phpcsFile->findPrevious(T_VARIABLE, $stackPtr - 1);
        if ($tokens[$varPos]['content'] !== '$block') {
            return;
        }
        $stringPos = $phpcsFile->findNext(T_STRING, $stackPtr + 1);
        if (strpos($tokens[$stringPos]['content'], '_') === 0) {
            $phpcsFile->addWarning(
                'Access to protected and private members of Block class is ' .
                'obsolete in phtml templates. Use only public members.',
                $stringPos,
                self::WARNING_CODE_PROTECTED_PRIVATE_BLOCK_ACCESS
            );
        }
    }

    /**
     * Check use of "text/javascript" type
     *
     * @param File $phpcsFile
     * @param int $stackPtr
     */
    private function checkHtml(File $phpcsFile, int $stackPtr): void
    {
        $content = $phpcsFile->getTokensAsString($stackPtr, 1);
        
        if (preg_match('/type="text\/javascript"/', $content)) {
            $phpcsFile->addWarning(
                'Please do not use "text/javascript" type attribute.',
                $stackPtr,
                self::WARNING_CODE_TEXT_JAVASCRIPT
            );
        }
    }
}
