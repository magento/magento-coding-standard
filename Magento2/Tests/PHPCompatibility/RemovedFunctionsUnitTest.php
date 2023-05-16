<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magento2\Tests\PHPCompatibility;

/**
 * Test the RemovedFunctions sniff.
 *
 * @covers \Magento2\Sniffs\PHPCompatibility\RemovedFunctionsSniff
 */
class RemovedFunctionsUnitTest extends \PHPCompatibility\Tests\FunctionUse\RemovedFunctionsUnitTest
{
    /**
     * @inheritdoc
     */
    protected function getSniffCode()
    {
        return 'Magento2.PHPCompatibility.RemovedFunctions';
    }

    /**
     * @param string $testFile
     * @param array $errors
     * @return void
     * @dataProvider php8DeprecatedFunctionDataProvider
     */
    public function testPhp82DeprecatedFunction(string $testFile, array $errors): void
    {
        $file = $this->sniffFile($testFile, '8.2');
        foreach ($errors as [$line, $functionName, $alternative]) {
            $this->assertWarning(
                $file,
                $line,
                "Function $functionName() is deprecated since PHP 8.2; Use $alternative instead"
            );
        }
    }

    /**
     * Data provider.
     *
     * @return array
     * @see testPhp82DeprecatedFunction()
     *
     */
    public function php8DeprecatedFunctionDataProvider()
    {
        return [
            [
                __DIR__ . '/RemovedFunctionsUnitTest.82.inc',
                [
                    [3, 'utf8_encode', 'iconv()'],
                    [4, 'utf8_decode', 'iconv()'],
                ]
            ]
        ];
    }
}
