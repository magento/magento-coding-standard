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
 * Sniff to validate PHP deprecated function.
 */
class DeprecatedFunctionSniff implements Sniff
{
    /**
     * Deprecated functions without argument.
     *
     * @var array
     */
    private $deprecatedFunctions = [
        'mb_check_encoding'
    ];

    /**
     * @inheritdoc
     */
    public function register(): array
    {
        return [
            T_OPEN_TAG
        ];
    }

    /**
     * @inheritdoc
     */
    public function process(File $phpcsFile, $stackPtr): void
    {
        $tokens = $phpcsFile->getTokens();

        foreach ($this->deprecatedFunctions as $deprecatedFunction) {
            $deprecatedFunctionKeys = array_keys(array_column($tokens, 'content'), $deprecatedFunction);

            foreach ($deprecatedFunctionKeys as $deprecatedFunctionKey) {
                $openParenthesis = $phpcsFile->findNext(T_OPEN_PARENTHESIS, $deprecatedFunctionKey);
                $closeParenthesis = $phpcsFile->findNext(T_CLOSE_PARENTHESIS, $openParenthesis);
                $argumentString = trim(
                    $phpcsFile->getTokensAsString($openParenthesis + 1, $closeParenthesis - $openParenthesis - 1)
                );

                if (!$argumentString) {
                    $warningMessage = sprintf(
                        'Calling function %s() without argument is deprecated in PHP 8.1',
                        $deprecatedFunction
                    );
                    $phpcsFile->addWarning($warningMessage, $deprecatedFunctionKey, 'DeprecatedFunction');
                }
            }
        }
    }
}
