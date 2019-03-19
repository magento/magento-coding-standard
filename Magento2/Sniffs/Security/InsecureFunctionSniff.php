<?php
/**
 * Copyright © Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento2\Sniffs\Functions;

use PHP_CodeSniffer\Standards\Generic\Sniffs\PHP\ForbiddenFunctionsSniff;

/**
 * Detects the use of insecure functions.
 */
class InsecureFunctionSniff extends ForbiddenFunctionsSniff
{
    /**
     * If true, an error will be thrown; otherwise a warning.
     *
     * @var boolean
     */
    public $error = false;

    /**
     * List of patterns for forbidden functions.
     *
     * @var array
     */
    public $forbiddenFunctions = [
        'assert' => null,
        'exec' => null,
        'passthru' => null,
        'shell_exec' => null,
        'system' => null,
        'md5' => 'improved hash functions (SHA-256, SHA-512 etc.)',
        'serialize' => 'json_encode',
        'unserialize' => 'json_decode',
    ];
}
