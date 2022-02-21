<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento2\Sniffs\Functions;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

/**
 * Sniff to validate PHP functions usage of which without passing arguments is deprecated.
 */
class FunctionsDeprecatedWithoutArgumentSniff implements Sniff
{
    /**
     * String representation of warning.
     *
     * @var string
     */
    private const WARNING_MESSAGE = 'Calling function %s() without argument is deprecated in PHP 8.1. '
        . 'Please pass the input to validate as the first argument of the function.';

    /**
     * Warning violation code.
     *
     * @var string
     */
    private const WARNING_CODE = 'FunctionsDeprecatedWithoutArgument';

    /**
     * Deprecated functions without argument https://wiki.php.net/rfc/deprecations_php_8_1
     *
     * @var array
     */
    private const DEPRECATED_FUNCTIONS_AND_FIXES = [
        'mb_check_encoding' => false,
        'get_class' => '$this',
        'get_parent_class' => '$this'
    ];

    /**
     * @inheritdoc
     */
    public function register(): array
    {
        return [
            T_OPEN_PARENTHESIS
        ];
    }

    /**
     * @inheritdoc
     */
    public function process(File $phpcsFile, $stackPtr): void
    {
        $closeParenthesisPtr = $phpcsFile->findNext(T_CLOSE_PARENTHESIS, $stackPtr);
        $arguments = trim($phpcsFile->getTokensAsString($stackPtr + 1, $closeParenthesisPtr - $stackPtr - 1));

        if ($arguments) {
            return;
        }

        $functionName = $phpcsFile->getTokensAsString($phpcsFile->findPrevious(T_STRING, $stackPtr), 1);

        if (!isset(self::DEPRECATED_FUNCTIONS_AND_FIXES[$functionName])) {
            return;
        }

        if (self::DEPRECATED_FUNCTIONS_AND_FIXES[$functionName] === false) {
            $phpcsFile->addWarning(
                sprintf(self::WARNING_MESSAGE, $functionName),
                $stackPtr,
                self::WARNING_CODE
            );
            return;
        }
        
        $fix = $phpcsFile->addFixableWarning(
            sprintf(self::WARNING_MESSAGE, $functionName),
            $stackPtr,
            self::WARNING_CODE
        );

        if ($fix === true) {
            $content = self::DEPRECATED_FUNCTIONS_AND_FIXES[$functionName];
            $phpcsFile->fixer->beginChangeset();
            $phpcsFile->fixer->addContentBefore($phpcsFile->findNext(T_CLOSE_PARENTHESIS, $stackPtr), $content);
            $phpcsFile->fixer->endChangeset();
        }
    }
}
