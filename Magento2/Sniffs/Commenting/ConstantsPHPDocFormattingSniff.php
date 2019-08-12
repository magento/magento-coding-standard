<?php
/**
 * Copyright © Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento2\Sniffs\Commenting;

use PHP_CodeSniffer\Sniffs\Sniff;
use PHP_CodeSniffer\Files\File;

/**
 * Detects PHPDoc formatting for constants.
 */
class ConstantsPHPDocFormattingSniff implements Sniff
{
    /**
     * @var PHPDocFormattingValidator
     */
    private $PHPDocFormattingValidator;

    /**
     * Helper initialisation
     */
    public function __construct()
    {
        $this->PHPDocFormattingValidator = new PHPDocFormattingValidator();
    }

    /**
     * @inheritDoc
     */
    public function register()
    {
        return [
            T_CONST,
            T_STRING
        ];
    }

    /**
     * @inheritDoc
     */
    public function process(File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();

        if ($tokens[$stackPtr]['code'] !== T_CONST
            && !($tokens[$stackPtr]['content'] === 'define' && $tokens[$stackPtr + 1]['code'] === T_OPEN_PARENTHESIS)
        ) {
            return;
        }

        $constNamePtr = $phpcsFile->findNext(
            ($tokens[$stackPtr]['code'] === T_CONST) ? T_STRING : T_CONSTANT_ENCAPSED_STRING,
            $stackPtr + 1,
            null,
            false,
            null,
            true
        );

        $commentStartPtr = $phpcsFile->findPrevious(T_DOC_COMMENT_OPEN_TAG, $stackPtr - 1, null, false, null, true);
        if ($commentStartPtr === false) {
            return;
        }

        if ($this->PHPDocFormattingValidator->providesMeaning($constNamePtr, $commentStartPtr, $tokens) !== true) {
            $phpcsFile->addWarning(
                'Constants must have short description if they add information beyond what the constant name supplies.',
                $stackPtr,
                'MissingConstantPHPDoc'
            );
        }
    }
}
