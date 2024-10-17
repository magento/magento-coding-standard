<?php
/**
 * Copyright 2019 Adobe
 * All Rights Reserved.
 */
namespace Magento2\Sniffs\PHP;

use PHP_CodeSniffer\Sniffs\Sniff;
use PHP_CodeSniffer\Files\File;

/**
 * Custom phpcs sniff to detect usages of literal class and interface names.
 */
class LiteralNamespacesSniff implements Sniff
{
    /**
     * @var string
     */
    private $literalNamespacePattern = '/^[\\\]{0,2}[A-Z][A-Za-z]+([\\\]{1,2}[A-Z][A-Za-z]+){2,}(?!\\\+)$/';

    /**
     * @var array
     */
    private $classNames = [];

    /**
     * @inheritdoc
     */
    public function register()
    {
        return [
            T_CONSTANT_ENCAPSED_STRING,
            T_DOUBLE_QUOTED_STRING,
        ];
    }

    /**
     * @inheritdoc
     */
    public function process(File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();
        if ($phpcsFile->findPrevious(T_STRING_CONCAT, $stackPtr, $stackPtr - 3) ||
            $phpcsFile->findNext(T_STRING_CONCAT, $stackPtr, $stackPtr + 3)
        ) {
            return;
        }

        $content = trim($tokens[$stackPtr]['content'], "\"'");
        // replace double slashes from class name for avoiding problems with class autoload
        if (strpos($content, '\\') !== false) {
            $content = preg_replace('|\\\{2,}|', '\\', $content);
        }

        if (preg_match($this->literalNamespacePattern, $content) === 1) {
            $phpcsFile->addWarning(
                "Use ::class notation instead.",
                $stackPtr,
                'LiteralClassUsage'
            );
        }
    }
}
