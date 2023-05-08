<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento2\Sniffs\PHPCompatibility;

use Magento2\Helpers\Commenting\PHPDocFormattingValidator;
use Magento2\Internal\Cache;
use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Util\Tokens;
use PHPCSUtils\Utils\Conditions;
use PHPCSUtils\Utils\FunctionDeclarations;
use PHPCSUtils\Utils\Namespaces;
use PHPCSUtils\Utils\ObjectDeclarations;
use PHPCSUtils\Utils\Scopes;
use PHPCSUtils\Utils\UseStatements;

/**
 * Detects usage of dynamic properties in classes
 */
class DeprecatedDynamicPropertySniff extends \PHPCompatibility\Sniff
{
    /**
     * @var PHPDocFormattingValidator
     */
    private PHPDocFormattingValidator $phpDocFormattingValidator;

    /**
     * List of tags that declare a magic property.
     *
     * @var string[]
     */
    private array $magicPropertyTags = [
        '@property',
        '@property-read',
        '@property-write',
    ];

    /**
     * Constructor for this sniff.
     */
    public function __construct()
    {
        $this->phpDocFormattingValidator = new PHPDocFormattingValidator();
    }

    /**
     * @inheritdoc
     */
    public function register()
    {
        return [
            \T_OBJECT_OPERATOR,
            \T_NULLSAFE_OBJECT_OPERATOR
        ];
    }

    /**
     * @inheritdoc
     */
    public function process(File $phpcsFile, $stackPtr)
    {
        if (!$this->supportsAbove('8.2')) {
            return;
        }

        $tokens = $phpcsFile->getTokens();

        // Check if pointer is inside a class.
        $classPtr = Conditions::getLastCondition($phpcsFile, $stackPtr, [\T_CLASS]);
        if ($classPtr === false) {
            return;
        }

        // Check if it is string.
        $propertyNamePtr = $phpcsFile->findNext(Tokens::$emptyTokens, $stackPtr + 1, null, true);
        if ($propertyNamePtr === false || $tokens[$propertyNamePtr]['code'] !== \T_STRING) {
            return;
        }

        $afterPropertyNamePtr = $phpcsFile->findNext(Tokens::$emptyTokens, ($propertyNamePtr + 1), null, true);
        // Check if it is not a method call.
        if ($tokens[$afterPropertyNamePtr]['code'] === \T_OPEN_PARENTHESIS) {
            return;
        }

        // Check if it is a property access on $this.
        $thisPtr = $phpcsFile->findPrevious(Tokens::$emptyTokens, $stackPtr - 1, null, true);
        if ($thisPtr === false
            || $tokens[$thisPtr]['code'] !== \T_VARIABLE
            || $tokens[$thisPtr]['content'] !== '$this'
        ) {
            return;
        }

        // Check if it is a direct property access.
        $beforeThisPtr = $phpcsFile->findPrevious(Tokens::$emptyTokens, $thisPtr - 1, null, true);
        if ($beforeThisPtr &&
            \in_array(
                $tokens[$beforeThisPtr]['code'],
                [\T_OBJECT_OPERATOR, \T_NULLSAFE_OBJECT_OPERATOR, \T_DOUBLE_COLON]
            )
        ) {
            return;
        }

        $propertyName = $tokens[$propertyNamePtr]['content'];
        if (\in_array($propertyName, $this->getClassDeclaredProperties($phpcsFile, $classPtr), true)
            || \in_array($propertyName, $this->getClassPromotedProperties($phpcsFile, $classPtr), true)
            || \in_array($propertyName, $this->getClassMagicProperties($phpcsFile, $classPtr), true)
        ) {
            return;
        }

        $className = ObjectDeclarations::getName($phpcsFile, $classPtr);
        $namespace = Namespaces::determineNamespace($phpcsFile, $classPtr);
        if ($namespace !== '') {
            $className = $namespace . '\\' . $className;
        }
        $isPropertyInherited = true;
        try {
            // Try to autoload the class and check if the property is inherited.
            if (\class_exists($className)) {
                $isPropertyInherited = \property_exists($className, $propertyName);
            }
        } catch (\Throwable $e) {
            unset($e);
            // Ignore any errors that may occur during autoloading.
        }
        if ($isPropertyInherited === false ||
            !$this->isClassUsingTraits($phpcsFile, $classPtr)
            && ObjectDeclarations::findExtendedClassName($phpcsFile, $classPtr) === false
        ) {
            $error = 'Access to an undefined property %s::$%s;' .
                ' Creation of dynamic property is deprecated since PHP 8.2';
            $data = [$className, $propertyName];
            $phpcsFile->addWarning($error, $propertyNamePtr, 'Deprecated', $data);
        }
    }

