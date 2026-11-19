<?php
/**
 * Copyright 2021 Adobe
 * All Rights Reserved.
 */
declare(strict_types = 1);

namespace Magento2\Sniffs\Legacy;

use PHP_CodeSniffer\Sniffs\Sniff;
use PHP_CodeSniffer\Files\File;

/**
 * Tests to find usage of restricted code
 */
class RestrictedCodeSniff implements Sniff
{
    private const ERROR_MESSAGE = "Class '%s' is restricted in %s. Suggested replacement: %s";

    /**
     * List of fixtures that contain restricted classes and should not be tested
     *
     * @var array
     */
    private $fixtureFiles = [];

    /**
     * Restricted classes
     *
     * @var array
     */
    private $classes = [];

    /**
     * RestrictedCodeSniff constructor.
     */
    public function __construct()
    {
        // phpcs:ignore Magento2.Security.IncludeFile.FoundIncludeFile
        $this->classes = include __DIR__ . '/_files/restricted_classes.php';
    }

    /**
     * @inheritdoc
     */
    public function register()
    {
        return [
            T_STRING,
            T_CONSTANT_ENCAPSED_STRING
        ];
    }

    /**
     * @inheritdoc
     */
    public function process(File $phpcsFile, $stackPtr)
    {
        // phpcs:ignore Magento2.Functions.DiscouragedFunction
        if (array_key_exists(basename($phpcsFile->getFilename()), $this->fixtureFiles)) {
            return;
        }

        $tokens = $phpcsFile->getTokens();
        $token = $tokens[$stackPtr]['content'];
        if ($this->isQualifiedNameStart($phpcsFile, $stackPtr)) {
            // A qualified name is split into T_STRING and T_NS_SEPARATOR tokens, so it has to be put together.
            $nameEnd = $phpcsFile->findNext([T_STRING, T_NS_SEPARATOR], $stackPtr, null, true) ?: count($tokens);
            $name = $phpcsFile->getTokensAsString($stackPtr, $nameEnd - $stackPtr);
            if (array_key_exists($name, $this->classes)) {
                $token = $name;
            }
        }
        if (array_key_exists($token, $this->classes)) {
            if ($this->isExcluded($token, $phpcsFile)) {
                return;
            }
            $phpcsFile->addError(
                sprintf(
                    self::ERROR_MESSAGE,
                    $token,
                    $phpcsFile->getFilename(),
                    $this->classes[$token]['replacement']
                ),
                $stackPtr,
                $this->classes[$token]['warning_code'],
            );
        }
    }

    /**
     * Checks if the token is the first part of a qualified class name
     *
     * @param File $phpcsFile
     * @param int $stackPtr
     * @return bool
     */
    private function isQualifiedNameStart(File $phpcsFile, int $stackPtr): bool
    {
        $tokens = $phpcsFile->getTokens();
        if ($tokens[$stackPtr]['code'] !== T_STRING || ($tokens[$stackPtr + 1]['code'] ?? null) !== T_NS_SEPARATOR) {
            return false;
        }

        return $tokens[$stackPtr - 1]['code'] !== T_NS_SEPARATOR
            || !in_array($tokens[$stackPtr - 2]['code'], [T_STRING, T_NAMESPACE], true);
    }

    /**
     * Checks if currently parsed file should be excluded from analysis
     *
     * @param string $token
     * @param File $phpcsFile
     * @return bool
     */
    private function isExcluded(string $token, File $phpcsFile): bool
    {
        if (in_array($phpcsFile->getFilename(), $this->fixtureFiles)) {
            return true;
        }
        foreach ($this->classes[$token]['exclude'] as $exclude) {
            if (strpos($phpcsFile->getFilename(), $exclude) !== false) {
                return true;
            }
        }
        return false;
    }
}
