<?php
/**
 * Copyright © Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento2\Sniffs\GraphQL;

use PHP_CodeSniffer\Files\File;

/**
 * Detects field names the are not specified in <kbd>snake_case</kbd>.
 */
class ValidFieldNameSniff extends AbstractGraphQLSniff
{
    /**
     * @inheritDoc
     */
    public function register()
    {
        return [T_VARIABLE];
    }

    /**
     * @inheritDoc
     */
    public function process(File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();
        $name   = $tokens[$stackPtr]['content'];

        if (!$this->isSnakeCase($name)) {
            $type  = 'Field';
            $error = '%s name "%s" is not in snake_case format';
            $data  = [
                $type,
                $name,
            ];
            $phpcsFile->addError($error, $stackPtr, 'NotSnakeCase', $data);
            $phpcsFile->recordMetric($stackPtr, 'SnakeCase field name', 'no');
        } else {
            $phpcsFile->recordMetric($stackPtr, 'SnakeCase field name', 'yes');
        }
    }
}
