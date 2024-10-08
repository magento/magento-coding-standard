<?php
/**
 * Copyright 2019 Adobe
 * All Rights Reserved.
 */
namespace Magento2\Sniffs\NamingConvention;

use PHP_CodeSniffer\Sniffs\Sniff;
use PHP_CodeSniffer\Files\File;

/**
 * Validates that class name is not reserved word.
 */
class ReservedWordsSniff implements Sniff
{
    /**
     * The following words cannot be used to name a class, interface or trait,
     * and they are also prohibited from being used in namespaces
     * http://php.net/manual/en/reserved.other-reserved-words.php
     *
     * @var string[]
     */
    protected $reservedWords = [
        'int' => '7',
        'float' => '7',
        'bool' => '7',
        'string' => '7',
        'true' => '7',
        'false' => '7',
        'null' => '7',
        'void' => '7.1',
        'iterable' => '7.1',
        'resource' => '7',
        'object' => '7',
        'mixed' => '7',
        'numeric' => '7',
        'match' => '8'
    ];

    private const CLASS_ERROR_CODE = 'ForbiddenAsClassName';
    private const NAMESPACE_ERROR_CODE = 'ForbiddenAsNameSpace';

    /**
     * @inheritdoc
     */
    public function register()
    {
        return [T_CLASS, T_INTERFACE, T_TRAIT, T_NAMESPACE];
    }

    /**
     * Check all namespace parts
     *
     * @param File $sourceFile
     * @param int $stackPtr
     * @return void
     */
    protected function validateNamespace(File $sourceFile, int $stackPtr)
    {
        $stackPtr += 2;
        $tokens = $sourceFile->getTokens();
        while ($stackPtr < $sourceFile->numTokens && $tokens[$stackPtr]['code'] !== T_SEMICOLON) {
            if ($tokens[$stackPtr]['code'] === T_WHITESPACE || $tokens[$stackPtr]['code'] === T_NS_SEPARATOR) {
                $stackPtr++; //skip "namespace" and whitespace
                continue;
            }
            $namespacePart = $tokens[$stackPtr]['content'];
            if (isset($this->reservedWords[strtolower($namespacePart)])) {
                $sourceFile->addError(
                    'Cannot use "%s" in namespace as it is reserved since PHP %s',
                    $stackPtr,
                    self::NAMESPACE_ERROR_CODE,
                    [$namespacePart, $this->reservedWords[strtolower($namespacePart)]]
                );
            }
            $stackPtr++;
        }
    }

    /**
     * Check class name not having reserved words
     *
     * @param File $sourceFile
     * @param int $stackPtr
     * @return void
     */
    protected function validateClass(File $sourceFile, int $stackPtr)
    {
        $tokens = $sourceFile->getTokens();
        $stackPtr += 2; //skip "class" and whitespace
        $className = strtolower($tokens[$stackPtr]['content']);
        if (isset($this->reservedWords[$className])) {
            $sourceFile->addError(
                'Cannot use "%s" as class name as it is reserved since PHP %s',
                $stackPtr,
                self::CLASS_ERROR_CODE,
                [$className, $this->reservedWords[$className]]
            );
        }
    }

    /**
     * @inheritdoc
     */
    public function process(File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();
        switch ($tokens[$stackPtr]['code']) {
            case T_CLASS:
            case T_INTERFACE:
            case T_TRAIT:
                $this->validateClass($phpcsFile, $stackPtr);
                break;
            case T_NAMESPACE:
                $this->validateNamespace($phpcsFile, $stackPtr);
                break;
        }
    }
}
