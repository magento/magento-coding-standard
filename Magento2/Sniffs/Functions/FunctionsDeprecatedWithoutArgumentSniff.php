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
     * Deprecated functions without argument.
     *
     * @var array
     */
    private const FUNCTIONS_LIST = [
        'mb_check_encoding',
        'get_class',
        'get_parent_class',
        'get_called_class'
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

        if (in_array($functionName, self::FUNCTIONS_LIST)) {
            $phpcsFile->addWarning(sprintf(self::WARNING_MESSAGE, $functionName), $stackPtr, self::WARNING_CODE);
        }
    }
}
