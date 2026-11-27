<?php
/**
 * Copyright 2026 Adobe
 * All Rights Reserved.
 */
declare(strict_types=1);

namespace Magento2\Sniffs\Security;

use Magento2\Helpers\AdminhtmlControllerResolver;
use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

/**
 * Detects Adminhtml controllers that do not inherit from Magento\Backend\App\Action.
 */
class AdminhtmlControllerAuthorizationSniff implements Sniff
{
    private const MISSING_PARENT_MESSAGE =
        'Adminhtml controllers must extend Magento\Backend\App\Action or a class derived from it.';

    private const INVALID_PARENT_MESSAGE =
        'Adminhtml controller must inherit from Magento\Backend\App\Action. Found: %s.';

    /**
     * Parent classes trusted to inherit from Magento\Backend\App\Action.
     *
     * @var string[]
     */
    public $allowedParentClasses = [];

    /**
     * @var AdminhtmlControllerResolver
     */
    private $resolver;

    /**
     * Initialize the controller resolver.
     */
    public function __construct()
    {
        $this->resolver = new AdminhtmlControllerResolver();
    }

    /**
     * @inheritdoc
     */
    public function register()
    {
        return [T_CLASS];
    }

    /**
     * @inheritdoc
     */
    public function process(File $phpcsFile, $stackPtr)
    {
        if (!$this->resolver->isControllerFile($phpcsFile->getFilename())
            || !$this->resolver->isActionClass($phpcsFile, $stackPtr)
        ) {
            return;
        }

        $parent = $this->resolver->getParentClassName($phpcsFile, $stackPtr);
        if ($parent === null) {
            $phpcsFile->addError(self::MISSING_PARENT_MESSAGE, $stackPtr, 'MissingParent');
            return;
        }

        if (!$this->resolver->extendsBackendAction($phpcsFile, $stackPtr, $this->allowedParentClasses)) {
            $phpcsFile->addError(self::INVALID_PARENT_MESSAGE, $stackPtr, 'InvalidParent', [$parent]);
        }
    }
}
