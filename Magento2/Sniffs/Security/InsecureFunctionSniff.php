<?php
/**
 * Copyright 2019 Adobe
 * All Rights Reserved.
 */
namespace Magento2\Sniffs\Security;

use PHP_CodeSniffer\Standards\Generic\Sniffs\PHP\ForbiddenFunctionsSniff;

/**
 * Detects the use of insecure functions.
 */
class InsecureFunctionSniff extends ForbiddenFunctionsSniff
{
    /**
     * List of patterns for forbidden functions.
     *
     * @var array
     */
    public $forbiddenFunctions = [
        'assert' => null,
        'create_function' => null,
        'exec' => '\Magento\Framework\Shell::execute',
        'md5' => 'improved hash functions (SHA-256, SHA-512 etc.)',
        'passthru' => null,
        'pcntl_exec' => null,
        'popen' => null,
        'proc_open' => null,
        'serialize' => '\Magento\Framework\Serialize\SerializerInterface::serialize',
        'shell_exec' => null,
        'system' => null,
        'unserialize' => '\Magento\Framework\Serialize\SerializerInterface::unserialize',
        'srand' => null,
        'mt_srand' => null,
        'mt_rand' => 'random_int',
        // Custom Rules - MTS-2096
        'eval' => null,
        'proc_nice' => null,
        'proc_open' => null,
        'proc_close' => null,
        'proc_terminate' => null,
        'proc_get_status' => null,
    ];
}
