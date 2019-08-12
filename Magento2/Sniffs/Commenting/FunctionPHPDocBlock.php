<?php
/**
 * Copyright © Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magento2\Sniffs\Commenting;

class FunctionPHPDocBlock
{

    /**
     * @param array $tokens
     * @param int $docStart
     * @param int $docEnd
     * @return array
     */
    public function execute(array $tokens, $docStart, $docEnd)
    {
        $description = false;
        for ($i = $docStart; $i <= $docEnd; $i++) {
            $token = $tokens[$i];
            $code = $token['code'];
            $content = $token['content'];

            if ($code === T_DOC_COMMENT_TAG) {
                break;
            }

            if ($code === T_DOC_COMMENT_STRING && $content !== "\n") {
                $description = $content;
            }
        }

        $functionDeclarations = [
            'warning' => false,
            'description' => $description,
            'return' => '',
            'parameter' => [],
            'throws' => [],
        ];

        $lastDocLine = 0;
        $docType = false;
        for ($i = $docStart; $i <= $docEnd; $i++) {
            $token = $tokens[$i];
            $code = $token['code'];
            $line = $token['line'];
            $content = $token['content'];

            preg_match('/@inheritdoc*/', $content, $inheritdoc);
            if (isset($inheritdoc[0])) {
                $functionDeclarations['warning'] = ['The @inheritdoc tag SHOULD NOT be used.', $i];

                return $functionDeclarations;
            }

            if ($code === T_DOC_COMMENT_TAG) {
                $lastDocLine = $line;
                $docType = $token['content'];
                continue;
            }

            if ($lastDocLine !== $line) {
                $lastDocLine = 0;
                continue;
            }

            if ($content === ' ' || $content === "\n") {
                continue;
            }

            preg_match_all('/[A-Za-z0-9$]*/', $content, $docTokens);
            $docTokens = array_values(array_filter($docTokens[0]));

            switch ($docType) {
                case '@param':
                    $functionDeclarations = self::addParamTagValue($docTokens, $functionDeclarations);
                    break;

                case '@return':
                    $functionDeclarations = self::addReturnTagValue($docTokens, $functionDeclarations);
                    break;

                case '@throws':
                    $functionDeclarations = self::addThrowsTagValue($docTokens, $functionDeclarations);
                    break;
            }
        }

        return $functionDeclarations;
    }

    /**
     * @param array $tokens
     * @param array $functionDeclarations
     * @return array
     */
    private function addParamTagValue(array $tokens, array $functionDeclarations)
    {
        if (count($tokens) === 0) {
            return $functionDeclarations; // empty parameter declaration
        }

        $type = false;
        $content = false;

        foreach ($tokens as $token) {
            if (strpos($token, '$') !== false) {
                $content = $token;
                continue;
            }
            $type = $token;
        }

        $functionDeclarations['parameter'][] = ['content' => $content, 'type' => $type,];

        return $functionDeclarations;
    }

    /**
     * @param array $docTokens
     * @param array $functionDeclarations
     * @return array
     */
    private function addReturnTagValue(array $docTokens, array $functionDeclarations)
    {
        // @todo imepelement me
        return $functionDeclarations;
    }

    /**
     * @param array $docTokens
     * @param array $functionDeclarations
     * @return array
     */
    private function addThrowsTagValue(array $docTokens, array $functionDeclarations)
    {
        // @todo imepelement me
        return $functionDeclarations;
    }
}
