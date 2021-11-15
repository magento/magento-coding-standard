<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento2\Sniffs\PHP;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

/**
 * Sniff to validate array autovivification.
 */
class ArrayAutovivificationSniff implements Sniff
{
    /**
     * String representation of error.
     *
     * @var string
     */
    private const WARNING_MESSAGE = 'Deprecated: Automatic conversion of false to array is deprecated.';

    /**
     * Error violation code.
     *
     * @var string
     */
    private const WARNING_CODE = 'Autovivification';

    /**
     * @inheritdoc
     */
    public function register(): array
    {
        return [
            T_VARIABLE
        ];
    }

    /**
     * @inheritdoc
     */
    public function process(File $phpcsFile, $stackPtr): void
    {
        $openSquareBracketKey = $phpcsFile->findNext(T_OPEN_SQUARE_BRACKET, $stackPtr, $stackPtr + 2);

        if (!$openSquareBracketKey) {
            return;
        }

        $closeSquareBracketKey = $phpcsFile->findNext(T_CLOSE_SQUARE_BRACKET, $openSquareBracketKey);
        $hasEqualKey = $phpcsFile->findNext(T_EQUAL, $closeSquareBracketKey, $closeSquareBracketKey + 3);

        if (!$hasEqualKey) {
            return;
        }

        $tokens = $phpcsFile->getTokens();
        $functionKey = $phpcsFile->findPrevious(T_FUNCTION, $openSquareBracketKey) ?: 0;
        $sliceToken = array_slice(array_column($tokens, 'content'), $functionKey, $stackPtr - $functionKey, true);
        $propertyTokenKey = array_keys($sliceToken, $tokens[$stackPtr]['content']);

        arsort($propertyTokenKey);

        foreach ($propertyTokenKey as $propertyKey) {
            $positionEqualKey = $phpcsFile->findNext(T_EQUAL, $propertyKey, $propertyKey + 3);

            if ($positionEqualKey) {
                $falseKey = $phpcsFile->findNext(T_FALSE, $positionEqualKey, $positionEqualKey + 3);

                if (!($falseKey && $phpcsFile->findNext(T_SEMICOLON, $falseKey, $falseKey + 2))) {
                    return;
                }

                $phpcsFile->addWarning(self::WARNING_MESSAGE, $openSquareBracketKey, self::WARNING_CODE);
            }
        }
    }
}
