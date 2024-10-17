<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento2Framework\Tests\Header;

use Magento2\Tests\GraphQL\AbstractGraphQLSniffUnitTestCase;

class CopyrightGraphQLUnitTest extends AbstractGraphQLSniffUnitTestCase
{
  /**
   * @inheritdoc
   */
    public function getErrorList(): array
    {
        return [];
    }

  /**
   * @inheritdoc
   */
    public function getWarningList($testFile = ''): array
    {
        if ($testFile === 'CopyrightGraphQLUnitTest.1.graphqls' ||
        $testFile === 'CopyrightGraphQLUnitTest.2.graphqls') {
            return [];
        }

        if ($testFile === 'CopyrightGraphQLUnitTest.3.graphqls' ||
        $testFile === 'CopyrightGraphQLUnitTest.4.graphqls') {
            return [
            null => 1
            ];
        }

        return [];
    }
}
