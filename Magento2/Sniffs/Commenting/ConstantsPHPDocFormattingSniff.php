<?php
/**
 * Copyright 2019 Adobe
 * All Rights Reserved.
 */
namespace Magento2\Sniffs\Commenting;

use Magento2\Helpers\Commenting\PHPDocFormattingValidator;
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

        $commentStartPtr = $this->PHPDocFormattingValidator->findPHPDoc($stackPtr, $phpcsFile);
        if ($commentStartPtr === -1) {
            return;
        }

        if ($this->PHPDocFormattingValidator->providesMeaning($constNamePtr, $commentStartPtr, $tokens) !== true) {
            $phpcsFile->addWarning(
                'Constants must have short description if they add information beyond what the constant name supplies.',
                $stackPtr,
                'MissingConstantPHPDoc'
            );
        }

        if ($this->PHPDocFormattingValidator->hasDeprecatedWellFormatted($commentStartPtr, $tokens) !== true) {
            $phpcsFile->addWarning(
                'Motivation behind the added @deprecated tag MUST be explained. '
                    . '@see tag MUST be used with reference to new implementation when code is deprecated '
                    . 'and there is a new alternative.',
                $stackPtr,
                'InvalidDeprecatedTagUsage'
            );
        }
    }
}
