<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types = 1);

namespace Magento2Framework\Sniffs\Header;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

class CopyrightAnotherExtensionsFilesSniff implements Sniff
{
    use CopyrightValidation;
    private const WARNING_CODE = 'FoundCopyrightMissingOrWrongFormat';

    /**
     * Defines the tokenizers that this sniff is using.
     *
     * @var array
     */
    public $supportedTokenizers = ['CSS', 'PHP', 'JS'];

    /**
     * @inheritDoc
     */
    public function register(): array
    {
        return [
            T_INLINE_HTML,
            T_OPEN_TAG
        ];
    }

    /**
     * @inheritDoc
     */
    public function process(File $phpcsFile, $stackPtr)
    {
        if ($stackPtr > 0) {
            return;
        }

      // @phpcs:ignore Magento2.Functions.DiscouragedFunction.Discouraged
        $content = file_get_contents($phpcsFile->getFilename());

        if ($this->isCopyrightYearValid($content) === false) {
            $phpcsFile->addWarningOnLine(
                'Copyright is missing or has wrong format',
                null,
                self::WARNING_CODE
            );
        }
    }
}
