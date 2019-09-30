<?php

/**
 * Copyright © Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento2\Sniffs\Commenting;

use Magento2\Helpers\Commenting\PHPDocFormattingValidator;
use PHP_CodeSniffer\Sniffs\Sniff;
use PHP_CodeSniffer\Files\File;

/**
 * Detects PHPDoc formatting for classes and interfaces.
 */
class ClassAndInterfacePHPDocFormattingSniff implements Sniff
{
    /**
     * @var PHPDocFormattingValidator
     */
    private $PHPDocFormattingValidator;

    /**
     * @var string[] List of tags that can not be used in comments
     */
    public $forbiddenTags = [
        '@category',
        '@package',
        '@subpackage'
    ];

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
            T_CLASS,
            T_INTERFACE
        ];
    }

    /**
     * @inheritDoc
     */
    public function process(File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();

        $namePtr = $phpcsFile->findNext(T_STRING, $stackPtr + 1, null, false, null, true);

        $commentStartPtr = $this->PHPDocFormattingValidator->findPHPDoc($stackPtr, $phpcsFile);
        if ($commentStartPtr === -1) {
            return;
        }

        if ($this->PHPDocFormattingValidator->providesMeaning($namePtr, $commentStartPtr, $tokens) !== true) {
            $phpcsFile->addWarning(
                sprintf(
                    '%s description should contain additional information beyond the name already supplies.',
                    ucfirst($tokens[$stackPtr]['content'])
                ),
                $stackPtr,
                'InvalidDescription'
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

        $this->validateTags($phpcsFile, $commentStartPtr, $tokens);
    }

    /**
     * Validates that forbidden tags are not used in comment
     *
     * @param File $phpcsFile
     * @param int $commentStartPtr
     * @param array $tokens
     * @return bool
     */
    private function validateTags(File $phpcsFile, $commentStartPtr, $tokens)
    {
        $commentCloserPtr = $tokens[$commentStartPtr]['comment_closer'];

        for ($i = $commentStartPtr; $i <= $commentCloserPtr; $i++) {
            if ($tokens[$i]['code'] !== T_DOC_COMMENT_TAG) {
                continue;
            }

            if (in_array($tokens[$i]['content'], $this->forbiddenTags) === true) {
                $phpcsFile->addWarning(
                    sprintf('Tag %s MUST NOT be used.', $tokens[$i]['content']),
                    $i,
                    'ForbiddenTags'
                );
            }
        }

        return false;
    }
}
