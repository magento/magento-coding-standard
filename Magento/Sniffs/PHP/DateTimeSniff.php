<?php
/**
 * Copyright © Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\Sniffs\PHP;

use PHP_CodeSniffer\Sniffs\Sniff;
use PHP_CodeSniffer\Files\File;

/**
 * Detects overcomplicated Date/Time handling.
 */
class DateTimeSniff implements Sniff
{
    /**
     * String representation of warning.
     *
     * @var string
     */
    // phpcs:ignore Magento.Files.LineLength.MaxExceeded
    protected $warningMessage = 'Overcomplicated Date/Time handling. Use \Magento\Framework\Stdlib\DateTime\TimezoneInterface instead.';

    /**
     * Warning violation code.
     *
     * @var string
     */
    protected $warningCode = 'Overcomplicated';

    /**
     * Class names to find.
     *
     * @var array
     */
    protected $dateTimeClasses = [
        'DateTime',
        'DateTimeZone',
        'Zend_Date',
    ];

    /**
     * @inheritdoc
     */
    public function register()
    {
        return [T_NEW];
    }

    /**
     * @inheritdoc
     */
    public function process(File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();
        $posOfClassName = $phpcsFile->findNext(T_STRING, $stackPtr);
        $posOfNsSeparator = $phpcsFile->findNext(T_NS_SEPARATOR, $stackPtr, $posOfClassName);
        if ($posOfNsSeparator !== false && in_array($tokens[$posOfClassName]['content'], $this->dateTimeClasses)) {
            $phpcsFile->addWarning($this->warningMessage, $stackPtr, $this->warningCode);
        }
    }
}
