<?php
/**
 * Copyright 2026 Adobe
 * All Rights Reserved.
 */
declare(strict_types=1);

namespace Magento2\Helpers;

use Generator;
use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Files\LocalFile;
use PHPCSUtils\Utils\Namespaces;
use PHPCSUtils\Utils\ObjectDeclarations;
use PHPCSUtils\Utils\UseStatements;
use SplFileInfo;

/**
 * Resolves class names and parent classes of Adminhtml controllers.
 */
class AdminhtmlControllerResolver
{
    private const BACKEND_ACTIONS = [
        \Magento\Backend\App\Action::class,
        \Magento\Backend\App\AbstractAction::class,
    ];

    private const ACTION_ANCESTOR_PATTERN = '#\\\\Controller\\\\|Action[^\\\\]*$#i';

    private const ACTION_INTERFACE_PATTERN = '#ActionInterface$#i';

    private const CONTROLLER_PATH_PATTERN = '#[\\\\/]Controller[\\\\/]Adminhtml[\\\\/]#';

    private const MAGENTO_CONTROLLER_PATTERN = '#^Magento\\\\[^\\\\]+\\\\Controller\\\\Adminhtml\\\\#i';

    /**
     * @var File[]
     */
    private $parsedFiles = [];

    /**
     * Checks whether the file is located in an Adminhtml controller directory.
     *
     * @param string $path
     * @return bool
     */
    public function isControllerFile(string $path): bool
    {
        return preg_match(self::CONTROLLER_PATH_PATTERN, $path) === 1;
    }

