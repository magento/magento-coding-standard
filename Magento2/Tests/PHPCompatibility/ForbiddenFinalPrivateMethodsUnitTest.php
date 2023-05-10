<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magento2\Tests\PHPCompatibility;

use PHP_CodeSniffer\Tests\Standards\AbstractSniffUnitTest;

/**
 * Test the ForbiddenFinalPrivateMethods sniff.
 *
 * @covers \Magento2\Sniffs\PHPCompatibility\ForbiddenFinalPrivateMethodsSniff
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
    public function getWarningList($testFile = '')
    {
        if ($testFile === 'ForbiddenFinalPrivateMethodsUnitTest.inc') {
            return [
                34 => 1,
                35 => 1,
                39 => 1,
                40 => 1,
                45 => 1,
                46 => 1,
                54 => 1,
                60 => 1,
            ];
        }
        return [
            5 => 1,
            6 => 1,
            11 => 1,
            12 => 1,
            13 => 1,
        ];
    }

    /**
     * @inheritdoc
     */
    protected function getTestFiles($testFileBase)
    {
        $files = parent::getTestFiles($testFileBase);
        return array_merge(
            $files,
            [
                dirname(__FILE__, 4) . '/PHPCompatibility/Tests/FunctionDeclarations/ForbiddenFinalPrivateMethodsUnitTest.inc',
            ]
        );
    }
}
