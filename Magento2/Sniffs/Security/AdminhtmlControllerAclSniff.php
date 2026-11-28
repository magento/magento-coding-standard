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
use PHP_CodeSniffer\Util\Tokens;
use PHPCSUtils\Utils\ObjectDeclarations;

/**
 * Detects Adminhtml controllers that do not declare a non-empty ADMIN_RESOURCE constant.
 */
class AdminhtmlControllerAclSniff implements Sniff
{
    private const ADMIN_RESOURCE = 'ADMIN_RESOURCE';

    private const IS_ALLOWED_METHOD = '_isallowed';

    private const MISSING_MESSAGE = 'Adminhtml controller must declare a non-empty ADMIN_RESOURCE constant.';

    private const EMPTY_MESSAGE = 'ADMIN_RESOURCE constant of Adminhtml controller must not be empty.';

    /**
     * Parent classes trusted to declare the ADMIN_RESOURCE constant.
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
            || ObjectDeclarations::getClassProperties($phpcsFile, $stackPtr)['is_abstract']
            || !$this->resolver->isActionClass($phpcsFile, $stackPtr)
        ) {
            return;
        }

        $isProtected = $this->isProtected($phpcsFile, $stackPtr);
        if ($isProtected === false) {
            $phpcsFile->addError(self::EMPTY_MESSAGE, $stackPtr, 'EmptyAdminResource');
        } elseif ($isProtected === null) {
            $phpcsFile->addError(self::MISSING_MESSAGE, $stackPtr, 'MissingAdminResource');
        }
    }

    /**
     * Returns true when ACL is declared, false when ADMIN_RESOURCE is empty and null when ACL is missing.
     *
     * @param File $phpcsFile
     * @param int $classPtr
     * @return bool|null
     */
    private function isProtected(File $phpcsFile, int $classPtr): ?bool
    {
        $declared = $this->getDeclaredProtection($phpcsFile, $classPtr);
        if ($declared !== null) {
            return $declared;
        }

        foreach ($this->resolver->getAncestors($phpcsFile, $classPtr) as $className => $declaration) {
            if ($this->resolver->isBackendAction($className)) {
                return null;
            }
            if ($this->resolver->isTrustedParent($className, $this->allowedParentClasses)) {
                return true;
            }
            if ($declaration === null) {
                return $this->resolver->isMagentoController($className) ? true : null;
            }
            $declared = $this->getDeclaredProtection(...$declaration);
            if ($declared !== null) {
                return $declared;
            }
        }

        return null;
    }

    /**
     * Returns the ACL state declared directly in the class or null when nothing is declared.
     *
     * @param File $phpcsFile
     * @param int $classPtr
     * @return bool|null
     */
    private function getDeclaredProtection(File $phpcsFile, int $classPtr): ?bool
    {
        $methods = array_change_key_case(ObjectDeclarations::getDeclaredMethods($phpcsFile, $classPtr));
        if (isset($methods[self::IS_ALLOWED_METHOD])) {
            return true;
        }

        $constants = ObjectDeclarations::getDeclaredConstants($phpcsFile, $classPtr);
        if (!isset($constants[self::ADMIN_RESOURCE])) {
            return null;
        }

        $tokens = $phpcsFile->getTokens();
        $namePtr = $phpcsFile->findNext(T_STRING, $constants[self::ADMIN_RESOURCE], null, false, self::ADMIN_RESOURCE);
        $equalPtr = $phpcsFile->findNext(T_EQUAL, $namePtr);
        $valuePtr = $phpcsFile->findNext(Tokens::$emptyTokens, $equalPtr + 1, null, true);
        $afterValuePtr = $phpcsFile->findNext(Tokens::$emptyTokens, $valuePtr + 1, null, true);

        return !($tokens[$valuePtr]['code'] === T_CONSTANT_ENCAPSED_STRING
            && in_array($tokens[$afterValuePtr]['code'], [T_SEMICOLON, T_COMMA], true)
            && trim($tokens[$valuePtr]['content'], '\'"') === '');
    }
}
