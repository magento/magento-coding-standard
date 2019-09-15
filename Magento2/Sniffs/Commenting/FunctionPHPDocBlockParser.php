<?php
/**
 * Copyright © Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magento2\Sniffs\Commenting;

class FunctionPHPDocBlockParser
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
            'description' => $description,
            'tags' => [],
            'return' => '',
            'parameters' => [],
            'throws' => [],
        ];

        $lastDocLine = 0;
        $docType = false;
        for ($i = $docStart; $i <= $docEnd; $i++) {
            $token = $tokens[$i];
            $code = $token['code'];
            $line = $token['line'];
            $content = $token['content'];


            if ($code === T_DOC_COMMENT_TAG) {
                // add php tokens also without comment to tag list
                if (preg_match('/@[a-z]++/', $content, $output_array)) {
                    $functionDeclarations['tags'][] = $content;
                }

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

            if (count($docTokens) === 0) {
                // ignore empty parameter declaration
                continue;
            }

            switch ($docType) {
                case '@param':
                    $functionDeclarations = $this->addParamTagValue($docTokens, $functionDeclarations);
                    break;

                case '@return':
                    $functionDeclarations = $this->addReturnTagValue($docTokens, $functionDeclarations);
                    break;

                case '@throws':
                    $functionDeclarations = $this->addThrowsTagValue($docTokens, $functionDeclarations);
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
        $type = false;
        $content = false;

        foreach ($tokens as $token) {
            if (strpos($token, '$') !== false) {
                $content = $token;
                continue;
            }
            $type = $token;
        }

        $functionDeclarations['parameters'][] = ['content' => $content, 'type' => $type,];

        return $functionDeclarations;
    }

    /**
     * @param array $docTokens
     * @param array $functionDeclarations
     * @return array
     */
    private function addReturnTagValue(array $tokens, array $functionDeclarations)
    {
        $functionDeclarations['return'] = $tokens[0];
        return $functionDeclarations;
    }

    /**
     * @param array $docTokens
     * @param array $functionDeclarations
     * @return array
     */
    private function addThrowsTagValue(array $tokens, array $functionDeclarations)
    {
        $functionDeclarations['throws'][] = $tokens[0];
        return $functionDeclarations;
    }
}
