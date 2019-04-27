<?php
/**
 * Copyright © Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento2\Sniffs\Security;

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
        'create_function' => null,
        'exec' => null,
        'json_decode' => 'injection \Magento\Framework\Serialize\SerializerInterface to your construct and unserialize',
        'json_encode' => 'injection \Magento\Framework\Serialize\SerializerInterface to your construct and serialize',
        'md5' => 'improved hash functions (SHA-256, SHA-512 etc.)',
        'passthru' => null,
        'pcntl_exec' => null,
        'popen' => null,
        'proc_open' => null,
        'serialize' => 'injection \Magento\Framework\Serialize\SerializerInterface to your construct and serialize',
        'shell_exec' => null,
        'system' => null,
        'unserialize' => 'injection \Magento\Framework\Serialize\SerializerInterface to your construct and unserialize',
        'srand' => null,
        'mt_srand'=> null,
    ];
}
