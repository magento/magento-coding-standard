<?php
/**
 * PHPCompatibility, an external standard for PHP_CodeSniffer.
 *
 * @package   PHPCompatibility
 * @copyright 2012-2020 PHPCompatibility Contributors
 * @license   https://opensource.org/licenses/LGPL-3.0 LGPL3
 * @link      https://github.com/PHPCompatibility/PHPCompatibility
 */

namespace Magento2\Tests\PHPCompatibility;

use PHP_CodeSniffer\Tests\Standards\AbstractSniffUnitTest;

/**
 * Test the ForbiddenFinalPrivateMethods sniff.
 *
 * @group forbiddenFinalPrivateMethods
 * @group functiondeclarations
 *
 * @covers \Magento2\Sniffs\PHPCompatibility\ForbiddenFinalPrivateMethodsSniff
 *
 * @since 10.0.0
 */
class ForbiddenFinalPrivateMethodsUnitTest extends AbstractSniffUnitTest
{
    /**
     * @inheritdoc
     */
    public function getErrorList()
    {
        return [];
    }

    /**
     * @inheritdoc
     */
    public function getWarningList()
    {
        return [
            6 => 1,
            7 => 1,
            14 => 1,
            15 => 1,
            23 => 1,
            25 => 1,
        ];
    }
}
