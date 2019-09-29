<?php
namespace Magento2\Sniffs\Commenting;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\AbstractVariableSniff;

/**
 * Class ClassPropertyPHPDocFormattingSniff
 */
class ClassPropertyPHPDocFormattingSniff extends AbstractVariableSniff
{

    /**
     * @var array
     */
    private $ignoreTokens = [
        T_PUBLIC,
        T_PRIVATE,
        T_PROTECTED,
        T_VAR,
        T_STATIC,
        T_WHITESPACE,
    ];

    /**
     * @param File $phpcsFile
     * @param int $stackPtr
     * @return int|void
     */
    public function processMemberVar(File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();

        $commentEnd = $phpcsFile->findPrevious($this->ignoreTokens, ($stackPtr - 1), null, true);
        if ($commentEnd === false
            || ($tokens[$commentEnd]['code'] !== T_DOC_COMMENT_CLOSE_TAG
                && $tokens[$commentEnd]['code'] !== T_COMMENT)
        ) {
            $phpcsFile->addWarning('Missing class property doc comment', $stackPtr, 'Missing');
            return;
        }

        $commentStart = $tokens[$commentEnd]['comment_opener'];

        $foundVar = null;
        foreach ($tokens[$commentStart]['comment_tags'] as $tag) {
            if ($tokens[$tag]['content'] === '@var') {
                if ($foundVar !== null) {
                    $error = 'Only one @var tag is allowed in a class property comment';
                    $phpcsFile->addWarning($error, $tag, 'DuplicateVar');
                } else {
                    $foundVar = $tag;
                }
            }
        }

        if ($foundVar === null) {
            $error = 'Missing @var tag in class property comment';
            $phpcsFile->addWarning($error, $stackPtr, 'MissingVar');
            return;
        }

        $string = $phpcsFile->findNext(T_DOC_COMMENT_STRING, $foundVar, $commentEnd);
        if ($string === false || $tokens[$string]['line'] !== $tokens[$foundVar]['line']) {
            $error = 'Content missing for @var tag in class property comment';
            $phpcsFile->addWarning($error, $foundVar, 'EmptyVar');
            return;
        }

        // Check if class has already have meaningful description
        $isShortDescription = $phpcsFile->findPrevious(T_DOC_COMMENT_STRING, $commentEnd, $foundVar, false);
        if ($tokens[$string]['line'] !==  $tokens[$isShortDescription]['line']) {
            $error = 'Variable member already have meaningful name';
            $phpcsFile->addWarning($error, $isShortDescription, 'AlreadyMeaningFulNameVar');
            return;
        }
    }

    /**
     * @param File $phpcsFile
     * @param int $stackPtr
     * @return int|void
     * phpcs:disable Magento2.CodeAnalysis.EmptyBlock
     */
    protected function processVariable(File $phpcsFile, $stackPtr)
    {
    }

    /**
     * @param File $phpcsFile
     * @param int $stackPtr
     * @return int|void
     * phpcs:disable Magento2.CodeAnalysis.EmptyBlock
     */
    protected function processVariableInString(File $phpcsFile, $stackPtr)
    {
    }
}
