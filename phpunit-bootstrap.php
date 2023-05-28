<?php

/**
 * Bootstrap file for tests.
 */

if (defined('PHP_CODESNIFFER_IN_TESTS') === false) {
    define('PHP_CODESNIFFER_IN_TESTS', true);
}

// The below two defines are needed for PHPCS 3.x.
if (defined('PHP_CODESNIFFER_CBF') === false) {
    define('PHP_CODESNIFFER_CBF', false);
}

if (defined('PHP_CODESNIFFER_VERBOSITY') === false) {
    define('PHP_CODESNIFFER_VERBOSITY', 0);
}

require_once __DIR__ . '/vendor/squizlabs/php_codesniffer/autoload.php';
require_once __DIR__ . '/vendor/phpcompatibility/php-compatibility/PHPCSAliases.php';
