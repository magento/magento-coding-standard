<?php
/**
 * Copyright © Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento2\Sniffs\Legacy;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

class AbstractBlockSniff implements Sniff
{
    private const CHILD_HTML_METHOD = 'getChildHtml';
    private const CHILD_CHILD_HTML_METHOD = 'getChildChildHtml';

    /**
     * Warning violation code.
     *
     * @var string
     */
    protected $errorCode = 'FoundCountOfParametersIncorrect';

    /**
     * @inheritdoc
     */
    public function register(): array
    {
        return [
            T_OBJECT_OPERATOR
        ];
    }

    /**
     * @inheritDoc
     */
    public function process(File $phpcsFile, $stackPtr)
    {
        if (!isset($phpcsFile->getTokens()[$stackPtr + 1]['content'])) {
            return;
        }

        $content = $phpcsFile->getTokens()[$stackPtr + 1]['content'];

        if (!$this->isApplicable($content)) {
            return;
        }
        
        $paramsCount = $this->getParametersCount($phpcsFile, $stackPtr + 1);
        if ($content === self::CHILD_HTML_METHOD && $paramsCount >= 3) {
            $phpcsFile->addError(
                '3rd parameter is not needed anymore for getChildHtml()',
                $stackPtr,
                $this->errorCode
            );
        }
        if ($content === self::CHILD_CHILD_HTML_METHOD && $paramsCount >= 4) {
            $phpcsFile->addError(
                '4th parameter is not needed anymore for getChildChildHtml()',
                $stackPtr,
                $this->errorCode
            );
        }
    }

    /**
     * Return if it is applicable to do the check
     *
     * @param String $content
     * @return bool
     */
    private function isApplicable(String $content): bool
    {
        return in_array($content, [self::CHILD_HTML_METHOD, self::CHILD_CHILD_HTML_METHOD]);
    }

    /**
     * Get the quantity of parameters on a method
     *
     * @param File $phpcsFile
     * @param int $methodHtmlPosition
     * @return int
     */
    private function getParametersCount(File $phpcsFile, int $methodHtmlPosition): int
    {
        $closePosition = $phpcsFile->getTokens()[$methodHtmlPosition +1]['parenthesis_closer'];
        $getTokenAsContent = $phpcsFile->getTokensAsString(
            $methodHtmlPosition + 2,
            ($closePosition - $methodHtmlPosition) - 2
        );
        if ($getTokenAsContent) {
            $parameters = explode(',', $getTokenAsContent);
            return count($parameters);
        }
        return 0;
    }
}
