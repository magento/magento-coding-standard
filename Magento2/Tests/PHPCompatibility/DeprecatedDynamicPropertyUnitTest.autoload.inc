<?php
/*
 * Test: Creation of dynamic property when class cannot be autoloaded
 */
namespace Magento2\Sniffs\PHPCompatibility;

use PHP_CodeSniffer\Files\File;

class DeprecatedDynamicPropertySniff extends \PHPCompatibility\Sniff
{
    public function register()
    {
        // TODO: Implement register() method.
    }

    public function process(File $phpcsFile, $stackPtr)
    {
        $this->xyz = 1; // this property is not defined anywhere.
        $this->superglobals['TEST_VAR'] = 'TEST_VAR'; // this property is defined in the parent class.
    }
}
