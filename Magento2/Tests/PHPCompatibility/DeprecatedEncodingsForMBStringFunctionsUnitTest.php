<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magento2\Tests\PHPCompatibility;

/**
 * Test the DeprecatedEncodingsForMBStringFunctions sniff.
 *
 * @covers \Magento2\Sniffs\PHPCompatibility\DeprecatedEncodingsForMBStringFunctionsSniff
 */
class DeprecatedEncodingsForMBStringFunctionsUnitTest extends \PHPCompatibility\Tests\BaseSniffTest
{
    /**
     * Message per encoding
     *
     * @var string[]
     */
    private $messages = [
        'qprint' => 'Handling QPrint via mbstring is deprecated since PHP 8.2;' .
            ' Use quoted_printable_encode/quoted_printable_decode instead',
        'quoted-printable' => 'Handling QPrint via mbstring is deprecated since PHP 8.2;' .
            ' Use quoted_printable_encode/quoted_printable_decode instead',
        'base64' => 'Handling Base64 via mbstring is deprecated since PHP 8.2;' .
            ' Use base64_encode/base64_decode instead',
        'uuencode' => 'Handling Uuencode via mbstring is deprecated since PHP 8.2;' .
            ' Use convert_uuencode/convert_uudecode instead',
        'html-entities' => 'Handling HTML entities via mbstring is deprecated since PHP 8.2;' .
            ' Use htmlspecialchars, htmlentities, or mb_encode_numericentity/mb_decode_numericentity instead',
        'html' => 'Handling HTML entities via mbstring is deprecated since PHP 8.2;' .
            ' Use htmlspecialchars, htmlentities, or mb_encode_numericentity/mb_decode_numericentity instead'
    ];

    /**
     * Verify a deprecation warning is thrown if MBString function is used with encodings: QPrint,BASE64,UUENCODE,HTML
     *
     * @dataProvider usageOfDeprecatedEncodingsInMbStringFunctionsDataProvider
     * @param string $encoding
     * @param int $start
     * @param int $end
     * @return void
     */
    public function testUsageOfDeprecatedEncodingsInMbStringFunctions($encoding, $start, $end)
    {
        $file = $this->sniffFile(__FILE__, '8.2');
        // No errors expected on the first 11 lines.
        for ($line = $start; $line <= $end; $line++) {
            $this->assertWarning($file, $line, $this->messages[$encoding]);
        }
    }

    /**
     * Data provider.
     *
     * @see testUsageOfDeprecatedEncodingsInMbStringFunctions()
     *
     * @return array
     */
    public function usageOfDeprecatedEncodingsInMbStringFunctionsDataProvider()
    {
        return [
            ['base64', 7, 33],
            ['qprint', 36, 62],
            ['quoted-printable', 65, 91],
            ['uuencode', 94, 120],
            ['html-entities', 123, 149],
            ['html', 157, 178],
        ];
    }

    /**
     * Verify the sniff does not throw false positives for valid code.
     *
     * @return void
     */
    public function testNoFalsePositives()
    {
        $file = $this->sniffFile(__FILE__, '8.2');

        // No errors expected on the first 11 lines.
        for ($line = 183; $line <= 188; $line++) {
            $this->assertNoViolation($file, $line);
        }
    }

    /**
     * Verify no notices are thrown at all.
     *
     * @return void
     */
    public function testNoViolationsInFileOnValidVersion()
    {
        $file = $this->sniffFile(__FILE__, '8.1');
        $this->assertNoViolation($file);
    }

    /**
     * @inheritdoc
     */
    protected function getSniffCode()
    {
        return 'Magento2.PHPCompatibility.DeprecatedEncodingsForMBStringFunctions';
    }
}
