<?php
/************************************************************************
 *
 * Copyright 2024 Adobe
 * All Rights Reserved.
 *
 * NOTICE: All information contained herein is, and remains
 * the property of Adobe and its suppliers, if any. The intellectual
 * and technical concepts contained herein are proprietary to Adobe
 * and its suppliers and are protected by all applicable intellectual
 * property laws, including trade secret and copyright laws.
 * Dissemination of this information or reproduction of this material
 * is strictly forbidden unless prior written permission is obtained
 * from Adobe.
 * **********************************************************************
 */
declare(strict_types = 1);

namespace Magento2\Sniffs\Phtml;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

class PhtmlTemplateObjectManagerSniff implements Sniff
{
    private const WARNING_CODE_OBJECT_MANAGER_USAGE = 'ObjectManagerUsageFound';

    /**
     * @inheritdoc
     */
    public function register()
    {
        return [T_DOUBLE_COLON];
    }

    /**
     * @inheritdoc
     */
    public function process(File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();

        if ($tokens[$stackPtr - 1]['content'] !== 'ObjectManager'
            && $tokens[$stackPtr + 1]['content'] !== 'getInstance'
        ) {
            return;
        }

        $phpcsFile->addWarning(
            'ObjectManager should not be used in .phtml template ' .
            'as it’s not a template’s responsibility to create objects.',
            $stackPtr,
            self::WARNING_CODE_OBJECT_MANAGER_USAGE
        );
    }
}
