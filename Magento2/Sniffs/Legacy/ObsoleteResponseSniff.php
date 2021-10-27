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
    /**
     * @var string[]
     */
    private $obsoleteResponseMethods = [
        'loadLayout' => 'Please use \Magento\Framework\View\Layout\Builder::build instead.',
        'renderLayout' => 'Please use \Magento\Framework\Controller\ResultInterface::renderResult instead.',
        '_redirect' => 'Please use \Magento\Backend\Model\View\Result\Redirect::render instead.',
        '_forward' => 'Please use \Magento\Backend\Model\View\Result\Forward::forward instead.',
        '_setActiveMenu' => 'Please use \Magento\Backend\Model\View\Result\Page::setActiveMenu instead.',
        '_addBreadcrumb' => 'Please use \Magento\Backend\Model\View\Result\Page::addBreadcrumb instead.',
        '_addContent' => 'Please use \Magento\Backend\Model\View\Result\Page::addContent instead.',
        '_addLeft' => 'Please use \Magento\Backend\Model\View\Result\Page::addLeft instead.',
        '_addJs' => 'Please use \Magento\Backend\Model\View\Result\Page::addJs instead.',
        '_moveBlockToContainer' => 'Please use \Magento\Backend\Model\View\Result\Page::moveBlockToContainer instead.',
    ];

    /**
     * @var string[]
     */
    private $obsoleteResponseWarningCodes = [
        'loadLayout' => 'LoadLayoutResponseMethodFound',
        'renderLayout' => 'RenderLayoutResponseMethodFound',
        '_redirect' => 'RedirectResponseMethodFound',
        '_forward' => 'ForwardResponseMethodFound',
        '_setActiveMenu' => 'SetActiveMenuResponseMethodFound',
        '_addBreadcrumb' => 'AddBreadcrumbResponseMethodFound',
        '_addContent' => 'AddContentResponseMethodFound',
        '_addLeft' => 'AddLeftResponseMethodFound',
        '_addJs' => 'AddJsResponseMethodFound',
        '_moveBlockToContainer' => 'MoveBlockToContainerResponseMethodFound',
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

        foreach ($this->obsoleteResponseMethods as $method => $errorMessage) {
            if ($tokens[$stringPos]['content'] === $method) {
                $phpcsFile->addWarning(
                    sprintf('%s method is deprecated. %s', $method, $errorMessage),
                    $stackPtr,
                    $this->obsoleteResponseWarningCodes[$method]
                );
            }
        }
    }
}
