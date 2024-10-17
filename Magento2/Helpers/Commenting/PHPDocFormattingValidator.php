<?php

/**
 * Copyright 2019 Adobe
 * All Rights Reserved.
 */
namespace Magento2\Helpers\Commenting;

use PHP_CodeSniffer\Files\File;

/**
 * Helper class for common DocBlock validations
 */
class PHPDocFormattingValidator
{
    /**
     * Finds matching PHPDoc for current pointer
     *
     * @param int $startPtr
     * @param File $phpcsFile
     * @return int
     */
    public function findPHPDoc($startPtr, $phpcsFile)
    {
        $tokens = $phpcsFile->getTokens();

        $commentStartPtr = $phpcsFile->findPrevious(
            [
                T_WHITESPACE,
                T_DOC_COMMENT_STAR,
                T_DOC_COMMENT_WHITESPACE,
                T_DOC_COMMENT_TAG,
                T_DOC_COMMENT_STRING,
                T_DOC_COMMENT_CLOSE_TAG
            ],
            $startPtr - 1,
            null,
            true,
            null,
            true
        );

        if ($tokens[$commentStartPtr]['code'] !== T_DOC_COMMENT_OPEN_TAG) {
            return -1;
        }

        return $commentStartPtr;
    }

    /**
     * Determines if the comment identified by $commentStartPtr provides additional meaning to origin at $namePtr
     *
     * @param int $namePtr
     * @param int $commentStartPtr
     * @param array $tokens
     * @return bool
     */
    public function providesMeaning($namePtr, $commentStartPtr, $tokens)
    {
        $commentCloserPtr = $tokens[$commentStartPtr]['comment_closer'];
        $name = strtolower(str_replace([' ', '"', '_'], '', $tokens[$namePtr]['content']));

        $hasTags = false;
        $hasDescription = false;

        for ($i = $commentStartPtr; $i <= $commentCloserPtr; $i++) {
            $token = $tokens[$i];

            // Important, but not the string we are looking for
            if ($token['code'] === T_DOC_COMMENT_TAG) {
                $hasTags = true;
                continue;
            }

            // Not an interesting string
            if ($token['code'] !== T_DOC_COMMENT_STRING) {
                continue;
            }

            // Wrong kind of string
            if ($tokens[$i - 2]['code'] === T_DOC_COMMENT_TAG) {
                continue;
            }

            $hasDescription = true;

            // Comment is the same as the origin name
            $docComment = str_replace(['_', ' ', '.', ','], '', strtolower($token['content']));
            if ($docComment === $name) {
                continue;
            }

            // Only difference is word Class or Interface
            $docComment = str_replace(['class', 'interface'], '', $docComment);
            if ($docComment === $name) {
                continue;
            }

            // We have found at lease one meaningful line in comment description
            return true;
        }

        // Contains nothing but the tags
        if ($hasTags === true && $hasDescription === false) {
            return true;
        }

        return false;
    }

    /**
     * In case comment has deprecated tag, it must be explained and followed by see tag with details
     *
     * @param int $commentStartPtr
     * @param array $tokens
     * @return bool
     */
    public function hasDeprecatedWellFormatted($commentStartPtr, $tokens)
    {
        $deprecatedPtr = $this->getTagPosition('@deprecated', $commentStartPtr, $tokens);
        if ($deprecatedPtr === -1) {
            return true;
        }
        $seePtr = $this->getTagPosition('@see', $commentStartPtr, $tokens);
        if ($seePtr === -1) {
            if (preg_match(
                "/This [a-zA-Z]* will be removed in version \d.\d.\d without replacement/",
                $tokens[$deprecatedPtr + 2]['content']
            )) {
                return true;
            }
            return false;
        }

        return $tokens[$seePtr + 2]['code'] === T_DOC_COMMENT_STRING;
    }

    /**
     * Searches for tag within comment
     *
     * @param string $tag
     * @param int $commentStartPtr
     * @param array $tokens
     * @return int
     */
    private function getTagPosition($tag, $commentStartPtr, $tokens)
    {
        $commentCloserPtr = $tokens[$commentStartPtr]['comment_closer'];

        for ($i = $commentStartPtr; $i <= $commentCloserPtr; $i++) {
            $token = $tokens[$i];

            // Not interesting
            if ($token['code'] !== T_DOC_COMMENT_TAG || $token['content'] !== $tag) {
                continue;
            }

            return $i;
        }

        return -1;
    }
}
