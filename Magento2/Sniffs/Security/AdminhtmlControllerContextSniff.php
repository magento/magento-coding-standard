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
use PHPCSUtils\Utils\PassedParameters;
use PHPCSUtils\Utils\UseStatements;

/**
 * Detects Adminhtml controllers that inject a context other than Magento\Backend\App\Action\Context.
 */
class AdminhtmlControllerContextSniff implements Sniff
{
    private const BACKEND_CONTEXT = \Magento\Backend\App\Action\Context::class;

    private const FRAMEWORK_CONTEXT = \Magento\Framework\App\Action\Context::class;

    private const FRAMEWORK_CONTEXT_MESSAGE = 'Adminhtml controller must inject Magento\Backend\App\Action\Context'
        . ' instead of Magento\Framework\App\Action\Context.';

    private const INVALID_CONTEXT_MESSAGE = 'Adminhtml controller must pass Magento\Backend\App\Action\Context'
        . ' to the parent constructor. Found: %s.';

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

        $methods = array_change_key_case(ObjectDeclarations::getDeclaredMethods($phpcsFile, $stackPtr));
        if (!isset($methods['__construct'])) {
            return;
        }

        $passedArguments = $this->getParentConstructorArguments($phpcsFile, $methods['__construct']);
        foreach ($phpcsFile->getMethodParameters($methods['__construct']) as $parameter) {
            $type = ltrim($parameter['type_hint'], '?');
            if ($type === '' || strpbrk($type, '|&()') !== false) {
                continue;
            }

            $className = $this->resolver->resolveClassName($phpcsFile, $parameter['type_hint_token'], $type);
            $isPassed = in_array($parameter['name'], $passedArguments, true);
            if (strcasecmp($className, self::FRAMEWORK_CONTEXT) === 0) {
                $this->reportFrameworkContext($phpcsFile, $stackPtr, $parameter, $isPassed);
            } elseif ($isPassed
                && strcasecmp($className, self::BACKEND_CONTEXT) !== 0
                && strcasecmp(substr(strrchr('\\' . $className, '\\'), 1), 'Context') === 0
            ) {
                $phpcsFile->addError(
                    self::INVALID_CONTEXT_MESSAGE,
                    $parameter['type_hint_token'],
                    'InvalidContext',
                    [$className]
                );
            }
        }
    }

    /**
     * Returns variable names passed to the parent constructor.
     *
     * @param File $phpcsFile
     * @param int $constructorPtr
     * @return string[]
     */
    private function getParentConstructorArguments(File $phpcsFile, int $constructorPtr): array
    {
        $tokens = $phpcsFile->getTokens();
        if (!isset($tokens[$constructorPtr]['scope_opener'], $tokens[$constructorPtr]['scope_closer'])) {
            return [];
        }

        $closerPtr = $tokens[$constructorPtr]['scope_closer'];
        $parentPtr = $phpcsFile->findNext(T_PARENT, $tokens[$constructorPtr]['scope_opener'], $closerPtr);
        while ($parentPtr !== false) {
            $colonPtr = $phpcsFile->findNext(Tokens::$emptyTokens, $parentPtr + 1, null, true);
            $namePtr = $phpcsFile->findNext(Tokens::$emptyTokens, $colonPtr + 1, null, true);
            if ($tokens[$colonPtr]['code'] === T_DOUBLE_COLON
                && $tokens[$namePtr]['code'] === T_STRING
                && strtolower($tokens[$namePtr]['content']) === '__construct'
            ) {
                return array_column(PassedParameters::getParameters($phpcsFile, $namePtr), 'clean');
            }
            $parentPtr = $phpcsFile->findNext(T_PARENT, $parentPtr + 1, $closerPtr);
        }

        return [];
    }

    /**
     * Reports the framework context parameter and fixes it when the replacement is unambiguous.
     *
     * @param File $phpcsFile
     * @param int $classPtr
     * @param array $parameter
     * @param bool $isPassed
     * @return void
     */
    private function reportFrameworkContext(File $phpcsFile, int $classPtr, array $parameter, bool $isPassed): void
    {
        $parent = $this->resolver->getParentClassName($phpcsFile, $classPtr);
        $fix = $isPassed && $parent !== null && $this->resolver->isBackendAction($parent)
            ? $this->getFix($phpcsFile, $parameter)
            : null;

        if ($fix === null) {
            $phpcsFile->addError(self::FRAMEWORK_CONTEXT_MESSAGE, $parameter['type_hint_token'], 'FrameworkContext');
            return;
        }

        if ($phpcsFile->addFixableError(
            self::FRAMEWORK_CONTEXT_MESSAGE,
            $parameter['type_hint_token'],
            'FrameworkContext'
        )) {
            [$startPtr, $endPtr, $content] = $fix;
            $phpcsFile->fixer->beginChangeset();
            $phpcsFile->fixer->replaceToken($startPtr, $content);
            for ($i = $startPtr + 1; $i <= $endPtr; $i++) {
                $phpcsFile->fixer->replaceToken($i, '');
            }
            $phpcsFile->fixer->endChangeset();
        }
    }

    /**
     * Returns the token range and replacement for an unambiguous fix, or null when the fix is ambiguous.
     *
     * @param File $phpcsFile
     * @param array $parameter
     * @return array|null
     */
    private function getFix(File $phpcsFile, array $parameter): ?array
    {
        $tokens = $phpcsFile->getTokens();
        $typePtr = $parameter['type_hint_token'];
        if ($tokens[$typePtr]['code'] === T_NS_SEPARATOR) {
            return [$typePtr, $parameter['type_hint_end_token'], '\\' . self::BACKEND_CONTEXT];
        }

        if ($typePtr !== $parameter['type_hint_end_token']) {
            return null;
        }

        $alias = $tokens[$typePtr]['content'];
        $usePtr = $this->resolver->findImportUsePtr($phpcsFile, $typePtr, $alias);
        if ($usePtr === null) {
            return null;
        }

        $endPtr = $phpcsFile->findNext([T_SEMICOLON, T_CLOSE_TAG], $usePtr + 1);
        if ($phpcsFile->findNext([T_OPEN_USE_GROUP, T_COMMA], $usePtr + 1, $endPtr) !== false
            || count(UseStatements::splitImportUseStatement($phpcsFile, $usePtr)['name']) !== 1
            || $this->countReferences($phpcsFile, $alias, $endPtr) !== 1
        ) {
            return null;
        }

        $nameStartPtr = $phpcsFile->findNext(Tokens::$emptyTokens, $usePtr + 1, $endPtr, true);
        $nameEndPtr = $phpcsFile->findPrevious(
            Tokens::$emptyTokens,
            ($phpcsFile->findNext(T_AS, $usePtr + 1, $endPtr) ?: $endPtr) - 1,
            $usePtr,
            true
        );

        return [$nameStartPtr, $nameEndPtr, self::BACKEND_CONTEXT];
    }

    /**
     * Counts references to the alias after the import statement.
     *
     * @param File $phpcsFile
     * @param string $alias
     * @param int $startPtr
     * @return int
     */
    private function countReferences(File $phpcsFile, string $alias, int $startPtr): int
    {
        $count = 0;
        $tokens = $phpcsFile->getTokens();
        $stringPtr = $phpcsFile->findNext(T_STRING, $startPtr);
        while ($stringPtr !== false) {
            if (strcasecmp($tokens[$stringPtr]['content'], $alias) === 0) {
                $count++;
            }
            $stringPtr = $phpcsFile->findNext(T_STRING, $stringPtr + 1);
        }

        return $count;
    }
}
