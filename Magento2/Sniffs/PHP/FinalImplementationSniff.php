<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento2\Sniffs\PHP;

use PHP_CodeSniffer\Sniffs\Sniff;
use PHP_CodeSniffer\Files\File;

/**
 * Magento is a highly extensible and customizable platform. The use of final classes and methods is prohibited.
 */
class FinalImplementationSniff implements Sniff
{
    /**
     * @inheritdoc
     */
    public function register()
    {
        return [T_FINAL];
    }

    /**
     * @inheritdoc
     */
    public function process(File $phpcsFile, $stackPtr)
    {
        $phpcsFile->addError(
            // phpcs:ignore Generic.Files.LineLength
            'Final keyword is prohibited in Magento. It decreases extensibility and is not compatible with plugins and proxies.',
            $stackPtr,
            'FoundFinal'
        );
    }
}