    /**
     * Checks whether the class can be dispatched as a controller action.
     *
     * The class or one of its resolved ancestors declares execute() or implements an action interface,
     * or the first ancestor that cannot be resolved is a controller or action class.
     * A class without a parent must implement an action interface.
     *
     * @param File $file
     * @param int $classPtr
     * @return bool
     */
    public function isActionClass(File $file, int $classPtr): bool
    {
        if ($this->declaresAction($file, $classPtr)) {
            return true;
        }

        foreach ($this->getAncestors($file, $classPtr) as $className => $declaration) {
            if ($declaration === null) {
                return preg_match(self::ACTION_ANCESTOR_PATTERN, $className) === 1;
            }
            if ($this->declaresAction(...$declaration)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Resolves a class name used at the given position to a fully qualified name without the leading slash.
     *
     * @param File $file
     * @param int $stackPtr
     * @param string $name
     * @return string
     */
    public function resolveClassName(File $file, int $stackPtr, string $name): string
    {
        if (str_starts_with($name, '\\')) {
            return ltrim($name, '\\');
        }

        $namespace = Namespaces::determineNamespace($file, $stackPtr);
        if (stripos($name, 'namespace\\') === 0) {
            return ltrim($namespace . '\\' . substr($name, 10), '\\');
        }

        $parts = explode('\\', $name, 2);
        $imports = $this->getImports($file, $stackPtr);
        $alias = strtolower($parts[0]);
        if (isset($imports[$alias])) {
            return $imports[$alias] . (isset($parts[1]) ? '\\' . $parts[1] : '');
        }

        return ltrim($namespace . '\\' . $name, '\\');
    }

    /**
     * Returns the fully qualified name of the parent class or null when the class has no parent.
     *
     * @param File $file
     * @param int $classPtr
     * @return string|null
     */
    public function getParentClassName(File $file, int $classPtr): ?string
    {
        $parent = ObjectDeclarations::findExtendedClassName($file, $classPtr);

        return $parent === false ? null : $this->resolveClassName($file, $classPtr, $parent);
    }

    /**
     * Yields each ancestor class name with its declaration, or null when the declaration cannot be found.
     *
     * @param File $file
     * @param int $classPtr
     * @return Generator
     */
    public function getAncestors(File $file, int $classPtr): Generator
    {
        $visited = [];
        $parent = $this->getParentClassName($file, $classPtr);
        while ($parent !== null && !isset($visited[strtolower($parent)])) {
            $visited[strtolower($parent)] = true;
            $declaration = $this->findClassDeclaration($file, $classPtr, $parent);
            yield $parent => $declaration;
            if ($declaration === null) {
                return;
            }
            [$file, $classPtr] = $declaration;
            $parent = $this->getParentClassName($file, $classPtr);
        }
    }

    /**
     * Checks whether the class inherits from Magento\Backend\App\Action or Magento\Backend\App\AbstractAction.
     *
     * @param File $file
     * @param int $classPtr
     * @param string[] $allowedParentClasses
     * @return bool
     */
    public function extendsBackendAction(File $file, int $classPtr, array $allowedParentClasses): bool
    {
        foreach ($this->getAncestors($file, $classPtr) as $className => $declaration) {
            if ($this->isTrustedParent($className, $allowedParentClasses)) {
                return true;
            }
            if ($declaration === null) {
                return $this->isMagentoController($className);
            }
        }

        return false;
    }

    /**
     * Checks whether the class is a backend action or an allowed parent.
     *
     * @param string $className
     * @param string[] $allowedParentClasses
     * @return bool
     */
    public function isTrustedParent(string $className, array $allowedParentClasses): bool
    {
        if ($this->isBackendAction($className)) {
            return true;
        }

        foreach ($allowedParentClasses as $allowedParentClass) {
            if (strcasecmp($className, ltrim($allowedParentClass, '\\')) === 0) {
                return true;
            }
        }

        return false;
    }

    /**
     * Checks whether the class name is Magento\Backend\App\Action or Magento\Backend\App\AbstractAction.
     *
     * @param string $className
     * @return bool
     */
    public function isBackendAction(string $className): bool
    {
        foreach (self::BACKEND_ACTIONS as $backendAction) {
            if (strcasecmp($className, $backendAction) === 0) {
                return true;
            }
        }

        return false;
    }

    /**
     * Checks whether the class name is a Magento Adminhtml controller.
     *
     * @param string $className
     * @return bool
     */
    public function isMagentoController(string $className): bool
    {
        return preg_match(self::MAGENTO_CONTROLLER_PATTERN, $className) === 1;
    }

    /**
     * Returns the pointer of the import use statement declaring the alias in the namespace containing the position.
     *
     * @param File $file
     * @param int $stackPtr
     * @param string $alias
     * @return int|null
     */
    public function findImportUsePtr(File $file, int $stackPtr, string $alias): ?int
    {
        foreach ($this->getImportUsePointers($file, $stackPtr) as $usePtr) {
            $names = array_change_key_case(UseStatements::splitImportUseStatement($file, $usePtr)['name']);
            if (isset($names[strtolower($alias)])) {
                return $usePtr;
            }
        }

        return null;
    }

    /**
     * Checks whether the class implements an action interface or declares execute() and has a parent.
     *
     * @param File $file
     * @param int $classPtr
     * @return bool
     */
    private function declaresAction(File $file, int $classPtr): bool
    {
        if (ObjectDeclarations::findExtendedClassName($file, $classPtr) !== false
            && isset(array_change_key_case(ObjectDeclarations::getDeclaredMethods($file, $classPtr))['execute'])
        ) {
            return true;
        }

        foreach (ObjectDeclarations::findImplementedInterfaceNames($file, $classPtr) ?: [] as $interface) {
            if (preg_match(self::ACTION_INTERFACE_PATTERN, $interface) === 1) {
                return true;
            }
        }

        return false;
    }

    /**
     * Finds the class declaration in the same file or in the same module.
     *
     * @param File $file
     * @param int $stackPtr
     * @param string $className
     * @return array|null
     */
    private function findClassDeclaration(File $file, int $stackPtr, string $className): ?array
    {
        $classPtr = $this->findClassInFile($file, $className);
        if ($classPtr !== null) {
            return [$file, $classPtr];
        }

        $moduleFile = $this->findModuleFile($file, $stackPtr, $className);
        if ($moduleFile === null) {
            return null;
        }

        $classPtr = $this->findClassInFile($moduleFile, $className);

        return $classPtr === null ? null : [$moduleFile, $classPtr];
    }

    /**
     * Finds the class declaration pointer in the file.
     *
     * @param File $file
     * @param string $className
     * @return int|null
     */
    private function findClassInFile(File $file, string $className): ?int
    {
        $classPtr = $file->findNext(T_CLASS, 0);
        while ($classPtr !== false) {
            $name = ObjectDeclarations::getName($file, $classPtr);
            if ($name !== null) {
                $declaredName = ltrim(Namespaces::determineNamespace($file, $classPtr) . '\\' . $name, '\\');
                if (strcasecmp($declaredName, $className) === 0) {
                    return $classPtr;
                }
            }
            $classPtr = $file->findNext(T_CLASS, $classPtr + 1);
        }

        return null;
    }

    /**
     * Locates and parses the class file in the same module using the namespace to directory mapping of the file.
     *
     * @param File $file
     * @param int $stackPtr
     * @param string $className
     * @return File|null
     */
    private function findModuleFile(File $file, int $stackPtr, string $className): ?File
    {
        $namespaceParts = explode('\\', Namespaces::determineNamespace($file, $stackPtr));
        $directoryParts = explode('/', str_replace('\\', '/', $file->getFilename()));
        array_pop($directoryParts);
        while ($namespaceParts !== [] && end($namespaceParts) === end($directoryParts)) {
            array_pop($namespaceParts);
            array_pop($directoryParts);
        }

        $prefix = implode('\\', $namespaceParts);
        if ($prefix !== '' && stripos($className, $prefix . '\\') !== 0) {
            return null;
        }

        $relativeName = $prefix === '' ? $className : substr($className, strlen($prefix) + 1);
        $extension = (new SplFileInfo($file->getFilename()))->getExtension();
        $path = implode('/', $directoryParts) . '/' . str_replace('\\', '/', $relativeName) . '.' . $extension;
        if (!isset($this->parsedFiles[$path])) {
            if (!(new SplFileInfo($path))->isFile()) {
                return null;
            }
            $this->parsedFiles[$path] = new LocalFile($path, $file->ruleset, $file->config);
            $this->parsedFiles[$path]->parse();
        }

        return $this->parsedFiles[$path];
    }

    /**
     * Returns class imports of the namespace containing the position, keyed by lowercase alias.
     *
     * @param File $file
     * @param int $stackPtr
     * @return string[]
     */
    private function getImports(File $file, int $stackPtr): array
    {
        $imports = [];
        foreach ($this->getImportUsePointers($file, $stackPtr) as $usePtr) {
            $names = UseStatements::splitImportUseStatement($file, $usePtr)['name'];
            $imports += array_change_key_case($names);
        }

        return $imports;
    }

    /**
     * Yields pointers of import use statements located before the position in the same namespace.
     *
     * @param File $file
     * @param int $stackPtr
     * @return Generator
     */
    private function getImportUsePointers(File $file, int $stackPtr): Generator
    {
        $namespacePtr = Namespaces::findNamespacePtr($file, $stackPtr);
        $usePtr = $file->findNext(T_USE, 0, $stackPtr);
        while ($usePtr !== false) {
            if (UseStatements::isImportUse($file, $usePtr)
                && Namespaces::findNamespacePtr($file, $usePtr) === $namespacePtr
            ) {
                yield $usePtr;
            }
            $usePtr = $file->findNext(T_USE, $usePtr + 1, $stackPtr);
        }
    }
}
