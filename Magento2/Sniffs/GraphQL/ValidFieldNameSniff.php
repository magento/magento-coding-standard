<?php
/**
 * Copyright © Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento2\Sniffs\GraphQL;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;
use PHP_CodeSniffer\Util\Common;

/**
 * Detects field names the are not specified in <kbd>snake_case</kbd>.
 */
class ValidFieldNameSniff implements Sniff
{

    /**
     * Defines the tokenizers that this sniff is using.
     *
     * @var array
     */
    public $supportedTokenizers = ['GraphQL'];

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

    /**
     * Returns whether <var>$name</var> is strictly lower case, potentially separated by underscores.
     *
     * @param string $name
     * @return bool
     */
    private function isSnakeCase($name)
    {
        return preg_match('/^[a-z][a-z0-9_]*$/', $name);
    }
}
