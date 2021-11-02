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
    private $warningMessage = 'Deprecated: Automatic conversion of false to array is deprecated.';

    /**
     * Warning violation code.
     *
     * @var string
     */
    private $warningCode = 'Autovivification';

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
        $positionSquareBracket = $phpcsFile->findNext(T_OPEN_SQUARE_BRACKET, $stackPtr, $stackPtr + 2);

        if ($positionSquareBracket) {
            $tokens = $phpcsFile->getTokens();
            $propertyTokenKey = array_keys(array_column($tokens, 'content'), $tokens[$stackPtr]['content']);

            arsort($propertyTokenKey);

            foreach ($propertyTokenKey as $tokenKey) {
                if ($tokenKey < $stackPtr && $tokens[$tokenKey + 2]['content'] === '=') {
                    if ($tokens[$tokenKey + 4]['content'] != 'false') {
                        return;
                    }

                    $phpcsFile->addWarning($this->warningMessage, $positionSquareBracket, $this->warningCode);
                }
            }
        }
    }
}