    /**
     * Get properties declared in the scope class
     *
     * @param File $phpcsFile
     * @param int $stackPtr
     * @return string[]
     */
    private function getClassDeclaredProperties(File $phpcsFile, int $stackPtr): array
    {
        if (Cache::isCached($phpcsFile, __METHOD__, $stackPtr) === true) {
            return Cache::get($phpcsFile, __METHOD__, $stackPtr);
        }
        $tokens = $phpcsFile->getTokens();
        $properties = [];
        $next = $stackPtr;
        while ($next = $this->findInClass($phpcsFile, $stackPtr, $next + 1, \T_VARIABLE)) {
            if (Scopes::isOOProperty($phpcsFile, $next) !== false) {
                $properties[] = \ltrim($tokens[$next]['content'], '$');
            }
        }
        Cache::set($phpcsFile, __METHOD__, $stackPtr, $properties);
        return $properties;
    }

    /**
     * Get properties declared in the constructor method
     *
     * @param File $phpcsFile
     * @param int $stackPtr
     * @return string[]
     */
    private function getClassPromotedProperties(File $phpcsFile, int $stackPtr): array
    {
        if (Cache::isCached($phpcsFile, __METHOD__, $stackPtr) === true) {
            return Cache::get($phpcsFile, __METHOD__, $stackPtr);
        }
        $properties = [];
        $next = $stackPtr;
        while ($next = $this->findInClass($phpcsFile, $stackPtr, $next + 1, \T_FUNCTION)) {
            if (Scopes::isOOMethod($phpcsFile, $next)
                && \strtolower(FunctionDeclarations::getName($phpcsFile, $next)) === '__construct'
            ) {
                $params = FunctionDeclarations::getParameters($phpcsFile, $next);
                foreach ($params as $param) {
                    if (isset($param['property_visibility']) === true) {
                        $properties[] = \ltrim($param['name'], '$');
                    }
                }
                break;
            }
        }
        Cache::set($phpcsFile, __METHOD__, $stackPtr, $properties);
        return $properties;
    }

    /**
     * Find magic properties declared in the class PHPDoc
     *
     * @param File $phpcsFile
     * @param int $stackPtr
     * @return string[]
     */
    public function getClassMagicProperties(File $phpcsFile, int $stackPtr): array
    {
        if (Cache::isCached($phpcsFile, __METHOD__, $stackPtr) === true) {
            return Cache::get($phpcsFile, __METHOD__, $stackPtr);
        }
        $properties = [];
        $tokens = $phpcsFile->getTokens();
        $commentStartPtr = $this->phpDocFormattingValidator->findPHPDoc($stackPtr, $phpcsFile);
        if ($commentStartPtr === -1) {
            return [];
        }
        foreach ($tokens[$commentStartPtr]['comment_tags'] as $tag) {
            $token = $tokens[$tag];
            if (!\in_array($token['content'], $this->magicPropertyTags, true)
                || $tokens[($tag + 2)]['code'] !== \T_DOC_COMMENT_STRING
            ) {
                continue;
            }
            $commentParts = \preg_split('/\s+/', (string)$tokens[($tag + 2)]['content'], 3);
            if (\strpos($commentParts[0], '$') === 0) {
                $properties[] = \ltrim($commentParts[0], '$');
            } elseif (isset($commentParts[1])) {
                $properties[] = \ltrim($commentParts[1], '$');
            }
        }
        Cache::set($phpcsFile, __METHOD__, $stackPtr, $properties);
        return $properties;
    }

    /**
     * Check if class uses traits
     *
     * @param File $phpcsFile
     * @param int $stackPtr
     * @return bool
     */
    private function isClassUsingTraits(File $phpcsFile, int $stackPtr): bool
    {
        if (Cache::isCached($phpcsFile, __METHOD__, $stackPtr) === true) {
            return Cache::get($phpcsFile, __METHOD__, $stackPtr);
        }
        $usesTraits = false;
        $next = $stackPtr;
        while ($next = $this->findInClass($phpcsFile, $stackPtr, $next + 1, \T_USE)) {
            if (UseStatements::isTraitUse($phpcsFile, $next) === true) {
                $usesTraits = true;
                break;
            }
        }
        Cache::set($phpcsFile, __METHOD__, $stackPtr, $usesTraits);
        return $usesTraits;
    }

    /**
     * Find token in class scope
     *
     * @param File $phpcsFile
     * @param int $classPtr
     * @param int $currentPtr
     * @param array|int|string $needle
     * @return int|false
     */
    private function findInClass(File $phpcsFile, int $classPtr, int $currentPtr, $needle)
    {
        $tokens = $phpcsFile->getTokens();
        $classScopeEnd = $tokens[$classPtr]['scope_closer'];
        $classScopeStart = $tokens[$classPtr]['scope_opener'];
        return $phpcsFile->findNext($needle, \max($currentPtr, $classScopeStart), $classScopeEnd);
    }
}
