<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento2\Internal;

use PHP_CodeSniffer\Files\File;

/**
 * Proxy class for \PHP_CodeSniffer\Files\File
 *
 * @internal
 */
class FileProxy extends \PHP_CodeSniffer\Files\File
{
    private \PHP_CodeSniffer\Files\File $file;

    private array $proxies;

    /**
     * @param File $file
     * @param callable[] $proxies associative array of method name => callable. For example: ['addError' => fn() => {}]
     */
    public function __construct(\PHP_CodeSniffer\Files\File $file, array $proxies = [])
    {
        $this->file = $file;
        $this->proxies = $proxies;
        $this->fixer = $file->fixer;
        // parent constructor is not called intentionally
    }

    /**
     * @inheritdoc
     */
    public function setContent($content)
    {
        if (isset($this->proxies[__FUNCTION__])) {
            return ($this->proxies[__FUNCTION__])($content);
        }
        return $this->file->setContent($content);
    }

    /**
     * @inheritdoc
     */
    public function reloadContent()
    {
        if (isset($this->proxies[__FUNCTION__])) {
            ($this->proxies[__FUNCTION__])();
        }
        $this->file->reloadContent();
    }

    /**
     * @inheritdoc
     */
    public function disableCaching()
    {
        if (isset($this->proxies[__FUNCTION__])) {
            ($this->proxies[__FUNCTION__])();
        }
        $this->file->disableCaching();
    }

    /**
     * @inheritdoc
     */
    public function process()
    {
        if (isset($this->proxies[__FUNCTION__])) {
            return ($this->proxies[__FUNCTION__])();
        }
        return $this->file->process();
    }

    /**
     * @inheritdoc
     */
    public function parse()
    {
        if (isset($this->proxies[__FUNCTION__])) {
            return ($this->proxies[__FUNCTION__])();
        }
        return $this->file->parse();
    }

    /**
     * @inheritdoc
     */
    public function getTokens()
    {
        if (isset($this->proxies[__FUNCTION__])) {
            return ($this->proxies[__FUNCTION__])();
        }
        return $this->file->getTokens();
    }

    /**
     * @inheritdoc
     */
    public function cleanUp()
    {
        if (isset($this->proxies[__FUNCTION__])) {
            ($this->proxies[__FUNCTION__])();
        }
        $this->file->cleanUp();
    }

    /**
     * @inheritdoc
     */
    public function addError($error, $stackPtr, $code, $data = [], $severity = 0, $fixable = false)
    {
        if (isset($this->proxies[__FUNCTION__])) {
            return ($this->proxies[__FUNCTION__])($error, $stackPtr, $code, $data, $severity, $fixable);
        }
        return $this->file->addError($error, $stackPtr, $code, $data, $severity, $fixable);
    }

    /**
     * @inheritdoc
     */
    public function addWarning($warning, $stackPtr, $code, $data = [], $severity = 0, $fixable = false)
    {
        if (isset($this->proxies[__FUNCTION__])) {
            return ($this->proxies[__FUNCTION__])($warning, $stackPtr, $code, $data, $severity, $fixable);
        }
        return $this->file->addFixableWarning($warning, $stackPtr, $code, $data, $severity);
    }

    /**
     * @inheritdoc
     */
    public function addErrorOnLine($error, $line, $code, $data = [], $severity = 0)
    {
        if (isset($this->proxies[__FUNCTION__])) {
            return ($this->proxies[__FUNCTION__])($error, $line, $code, $data, $severity);
        }
        return $this->file->addErrorOnLine($error, $line, $code, $data, $severity);
    }

    /**
     * @inheritdoc
     */
    public function addWarningOnLine($warning, $line, $code, $data = [], $severity = 0)
    {
        if (isset($this->proxies[__FUNCTION__])) {
            return ($this->proxies[__FUNCTION__])($warning, $line, $code, $data, $severity);
        }
        return $this->file->addWarningOnLine($warning, $line, $code, $data, $severity);
    }

