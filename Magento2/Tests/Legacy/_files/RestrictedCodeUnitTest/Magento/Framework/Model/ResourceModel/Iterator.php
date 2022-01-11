<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento2\Tests\Legacy\_files\RestrictedCodeUnitTest\Magento\Framework\Model\ResourceModel;

use PHP_CodeSniffer\Tests\Standards\AbstractSniffUnitTest;

/**
 * This is NOT actually a test, but a file that must be ignored by RestrictedCodeSniff
 * when doing its analysis, even if it contains restricted classes.
 * We need this file to have the exact expected path, even with the PHP extension that makes AbstractSniffUnitTest
 * to recognize this as an actual test file instead of a fixture.
 */
class IteratorDummyFile extends AbstractSniffUnitTest
{
    protected function shouldSkipTest(): bool
    {
        return true;
    }

    protected function getErrorList(): array
    {
        return [];
    }

    protected function getWarningList(): array
    {
        return [];
    }

    private function withProtectedClass(): Zend_Db_Expr
    {
        return new \Zend_Db_Expr();
    }
}
