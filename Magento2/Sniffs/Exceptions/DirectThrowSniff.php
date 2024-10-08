<?php
/**
 * Copyright 2018 Adobe
 * All Rights Reserved.
 */
namespace Magento2\Sniffs\Exceptions;

use PHP_CodeSniffer\Sniffs\Sniff;
use PHP_CodeSniffer\Files\File;

/**
 * Detects possible direct throws of Exceptions.
 */
class DirectThrowSniff implements Sniff
{
    /**
     * String representation of warning.
     * phpcs:disable Generic.Files.LineLength.TooLong
     * @var string
     */
    protected $warningMessage = 'Direct throw of generic Exception is discouraged. Use context specific instead.';
    //phpcs:enable

    /**
     * Warning violation code.
     *
     * @var string
     */
    protected $warningCode = 'FoundDirectThrow';

    /**
     * @inheritdoc
     */
    public function register()
    {
        return [T_THROW];
    }

    /**
     * @inheritdoc
     */
    public function process(File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();
        $endOfStatement = $phpcsFile->findEndOfStatement($stackPtr);
        $posOfException = $phpcsFile->findNext(T_STRING, $stackPtr, $endOfStatement);

        $fullExceptionString = $this->getFullClassNameAndAlias($tokens, $stackPtr, $endOfStatement);
        $exceptionString = 'Exception';
        $customExceptionFound = false;
        foreach ($tokens as $key => $token) {
            if ($token['code'] !== T_USE) {
                continue;
            }
            $endOfUse = $phpcsFile->findEndOfStatement($key);
            $useStatementValue = $this->getFullClassNameAndAlias($tokens, $key, $endOfUse);
            //we safely consider use statement has alias will not be a direct exception class
            if (empty($useStatementValue['alias'])) {
                if (substr($useStatementValue['name'], 0, strlen($exceptionString)) !== $exceptionString
                    && substr($useStatementValue['name'], -strlen($exceptionString)) === $exceptionString
                    && $useStatementValue['name'] !== $exceptionString
                ) {
                    $customExceptionFound = true;
                    break;
                }
            }
        }
        if (($tokens[$posOfException]['content'] === 'Exception' && !$customExceptionFound)
            || $fullExceptionString['name'] === '\Exception'
        ) {
            $phpcsFile->addWarning(
                $this->warningMessage,
                $stackPtr,
                $this->warningCode,
                [$posOfException]
            );
        }
    }

    /**
     * Get full class name and alias
     *
     * @param array $tokens
     * @param int $start
     * @param int $end
     * @return array
     */
    private function getFullClassNameAndAlias($tokens, $start, $end): array
    {
        $fullName = $alias = '';
        $foundAlias = false;
        for ($i = $start; $i <= $end; $i++) {
            $type = $tokens[$i]['code'];
            if ($type === T_AS) {
                $foundAlias = true;
                continue;
            }
            if ($type === T_STRING || $type === T_NS_SEPARATOR) {
                if (!$foundAlias) {
                    $fullName .= $tokens[$i]['content'];
                } else {
                    $alias = $tokens[$i]['content'];
                }
            }
        }
        return ['name' => $fullName, 'alias' => $alias];
    }
}
