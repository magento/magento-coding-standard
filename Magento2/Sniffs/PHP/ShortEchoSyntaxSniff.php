<?php
/**
 * Copyright 2019 Adobe
 * All Rights Reserved.
 */
namespace Magento2\Sniffs\PHP;

use PHP_CodeSniffer\Sniffs\Sniff;
use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Util\Tokens;

/**
 * Validate short echo syntax is used.
 */
class ShortEchoSyntaxSniff implements Sniff
{
    /**
     * @inheritdoc
     */
    public function register()
    {
        return [T_OPEN_TAG];
    }

    /**
     * @inheritdoc
     */
    public function process(File $phpcsFile, $stackPtr)
    {
        $tokens  = $phpcsFile->getTokens();
        $openTag = $tokens[$stackPtr];

        // HHVM Will classify <?= as a T_OPEN_TAG
        if ($openTag['content'] === '<?=') {
            return;
        }

        $nextToken = $phpcsFile->findNext(Tokens::$emptyTokens, ($stackPtr + 1), null, true);
        if ($tokens[$nextToken]['code'] == T_ECHO) {
            $fix = $phpcsFile->addFixableWarning(
                'Short echo tag syntax must be used; expected "<?=" but found "<?php echo"',
                $stackPtr,
                'ShortEchoTag'
            );

            if ($fix) {
                $phpcsFile->fixer->beginChangeset();

                if (($nextToken - $stackPtr) === 1) {
                    $phpcsFile->fixer->replaceToken($stackPtr, '<?=');
                } else {
                    $phpcsFile->fixer->replaceToken($stackPtr, '<?= ');
                }

                for ($i = $stackPtr + 1; $i < $nextToken; $i++) {
                    if ($tokens[$i]['code'] === T_WHITESPACE) {
                        $phpcsFile->fixer->replaceToken($i, '');
                    }
                }

                $phpcsFile->fixer->replaceToken($nextToken, '');
                $phpcsFile->fixer->endChangeset();
            }
        }
    }
}
