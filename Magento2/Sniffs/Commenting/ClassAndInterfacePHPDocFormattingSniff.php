<?php

/**
 * Copyright © Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento2\Sniffs\Commenting;

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

        $commentStartPtr = $phpcsFile->findPrevious(
            [
                T_WHITESPACE,
                T_DOC_COMMENT_STAR,
                T_DOC_COMMENT_WHITESPACE,
                T_DOC_COMMENT_TAG,
                T_DOC_COMMENT_STRING,
                T_DOC_COMMENT_CLOSE_TAG
            ],
            $stackPtr - 1,
            null,
            true,
            null,
            true
        );

        if ($tokens[$commentStartPtr]['code'] !== T_DOC_COMMENT_OPEN_TAG) {
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
