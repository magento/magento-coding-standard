<?php
/**
 * Copyright © Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magento\Sniffs\Functions;

use PHP_CodeSniffer\Sniffs\Sniff;
use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Util\Tokens;

/**
 * Detects getter that change the state of an object.
 */
class GetterStateSniff implements Sniff
{

    /**
     * String representation of warning.
     *
     * @var string
     */
    protected $warningMessage = 'Getters SHOULD NOT change the state of an object.';

    /**
     * Warning violation code.
     *
     * @var string
     */
    protected $warningCode = 'GetterState';

    /**
     * @inheritDoc
     */
    public function register()
    {
        return [T_FUNCTION];
    }

    /**
     * @inheritDoc
     */
    public function process(File $phpcsFile, $stackPtr)
    {
        $methodName = $phpcsFile->getDeclarationName($stackPtr);

        if ($methodName === null || strpos($methodName, 'get') !== 0) {
            // Ignore closures and no getters
            return;
        }

        $tokens = $phpcsFile->getTokens();
        if (!isset($tokens[$stackPtr]['scope_closer'])) {
            // Probably an interface method no check
            return;
        }

        $open = $tokens[$stackPtr]['scope_opener'];
        $close = $tokens[$stackPtr]['scope_closer'];

        $isObjectScope = false;
        $isObjectScopeToken = [T_SELF => T_SELF, T_PARENT => T_PARENT, T_STATIC => T_STATIC];
        $thisScopeCloser = array_merge(Tokens::$bracketTokens,
            [T_SEMICOLON => T_SEMICOLON, T_COMMA => T_COMMA, T_COLON => T_COLON]);

        for ($i = ($open + 1); $i < $close; $i++) {
            $token = $tokens[$i];
            $code = $token['code'];

            if (array_key_exists($code, $thisScopeCloser)) {
                // Detect line end scope change to function scope.
                $isObjectScope = false;
            }

            if (array_key_exists($code, $isObjectScopeToken)) {
                $isObjectScope = true;
            }

            if ($token['content'] === '$this') {
                $isObjectScope = true;
            }

            $isRelevant = $isObjectScope === true && $code !== T_DOUBLE_ARROW;

            if ($isRelevant && array_key_exists($code, Tokens::$assignmentTokens)) {

                $isWrappedByIf = false;
                // Detect if the property warped by an if tag.
                $ifTag = $phpcsFile->findPrevious(T_IF, $i);
                if ($ifTag !== false) {
                    $open = $tokens[$ifTag]['scope_opener'];
                    $close = $tokens[$ifTag]['scope_closer'];
                    $isWrappedByIf = $open <= $i && $close >= $i;
                }

                if ($isWrappedByIf === false) {
                    $phpcsFile->addWarning($this->warningMessage, $i, $this->warningCode);
                }
            }
        }
    }
}