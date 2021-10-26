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
    private const WARNING_CODE_THIS_USAGE = 'ThisUsageObsolete';
    private const WARNING_CODE_PROTECTED_PRIVATE_BLOCK_ACCESS = 'ProtectedPrivateBlockAccess';

    private const OBSOLETE_REGEX = [
        'FoundJQueryUI' => [
            'pattern' => '/(["\'])jquery\/ui\1/',
            'message' => 'Please do not use "jquery/ui" library in templates. Use needed jquery ui widget instead'
        ],
        'FoundDataMageInit' => [
            'pattern' => '/data-mage-init=(?:\'|")(?!\s*{\s*"[^"]+")/',
            'message' => 'Please do not initialize JS component in php. Do it in template'
        ],
        'FoundXMagentoInit' => [
            'pattern' => '@x-magento-init.>(?!\s*+{\s*"[^"]+"\s*:\s*{\s*"[\w/-]+")@i',
            'message' => 'Please do not initialize JS component in php. Do it in template'
        ],
    ];
    
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
            $this->checkThisVariable($phpcsFile, $stackPtr, $tokens);
        }
        if ($tokens[$stackPtr]['code'] === T_INLINE_HTML || $tokens[$stackPtr]['code'] === T_HEREDOC) {
            $this->checkHtml($phpcsFile, $stackPtr);
            
            $file = $phpcsFile->getFilename();

            if (strpos($file, '/view/frontend/templates/') !== false
                || strpos($file, '/view/base/templates/') !== false
            ) {
                $this->checkHtmlSpecificFiles($phpcsFile, $stackPtr);
            }
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
     * Check access to members and methods of Block class through $this
     *
     * @param File $phpcsFile
     * @param int $stackPtr
     * @param array $tokens
     */
    private function checkThisVariable(File $phpcsFile, int $stackPtr, array $tokens): void
    {
        $varPos = $phpcsFile->findPrevious(T_VARIABLE, $stackPtr - 1);
        if ($tokens[$varPos]['content'] !== '$this') {
            return;
        }
        $stringPos = $phpcsFile->findNext(T_STRING, $stackPtr + 1);
        if (strpos($tokens[$stringPos]['content'], 'helper') === false) {
            $phpcsFile->addWarning(
                'Access to members and methods of Block class through $this is ' .
                'obsolete in phtml templates. Use only $block instead of $this.',
                $stringPos,
                self::WARNING_CODE_THIS_USAGE
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

    /**
     * Check of some obsoletes uses in specific files
     *
     * @param File $phpcsFile
     * @param int $stackPtr
     */
    private function checkHtmlSpecificFiles(File $phpcsFile, int $stackPtr): void
    {
        $content = $phpcsFile->getTokensAsString($stackPtr, 1);
        
        foreach (self::OBSOLETE_REGEX as $code => $data) {
            if (preg_match($data['pattern'], $content)) {
                $phpcsFile->addWarning(
                    $data['message'],
                    $stackPtr,
                    $code
                );
            }
        }
    }
}
