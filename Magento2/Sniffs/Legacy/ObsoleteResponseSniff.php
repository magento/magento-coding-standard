<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types = 1);

namespace Magento2\Sniffs\Legacy;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

class ObsoleteResponseSniff implements Sniff
{
    private const WARNING_CODE_METHOD = 'FoundObsoleteResponseMethod';
    
    /**
     * @var string[]
     */
    private $obsoleteResponseMethods = [
        'loadLayout',
        'renderLayout',
        '_redirect',
        '_forward',
        '_setActiveMenu',
        '_addBreadcrumb',
        '_addContent',
        '_addLeft',
        '_addJs',
        '_moveBlockToContainer',
    ];
    
    /**
     * @inheritdoc
     */
    public function register()
    {
        return [
            T_OBJECT_OPERATOR,
            T_FUNCTION
        ];
    }
    
    /**
     * @inheritDoc
     */
    public function process(File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();
        $stringPos = $phpcsFile->findNext(T_STRING, $stackPtr + 1);

        foreach ($this->obsoleteResponseMethods as $method) {
            if ($tokens[$stringPos]['content'] === $method) {
                $phpcsFile->addWarning(
                    sprintf('Contains obsolete response method: %s.', $method),
                    $stackPtr,
                    self::WARNING_CODE_METHOD
                );
            }
        }
    }
}