    /**
     * @inheritdoc
     */
    public function addFixableError($error, $stackPtr, $code, $data = [], $severity = 0)
    {
        if (isset($this->proxies[__FUNCTION__])) {
            return ($this->proxies[__FUNCTION__])($error, $stackPtr, $code, $data, $severity);
        }
        return $this->file->addFixableError($error, $stackPtr, $code, $data, $severity);
    }

    /**
     * @inheritdoc
     */
    public function addFixableWarning($warning, $stackPtr, $code, $data = [], $severity = 0)
    {
        if (isset($this->proxies[__FUNCTION__])) {
            return ($this->proxies[__FUNCTION__])($warning, $stackPtr, $code, $data, $severity);
        }
        return $this->file->addFixableWarning($warning, $stackPtr, $code, $data, $severity);
    }

    /**
     * @inheritdoc
     */
    public function recordMetric($stackPtr, $metric, $value)
    {
        if (isset($this->proxies[__FUNCTION__])) {
            return ($this->proxies[__FUNCTION__])($stackPtr, $metric, $value);
        }
        return $this->file->recordMetric($stackPtr, $metric, $value);
    }

    /**
     * @inheritdoc
     */
    public function getErrorCount()
    {
        if (isset($this->proxies[__FUNCTION__])) {
            return ($this->proxies[__FUNCTION__])();
        }
        return $this->file->getErrorCount();
    }

    /**
     * @inheritdoc
     */
    public function getWarningCount()
    {
        if (isset($this->proxies[__FUNCTION__])) {
            return ($this->proxies[__FUNCTION__])();
        }
        return $this->file->getWarningCount();
    }

    /**
     * @inheritdoc
     */
    public function getFixableCount()
    {
        if (isset($this->proxies[__FUNCTION__])) {
            return ($this->proxies[__FUNCTION__])();
        }
        return $this->file->getFixableCount();
    }

    /**
     * @inheritdoc
     */
    public function getFixedCount()
    {
        if (isset($this->proxies[__FUNCTION__])) {
            return ($this->proxies[__FUNCTION__])();
        }
        return $this->file->getFixedCount();
    }

    /**
     * @inheritdoc
     */
    public function getIgnoredLines()
    {
        if (isset($this->proxies[__FUNCTION__])) {
            return ($this->proxies[__FUNCTION__])();
        }
        return $this->file->getIgnoredLines();
    }

    /**
     * @inheritdoc
     */
    public function getErrors()
    {
        if (isset($this->proxies[__FUNCTION__])) {
            return ($this->proxies[__FUNCTION__])();
        }
        return $this->file->getErrors();
    }

    /**
     * @inheritdoc
     */
    public function getWarnings()
    {
        if (isset($this->proxies[__FUNCTION__])) {
            return ($this->proxies[__FUNCTION__])();
        }
        return $this->file->getWarnings();
    }

    /**
     * @inheritdoc
     */
    public function getMetrics()
    {
        if (isset($this->proxies[__FUNCTION__])) {
            return ($this->proxies[__FUNCTION__])();
        }
        return $this->file->getMetrics();
    }

    /**
     * @inheritdoc
     */
    public function getFilename()
    {
        if (isset($this->proxies[__FUNCTION__])) {
            return ($this->proxies[__FUNCTION__])();
        }
        return $this->file->getFilename();
    }

    /**
     * @inheritdoc
     */
    public function getDeclarationName($stackPtr)
    {
        if (isset($this->proxies[__FUNCTION__])) {
            return ($this->proxies[__FUNCTION__])($stackPtr);
        }
        return $this->file->getDeclarationName($stackPtr);
    }

    /**
     * @inheritdoc
     */
    public function getMethodParameters($stackPtr)
    {
        if (isset($this->proxies[__FUNCTION__])) {
            return ($this->proxies[__FUNCTION__])($stackPtr);
        }
        return $this->file->getMethodParameters($stackPtr);
    }

    /**
     * @inheritdoc
     */
    public function getMethodProperties($stackPtr)
    {
        if (isset($this->proxies[__FUNCTION__])) {
            return ($this->proxies[__FUNCTION__])($stackPtr);
        }
        return $this->file->getMethodProperties($stackPtr);
    }

