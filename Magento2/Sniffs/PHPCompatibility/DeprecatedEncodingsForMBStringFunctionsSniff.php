<?php

/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magento2\Sniffs\PHPCompatibility;

use Magento2\Helpers\Assert;
use PHP_CodeSniffer\Files\File;
use PHPCompatibility\Sniff;
use PHP_CodeSniffer_Tokens as Tokens;

/**
 * Detect: Usage of the QPrint, Base64, Uuencode, and HTML-ENTITIES encodings is deprecated for all MBString functions.
 *
 * PHP version 8.2
 *
 * @link https://www.php.net/manual/en/migration82.deprecated.php
 */
class DeprecatedEncodingsForMBStringFunctionsSniff extends Sniff
{
    /**
     * A list of MBString functions that emits deprecation notice
     *
     * @var \int[][]
     */
    private $targetFunctions = [
        'mb_check_encoding' => [2],
        'mb_chr' => [2],
        'mb_convert_case' => [3],
        'mb_convert_encoding' => [2],
        'mb_convert_kana' => [3],
        'mb_convert_variables' => [1],
        'mb_decode_numericentity' => [3],
        'mb_encode_numericentity' => [3],
        'mb_encoding_aliases' => [1],
        'mb_ord' => [2],
        'mb_scrub' => [2],
        'mb_str_split' => [3],
        'mb_strcut' => [4],
        'mb_strimwidth' => [5],
        'mb_stripos' => [4],
        'mb_stristr' => [4],
        'mb_strlen' => [2],
        'mb_strpos' => [4],
        'mb_strrchr' => [4],
        'mb_strrichr' => [4],
        'mb_strripos' => [4],
        'mb_strrpos' => [4],
        'mb_strstr' => [4],
        'mb_strtolower' => [2],
        'mb_strtoupper' => [2],
        'mb_strwidth' => [2],
        'mb_substr_count' => [3],
        'mb_substr' => [4],
    ];

    /**
     * Message per encoding
     *
     * @var string[]
     */
    protected $messages = [
        'qprint' => 'Handling QPrint via mbstring is deprecated since PHP 8.2;' .
            ' Use quoted_printable_encode/quoted_printable_decode instead',
        'quoted-printable' => 'Handling QPrint via mbstring is deprecated since PHP 8.2;' .
            ' Use quoted_printable_encode/quoted_printable_decode instead',
        'base64' => 'Handling Base64 via mbstring is deprecated since PHP 8.2;' .
            ' Use base64_encode/base64_decode instead',
        'uuencode' => 'Handling Uuencode via mbstring is deprecated since PHP 8.2;' .
            ' Use convert_uuencode/convert_uudecode instead',
        'html-entities' => 'Handling HTML entities via mbstring is deprecated since PHP 8.2;' .
            ' Use htmlspecialchars, htmlentities, or mb_encode_numericentity/mb_decode_numericentity instead',
        'html' => 'Handling HTML entities via mbstring is deprecated since PHP 8.2;' .
            ' Use htmlspecialchars, htmlentities, or mb_encode_numericentity/mb_decode_numericentity instead'
    ];

    /**
     * @inheritdoc
     */
    public function register()
    {
        return [\T_STRING];
    }

    /**
     * @inheritdoc
     */
    public function process(File $phpcsFile, $stackPtr)
    {
        if (!$this->supportsAbove('8.2')) {
            return;
        }

        $tokens = $phpcsFile->getTokens();
        $function = $tokens[$stackPtr]['content'];
        $functionLc = strtolower($function);

        if (!isset($this->targetFunctions[$functionLc]) || !Assert::isBuiltinFunctionCall($phpcsFile, $stackPtr)) {
            return;
        }

        $parameters = $this->getFunctionCallParameters($phpcsFile, $stackPtr);

        foreach ($parameters as $index => $parameter) {
            $this->processParameter($phpcsFile, $function, $index, $parameter);
        }
    }

    /**
     * Process function parameter
     *
     * @param File $phpcsFile
     * @param string $function
     * @param int $index
     * @param array $parameter
     *
     * @return void
     */
    public function processParameter(File $phpcsFile, string $function, int $index, array $parameter)
    {
        $functionLc = strtolower($function);
        if (!in_array($index, $this->targetFunctions[$functionLc])) {
            return;
        }

        $tokens = $phpcsFile->getTokens();
        $targetParam = $parameter;
        $nextNonEmpty = $phpcsFile->findNext(Tokens::$emptyTokens, $targetParam['start'], $targetParam['end'], true);

        if ($nextNonEmpty !== false && in_array($tokens[$nextNonEmpty]['code'], [\T_ARRAY, \T_OPEN_SHORT_ARRAY])) {
            $items = $this->getFunctionCallParameters($phpcsFile, $nextNonEmpty);
        } else {
            $items = [$parameter];
        }

        $textStringTokens = [
            \T_CONSTANT_ENCAPSED_STRING => true,
            \T_DOUBLE_QUOTED_STRING => true,
            \T_INLINE_HTML => true,
            \T_HEREDOC => true,
            \T_NOWDOC => true,
        ];

        foreach ($items as $item) {
            for ($i = $item['start']; $i <= $item['end']; $i++) {
                if (
                    $tokens[$i]['code'] === \T_STRING
                    || $tokens[$i]['code'] === \T_VARIABLE
                ) {
                    // Variable, constant, function call. Ignore complete item as undetermined.
                    break;
                }

                if (isset($textStringTokens[$tokens[$i]['code']]) === true) {
                    $encoding = $this->stripQuotes(strtolower(trim($tokens[$i]['content'])));
                    $encodings = array_flip(explode(',', $encoding));
                    if (count(array_intersect_key($encodings, $this->messages)) > 0) {
                        $phpcsFile->addWarning(
                            $this->messages[$encoding],
                            $i,
                            'Deprecated',
                            [$item['raw']]
                        );
                    }

                    // Only throw one error per array item.
                    break;
                }
            }
        }
    }
}
