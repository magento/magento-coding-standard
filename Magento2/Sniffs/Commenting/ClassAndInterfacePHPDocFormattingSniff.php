<?php

/**
 * Copyright © Magento, Inc. All rights reserved.
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
        '@author',
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

        $commentCloserPtr = $tokens[$commentStartPtr]['comment_closer'];

        if ($this->PHPDocFormattingValidator->providesMeaning($namePtr, $commentStartPtr, $tokens) !== true) {
            $fix = $phpcsFile->addFixableWarning(
                sprintf(
                    '%s description must contain meaningful information beyond what its name provides or be removed.',
                    ucfirst($tokens[$stackPtr]['content'])
                ),
                $stackPtr,
                'InvalidDescription'
            );

            if ($fix) {
                for ($i = $commentStartPtr; $i <= $commentCloserPtr; $i++) {
                    $phpcsFile->fixer->replaceToken($i, '');
                }

                if ($tokens[$commentStartPtr - 1]['code'] === T_WHITESPACE
                    && $tokens[$commentCloserPtr + 1]['code'] === T_WHITESPACE
                ) {
                    $phpcsFile->fixer->replaceToken($commentCloserPtr + 1, '');
                }
            }
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
                $fix = $phpcsFile->addFixableWarning(
                    sprintf('Tag %s MUST NOT be used.', $tokens[$i]['content']),
                    $i,
                    'ForbiddenTags'
                );

                if ($fix) {
                    for ($j = $i - 1; $j > $commentStartPtr; $j--) {
                        if (!in_array($tokens[$j]['code'], [T_DOC_COMMENT_STAR, T_DOC_COMMENT_WHITESPACE], true)) {
                            break;
                        }

                        if ($tokens[$j]['code'] === T_DOC_COMMENT_WHITESPACE && $tokens[$j]['content'] === "\n") {
                            break;
                        }

                        $phpcsFile->fixer->replaceToken($j, '');
                    }

                    $phpcsFile->fixer->replaceToken($i, '');

                    for ($j = $i + 1; $j < $commentCloserPtr; $j++) {
                        $phpcsFile->fixer->replaceToken($j, '');

                        if ($tokens[$j]['code'] === T_DOC_COMMENT_WHITESPACE && $tokens[$j]['content'] === "\n") {
                            break;
                        }
                    }
                }
            }
        }

        return false;
    }
}