    /**
     * @inheritdoc
     */
    public function getMemberProperties($stackPtr)
    {
        if (isset($this->proxies[__FUNCTION__])) {
            return ($this->proxies[__FUNCTION__])($stackPtr);
        }
        return $this->file->getMemberProperties($stackPtr);
    }

    /**
     * @inheritdoc
     */
    public function getClassProperties($stackPtr)
    {
        if (isset($this->proxies[__FUNCTION__])) {
            return ($this->proxies[__FUNCTION__])($stackPtr);
        }
        return $this->file->getClassProperties($stackPtr);
    }

    /**
     * @inheritdoc
     */
    public function isReference($stackPtr)
    {
        if (isset($this->proxies[__FUNCTION__])) {
            return ($this->proxies[__FUNCTION__])($stackPtr);
        }
        return $this->file->isReference($stackPtr);
    }

    /**
     * @inheritdoc
     */
    public function getTokensAsString($start, $length, $origContent = false)
    {
        if (isset($this->proxies[__FUNCTION__])) {
            return ($this->proxies[__FUNCTION__])($start, $length, $origContent);
        }
        return $this->file->getTokensAsString($start, $length, $origContent);
    }

    /**
     * @inheritdoc
     */
    public function findPrevious($types, $start, $end = null, $exclude = false, $value = null, $local = false)
    {
        if (isset($this->proxies[__FUNCTION__])) {
            return ($this->proxies[__FUNCTION__])($types, $start, $end, $exclude, $value, $local);
        }
        return $this->file->findPrevious($types, $start, $end, $exclude, $value, $local);
    }

    /**
     * @inheritdoc
     */
    public function findNext($types, $start, $end = null, $exclude = false, $value = null, $local = false)
    {
        if (isset($this->proxies[__FUNCTION__])) {
            return ($this->proxies[__FUNCTION__])($types, $start, $end, $exclude, $value, $local);
        }
        return $this->file->findNext($types, $start, $end, $exclude, $value, $local);
    }

    /**
     * @inheritdoc
     */
    public function findStartOfStatement($start, $ignore = null)
    {
        if (isset($this->proxies[__FUNCTION__])) {
            return ($this->proxies[__FUNCTION__])($start, $ignore);
        }
        return $this->file->findStartOfStatement($start, $ignore);
    }

    /**
     * @inheritdoc
     */
    public function findEndOfStatement($start, $ignore = null)
    {
        if (isset($this->proxies[__FUNCTION__])) {
            return ($this->proxies[__FUNCTION__])($start, $ignore);
        }
        return $this->file->findEndOfStatement($start, $ignore);
    }

    /**
     * @inheritdoc
     */
    public function findFirstOnLine($types, $start, $exclude = false, $value = null)
    {
        if (isset($this->proxies[__FUNCTION__])) {
            return ($this->proxies[__FUNCTION__])($types, $start, $exclude, $value);
        }
        return $this->file->findFirstOnLine($types, $start, $exclude, $value);
    }

    /**
     * @inheritdoc
     */
    public function hasCondition($stackPtr, $types)
    {
        if (isset($this->proxies[__FUNCTION__])) {
            return ($this->proxies[__FUNCTION__])($stackPtr, $types);
        }
        return $this->file->hasCondition($stackPtr, $types);
    }

    /**
     * @inheritdoc
     */
    public function getCondition($stackPtr, $type, $first = true)
    {
        if (isset($this->proxies[__FUNCTION__])) {
            return ($this->proxies[__FUNCTION__])($stackPtr, $type, $first);
        }
        return $this->file->getCondition($stackPtr, $type, $first);
    }

    /**
     * @inheritdoc
     */
    public function findExtendedClassName($stackPtr)
    {
        if (isset($this->proxies[__FUNCTION__])) {
            return ($this->proxies[__FUNCTION__])($stackPtr);
        }
        return $this->file->findExtendedClassName($stackPtr);
    }

    /**
     * @inheritdoc
     */
    /**
     * @inheritdoc
     */
    public function findImplementedInterfaceNames($stackPtr)
    {
        if (isset($this->proxies[__FUNCTION__])) {
            return ($this->proxies[__FUNCTION__])($stackPtr);
        }
        return $this->file->findImplementedInterfaceNames($stackPtr);
    }
}
