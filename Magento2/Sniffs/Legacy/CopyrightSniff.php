<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types = 1);

namespace Magento2\Sniffs\Legacy;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

class CopyrightSniff implements Sniff
{
    private const WARNING_CODE = 'FoundCopyrightMissingOrWrongFormat';
    
    private const COPYRIGHT_MAGENTO_TEXT = 'Copyright © Magento, Inc. All rights reserved.';
    private const COPYRIGHT_ADOBE = '/Copyright \d+ Adobe/';
    
    /**
     * @inheritdoc
     */
    public function register()
    {
        return [T_OPEN_TAG];
    }
    
    /**
     * @inheritDoc
     */
    public function process(File $phpcsFile, $stackPtr)
    {
        $positionOpenTag = $phpcsFile->findPrevious(T_OPEN_TAG, $stackPtr - 1);
       
        if ($positionOpenTag === false) {
            $positionComment = $phpcsFile->findNext(T_DOC_COMMENT_STRING, $stackPtr);
            $contentFile = $phpcsFile->getTokens()[$positionComment]['content'];
            $adobeCopyrightFound = preg_match(self::COPYRIGHT_ADOBE, $contentFile);
            
            if (strpos($contentFile, self::COPYRIGHT_MAGENTO_TEXT) === false || $adobeCopyrightFound === false) {
                $phpcsFile->addWarningOnLine(
                    'Copyright is missing or has wrong format',
                    null,
                    self::WARNING_CODE
                );
            }
        }
    }
}
