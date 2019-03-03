<?php
/**
 * Copyright © Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magento\Sniffs\Exceptions;

use PHP_CodeSniffer\Sniffs\Sniff;
use PHP_CodeSniffer\Files\File;

/**
 * Detects possible direct throws of Exceptions.
 */
class LocalizedThrowSniff implements Sniff
{

    protected $presentationLayerKeys = ['Controller', 'Block', 'ViewModel'];

    /**
     * String representation of warning.
     */
    protected $warningMessage = 'LocalizedException SHOULD only be thrown in the Presentation layer.';

    /**
     * Warning violation code.
     *
     * @var string
     */
    protected $warningCode = 'LocalizedThrow';

    /**
     * @inheritdoc
     */
    public function register()
    {
        return [T_THROW];
    }

    /**
     * @inheritdoc
     */
    public function process(File $phpcsFile, $stackPtr)
    {
        $lineEnd = $phpcsFile->findNext(T_OPEN_PARENTHESIS, $stackPtr);
        $exceptionType = $phpcsFile->getTokensAsString($stackPtr, $lineEnd);

        // throw is not a LocalizedException nothing to do
        if (strpos($exceptionType, 'LocalizedException') === false) {
            return;
        }

        $nameSpaceTag = $phpcsFile->findPrevious(T_NAMESPACE, $stackPtr, 0);
        if ($nameSpaceTag === false) {
            // no namespace nothing to do
            return;
        }

        $lineEnd = $phpcsFile->findNext(T_SEMICOLON, $nameSpaceTag);
        $nameSpaceString = $phpcsFile->getTokensAsString($nameSpaceTag, $lineEnd);

        $isPresentationLayer = false;
        foreach ($this->presentationLayerKeys as $layerKey) {
            if (strpos($nameSpaceString, $layerKey) !== false) {
                $isPresentationLayer = true;
                break;
            }
        }

        if (!$isPresentationLayer) {
            $phpcsFile->addWarning(
                $this->warningMessage,
                $stackPtr,
                $this->warningCode
            );
        }
    }
}
