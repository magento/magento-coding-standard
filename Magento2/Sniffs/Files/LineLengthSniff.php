<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento2\Sniffs\Files;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Standards\Generic\Sniffs\Files\LineLengthSniff as FilesLineLengthSniff;

/**
 * Line length sniff which ignores long lines in case they contain strings intended for translation.
 */
class LineLengthSniff extends FilesLineLengthSniff
{
    /**
     * Having previous line content allows to ignore long lines in case of translations.
     *
     * @var string
     */
    protected $lastLineContent = '';

    /**
     * Regular expression for finding a translation in the last line.
     *
     * @var string
     */
    protected $lastLineRegExp = '~__\(.+\)|\bPhrase\(.+\)~';

    /**
     * Having the next-to-last line content allows to ignore long lines in case of translations.
     *
     * @var string
     */
    protected $nextToLastLineContent = '';

    /**
     * Regular expression for finding a translation in the next-to-last line.
     *
     * @var string
     */
    protected $nextToLastLineRegexp = '~__\($|\bPhrase\($~';

    /**
     * @inheritdoc
     */
    public $lineLimit = 120;

    /**
     * @inheritdoc
     */
    public $absoluteLineLimit = 120;

    /**
     * @inheritdoc
     */
    protected function checkLineLength($phpcsFile, $tokens, $stackPtr)
    {
        /*
         * The parent sniff checks the length of the previous line, so we have to inspect the previous line instead of
         * the current one.
         */
        if (!$this->doesPreviousLineContainTranslationString()) {
            parent::checkLineLength($phpcsFile, $tokens, $stackPtr);
        }

        $this->updateLineBuffer($phpcsFile, $tokens, $stackPtr);
    }

    /**
     * Checks whether the previous line is part of a translation.
     *
     * The generic line sniff (which we are falling back to if there is no translation) always checks the length of the
     * last line, so we have to check the last and next-to-last line for translations.
     *
     * @return bool
     */
    protected function doesPreviousLineContainTranslationString()
    {
        $lastLineMatch       = preg_match($this->lastLineRegExp, $this->lastLineContent) !== 0;
        $nextToLastLineMatch = preg_match($this->nextToLastLineRegexp, $this->nextToLastLineContent) !== 0;

        return $lastLineMatch || $nextToLastLineMatch;
    }

    /**
     * Assembles and returns the content for the code line of the provided stack pointer.
     *
     * @param File $phpcsFile
     * @param array $tokens
     * @param int $stackPtr
     * @return string
     */
    protected function getLineContent(File $phpcsFile, array $tokens, $stackPtr)
    {
        $lineContent = '';

        /*
         * Avoid out of range error at the end of the file
         */
        if (!array_key_exists($stackPtr, $tokens)) {
            return $lineContent;
        }

        $codeLine = $tokens[$stackPtr]['line'];

        /*
         * Concatenate the string until we jump to the next line or reach the end of line character.
         */
        while (array_key_exists($stackPtr, $tokens) &&
               $tokens[$stackPtr]['line'] === $codeLine &&
               $tokens[$stackPtr]['content'] !== $phpcsFile->eolChar) {
            $lineContent .= $tokens[$stackPtr]['content'];
            $stackPtr++;
        }

        return $lineContent;
    }

    /**
     * Pre-fills the line buffer for the next iteration.
     *
     * @param File $phpcsFile
     * @param array $tokens
     * @param int $stackPtr
     */
    protected function updateLineBuffer(File $phpcsFile, array $tokens, $stackPtr)
    {
        $this->nextToLastLineContent = $this->lastLineContent;
        $this->lastLineContent       = $this->getLineContent($phpcsFile, $tokens, $stackPtr);
    }
}
