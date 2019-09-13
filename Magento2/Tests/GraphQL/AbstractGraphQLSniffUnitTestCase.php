<?php
/**
 * Copyright © Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento2\Tests\GraphQL;

use PHP_CodeSniffer\Config;
use PHP_CodeSniffer\Tests\Standards\AbstractSniffUnitTest;

/**
 * Implements an abstract base for unit tests that cover GraphQL sniffs.
 */
abstract class AbstractGraphQLSniffUnitTestCase extends AbstractSniffUnitTest
{
    protected function setUp()
    {
        //let parent do its job
        parent::setUp();

        //generate a config that allows ro use our GraphQL tokenizer
        $config = new Config();
        $config->extensions = array_merge(
            $config->extensions,
            [
                'graphqls' => 'GRAPHQL'
            ]
        );

        //and write back to a global that is used in base class
        $GLOBALS['PHP_CODESNIFFER_CONFIG'] = $config;
    }
}
