<?php
namespace Magento2\Sniffs\Commenting;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

class ClassPropertyPHPDocFormattingSniff implements Sniff
{

    private $ignoreTokens = [
        T_PUBLIC,
        T_PRIVATE,
        T_PROTECTED,
        T_VAR,
        T_STATIC,
        T_WHITESPACE,
    ];

    /**
     * @inheritDoc
     */
    public function register()
    {
        return [
            T_VARIABLE
        ];
    }

    /**
     * @inheritDoc
     */
    public function process(File $phpcsFile, $stackPtr)
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
            $phpcsFile->addWarning($error, $commentEnd, 'MissingVar');
            return;
        }

        $string = $phpcsFile->findNext(T_DOC_COMMENT_STRING, $foundVar, $commentEnd);
        if ($string === false || $tokens[$string]['line'] !== $tokens[$foundVar]['line']) {
            $error = 'Content missing for @var tag in class property comment';
            $phpcsFile->addWarning($error, $foundVar, 'EmptyVar');
            return;
        }
    }
}
