<?php

use PHP_CodeSniffer\Tests\Standards\AbstractSniffUnitTest;

/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

/**
 * This is NOT actually a test, but a file that must be ignored by RestrictedCodeSniff
 * when doing its analysis, even if it contains restricted classes.
 * We need this file to have the exact expected path, even with the PHP extension that makes AbstractSniffUnitTest
 * to recognize this as an actual test file instead of a fixture.
 */
class IteratorDummyFile extends AbstractSniffUnitTest
{
    protected function shouldSkipTest()
    {
        return true;
    }

    protected function getErrorList() {
        return [];
    }

    protected function getWarningList() {
        return [];
    }

    private function withProtectedClass() {
        return new \Zend_Db_Expr();
    }
}
