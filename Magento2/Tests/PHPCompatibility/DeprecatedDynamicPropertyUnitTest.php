<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magento2\Tests\PHPCompatibility;

/**
 * Test the DeprecatedDynamicProperty sniff.
 *
 * @covers \Magento2\Sniffs\PHPCompatibility\DeprecatedEncodingsForMBStringFunctionsSniff
 */
class DeprecatedDynamicPropertyUnitTest extends \PHPCompatibility\Tests\BaseSniffTest
{
    const TEST_FILE_WITH_AUTOLOADABLE_CLASS = 'DeprecatedDynamicPropertyUnitTest.autoload.inc';

    /**
     * Verify a deprecation warning is thrown if a dynamic property is found in a class.
     *
     * @dataProvider dataProvider
     * @param string $testFile
     * @param array $errors
     * @return void
     */
    public function testCreationOfDynamicProperty(string $testFile, array $errors): void
    {
        $file = $this->sniffFile($testFile, '8.2');
        foreach ($errors as [$line, $property]) {
            $this->assertWarning(
                $file,
                $line,
                'Access to an undefined property '. $property .'; Creation of dynamic property is deprecated since PHP 8.2'
            );
        }
    }

    /**
     * Verify the sniff does not throw false positives for valid code.
     *
     * @dataProvider dataProvider
     * @param string $testFile
     * @param array $errors
     * @return void
     */
    public function testNoFalsePositives(string $testFile, array $errors): void
    {
        $file = $this->sniffFile($testFile, '8.2');
        $errorLines = array_column($errors, 0, 0);
        $totalLines = substr_count(file_get_contents(\str_replace('UnitTest.php', 'UnitTest.inc', $testFile)), PHP_EOL);

        for ($line = 1; $line <= $totalLines; $line++) {
            if (isset($errorLines[$line])) {
                continue;
            }
            $this->assertNoViolation($file, $line);
        }
    }

    /**
     * Verify no notices are thrown at all.
     *
     * @dataProvider dataProvider
     * @param string $file
     * @param array $errors
     * @return void
     */
    public function testNoViolationsInFileOnValidVersion(string $testFile, array $errors): void
    {
        $file = $this->sniffFile($testFile, '8.1');
        $this->assertNoViolation($file);
    }

    /**
     * Data provider.
     *
     * @return array
     * @see testCreationOfDynamicProperty()
     * @see testNoFalsePositives()
     * @see testNoViolationsInFileOnValidVersion()
     *
     */
    public function dataProvider()
    {
        return [
            [
                __FILE__,
                [
                    [128, 'Foo4::$prop1'],
                    [129, 'Foo4::$prop2'],
                    [130, 'Foo4::$prop3'],
                    [136, 'Foo4::$prop9'],
                    [151, 'Foo5::$prop1'],
                    [152, 'Foo5::$prop2'],
                    [153, 'Foo5::$prop3'],
                    [156, 'Foo5::$prop6'],
                    [157, 'Foo5::$prop7'],
                    [158, 'Foo5::$prop8'],
                    [159, 'Foo5::$prop9'],
                    [160, 'Foo5::$prop9'],
                    [161, 'Foo5::$prop9'],
                    [162, 'Foo5::$prop9'],
                ]
            ],
            [
                __DIR__ . '/' . self::TEST_FILE_WITH_AUTOLOADABLE_CLASS,
                [
                    [18, 'Magento2\Sniffs\PHPCompatibility\DeprecatedDynamicPropertySniff::$xyz'],
                ]
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    protected function getSniffCode()
    {
        return 'Magento2.PHPCompatibility.DeprecatedDynamicProperty';
    }
}
