<?php
/**
 * Copyright 2021 Adobe
 * All Rights Reserved.
 */
declare(strict_types = 1);

namespace Magento2Framework\Sniffs\Header;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

class CopyrightSniff implements Sniff
{
    use CopyrightValidation;

    private const WARNING_CODE = 'FoundCopyrightMissingOrWrongFormat';

    /**
     * @inheritdoc
     */
    public function register()
    {
        return [T_OPEN_TAG];
    }

    /**
     * @inheritDoc
     */
    public function process(File $phpcsFile, $stackPtr)
    {
        if ($phpcsFile->findPrevious(T_OPEN_TAG, $stackPtr - 1) !== false) {
            return;
        }

        $positionComment = $phpcsFile->findNext(T_DOC_COMMENT_STRING, $stackPtr);

        if ($positionComment === false) {
            $phpcsFile->addWarning(
                'Copyright is missing',
                $stackPtr,
                self::WARNING_CODE
            );
            return;
        }

        // @phpcs:ignore Magento2.Functions.DiscouragedFunction.Discouraged
        $content = file_get_contents($phpcsFile->getFilename());

        if ($this->isCopyrightYearValid($content) === false) {
            $phpcsFile->addWarningOnLine(
                'Copyright is missing or Copyright content/year is not valid',
                null,
                self::WARNING_CODE
            );
        }
    }
}
