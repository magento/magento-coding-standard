<?php

/**
 * Copyright © Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento2\Sniffs\Commenting;

/**
 * Helper class for common DocBlock validations
 */
class PHPDocFormattingValidator
{
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
        $commentCloserPtr = $tokens[$commentStartPtr]['comment_closer'];

        $hasDeprecated = false;
        $hasSee = false;

        for ($i = $commentStartPtr; $i <= $commentCloserPtr; $i++) {
            $token = $tokens[$i];

            // Not interesting
            if ($token['code'] !== T_DOC_COMMENT_TAG) {
                continue;
            }

            $tag = $token['content'];

            // Not an interesting tag
            if ($tag !== '@deprecated' && $tag !== '@see') {
                continue;
            }

            if ($tag === '@deprecated') {
                $hasDeprecated = true;
            }

            if ($tag === '@see') {
                $hasSee = true;
            }

            // Tag not followed by description
            if ($tokens[$i + 2]['code'] !== T_DOC_COMMENT_STRING) {
                return false;
            }
        }

        if ($hasDeprecated === true && $hasSee !== true) {
            return false;
        }

        return true;
    }
}
