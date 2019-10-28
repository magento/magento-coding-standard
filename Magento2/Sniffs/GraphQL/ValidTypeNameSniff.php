<?php
/**
 * Copyright © Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento2\Sniffs\GraphQL;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Util\Common;

/**
 * Detects types (<kbd>type</kbd>, <kbd>interface</kbd> and <kbd>enum</kbd>) that are not specified in
 * <kbd>UpperCamelCase</kbd>.
 */
class ValidTypeNameSniff extends AbstractGraphQLSniff
{
    /**
     * @inheritDoc
     */
    public function register()
    {
        return [T_CLASS, T_INTERFACE];
    }

    /**
     * @inheritDoc
     */
    public function process(File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();

        //compose entity name by making use of the next strings that we find until we hit a non-string token
        $name = '';
        for ($i=$stackPtr+1; $tokens[$i]['code'] === T_STRING; ++$i) {
            $name .= $tokens[$i]['content'];
        }

        $valid = Common::isCamelCaps($name, true, true, false);

        if ($valid === false) {
            $type  = ucfirst($tokens[$stackPtr]['content']);
            $error = '%s name "%s" is not in PascalCase format';
            $data  = [
                $type,
                $name,
            ];
            $phpcsFile->addError($error, $stackPtr, 'NotCamelCaps', $data);
            $phpcsFile->recordMetric($stackPtr, 'PascalCase class name', 'no');
        } else {
            $phpcsFile->recordMetric($stackPtr, 'PascalCase class name', 'yes');
        }
    }
}
