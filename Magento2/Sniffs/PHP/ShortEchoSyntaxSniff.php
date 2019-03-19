<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
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
            $phpcsFile->addWarning(
                'Short echo tag syntax must be used; expected "<?=" but found "<?php echo"',
                $stackPtr,
                'ShortEchoTag'
            );
        }
    }
}
