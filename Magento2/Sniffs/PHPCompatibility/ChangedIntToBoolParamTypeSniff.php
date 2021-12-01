<?php
/**
 * PHPCompatibility, an external standard for PHP_CodeSniffer.
 *
 * @package   PHPCompatibility
 * @copyright 2012-2020 PHPCompatibility Contributors
 * @license   https://opensource.org/licenses/LGPL-3.0 LGPL3
 * @link      https://github.com/PHPCompatibility/PHPCompatibility
 */

namespace Magento2\Sniffs\PHPCompatibility;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Util\Tokens;
use PHPCompatibility\AbstractFunctionCallParameterSniff;
use Magento2\Helpers\PHPCSUtils\BackCompat\BCTokens;

/**
 * Detect calls to functions where the expected type of a parameter has been changed from integer to boolean.
 *
 * Throws an error when a hard-coded numeric value is passed.
 *
 * PHP version 8.0+
 *
 * @since 10.0.0
 */
class ChangedIntToBoolParamTypeSniff extends AbstractFunctionCallParameterSniff
{

    /**
     * Functions to check for.
     *
     * @since 10.0.0
     *
     * @var array
     */
    protected $targetFunctions = [
        'ob_implicit_flush' => [
            1 => [
                'name'  => 'flag',
                'since' => '8.0',
            ],
        ],
        'sem_get' => [
            4 => [
                'name'  => 'auto_release',
                'since' => '8.0',
            ],
        ],
    ];

    /**
     * Do a version check to determine if this sniff needs to run at all.
     *
     * Checks against the first PHP version listed in the above array.
     *
     * @since 10.0.0
     *
     * @return bool
     */
    protected function bowOutEarly()
    {
        return ($this->supportsAbove('8.0') === false);
    }

    /**
     * Process the parameters of a matched function.
     *
     * @since 10.0.0
     *
     * @param \PHP_CodeSniffer\Files\File $phpcsFile    The file being scanned.
     * @param int                         $stackPtr     The position of the current token in the stack.
     * @param string                      $functionName The token content (function name) which was matched.
     * @param array                       $parameters   Array with information about the parameters.
     *
     * @return int|void Integer stack pointer to skip forward or void to continue
     *                  normal file processing.
     */
    public function processParameters(File $phpcsFile, $stackPtr, $functionName, $parameters)
    {
        static $search;

        if (isset($search) === false) {
            $search  = [
                \T_LNUMBER => \T_LNUMBER,
                \T_DNUMBER => \T_DNUMBER,
            ];
            $search += BCTokens::arithmeticTokens();
            $search += Tokens::$emptyTokens;
        }

        $functionLC   = \strtolower($functionName);
        $functionInfo = $this->targetFunctions[$functionLC];
        foreach ($functionInfo as $offset => $paramInfo) {
            if (isset($parameters[$offset]) === false) {
                continue;
            }

            if ($this->supportsAbove($paramInfo['since']) === false) {
                continue;
            }

            $target = $parameters[$offset];

            $hasNonNumeric = $phpcsFile->findNext($search, $target['start'], ($target['end'] + 1), true);
            if ($hasNonNumeric !== false) {
                // Not a purely numerical value. Ignore.
                continue;
            }

            $error = 'The $%s parameter of %s() expects a boolean value instead of an integer since PHP %s. Found: %s';
            $code  = $this->stringToErrorCode($functionName . '_' . $paramInfo['name']) . 'NumericFound';
            $data  = [
                $paramInfo['name'],
                $functionLC,
                $paramInfo['since'],
                $target['raw'],
            ];

            $phpcsFile->addError($error, $target['start'], $code, $data);
        }
    }
}
