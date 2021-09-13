<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento2\Sniffs\GraphQL;

use PHP_CodeSniffer\Files\File;

/**
 * Detects top level field names that are not specified in <kbd>cameCase</kbd>.
 */
class ValidTopLevelFieldNameSniff extends AbstractGraphQLSniff
{
    /**
     * @inheritDoc
     */
    public function register()
    {
        return [T_FUNCTION];
    }

    /**
     * @inheritDoc
     */
    public function process(File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();

        //compose function name by making use of the next strings that we find until we hit a non-string token
        $name = '';
        for ($i=$stackPtr+1; $tokens[$i]['code'] === T_STRING; ++$i) {
            $name .= $tokens[$i]['content'];
        }

        if (strlen($name) > 0 && !$this->isCamelCase($name)) {
            $type  = ucfirst($tokens[$stackPtr]['content']);
            $error = '%s name "%s" is not in PascalCase format';
            $data  = [
                $type,
                $name,
            ];
            $phpcsFile->addError($error, $stackPtr, 'NotCamelCase', $data);
            $phpcsFile->recordMetric($stackPtr, 'CamelCase top level field name', 'no');
        } else {
            $phpcsFile->recordMetric($stackPtr, 'CamelCase top level field name', 'yes');
        }
    }
}
