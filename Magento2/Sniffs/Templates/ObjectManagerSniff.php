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

namespace Magento2\Sniffs\Templates;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

/**
 * Templates must not instantiate new objects within their code.
 * All objects must be passed from the Block object.
 *
 * @see https://developer.adobe.com/commerce/php/coding-standards/technical-guidelines/#62-presentation-layer 6.2.6
 * @link https://developer.adobe.com/commerce/frontend-core/guide/layouts/xml-instructions/#obtain-arguments-examples-in-template
 * @link https://developer.adobe.com/commerce/frontend-core/guide/templates/override/#getting-argument-values-from-layout
 */
class ObjectManagerSniff implements Sniff
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
            'ObjectManager should not be used in .phtml template. ' .
            'Templates must not instantiate new objects within their code. ' .
            'All objects must be passed from the Block object.',
            $stackPtr,
            self::WARNING_CODE_OBJECT_MANAGER_USAGE
        );
    }
}
