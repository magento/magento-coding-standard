<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magento2\Internal;

use PHP_CodeSniffer\Files\File;

/**
 * Wrapper for \PHPCSUtils\Internal\Cache
 *
 * @see \PHPCSUtils\Internal\Cache
 * @internal
 */
final class Cache
{
    /**
     * Wrapper for \PHPCSUtils\Internal\Cache::isCached() method.
     *
     * @param \PHP_CodeSniffer\Files\File $phpcsFile
     * @param string $key
     * @param int|string $id
     *
     * @return bool
     * @see \PHPCSUtils\Internal\Cache::isCached()
     */
    public static function isCached(File $phpcsFile, $key, $id)
    {
        return \PHPCSUtils\Internal\Cache::isCached($phpcsFile, $key, $id);
    }

    /**
     * Wrapper for \PHPCSUtils\Internal\Cache::get() method.
     *
     * @param \PHP_CodeSniffer\Files\File $phpcsFile
     * @param string $key
     * @param int|string $id
     *
     * @return mixed
     * @see \PHPCSUtils\Internal\Cache::get()
     */
    public static function get(File $phpcsFile, $key, $id)
    {
        return \PHPCSUtils\Internal\Cache::get($phpcsFile, $key, $id);
    }

    /**
     * Wrapper for \PHPCSUtils\Internal\Cache::getForFile() method.
     *
     * @param \PHP_CodeSniffer\Files\File $phpcsFile
     * @param string $key
     * @return array
     * @see \PHPCSUtils\Internal\Cache::getForFile()
     */
    public static function getForFile(File $phpcsFile, $key)
    {
        return \PHPCSUtils\Internal\Cache::getForFile($phpcsFile, $key);
    }

    /**
     * Wrapper for \PHPCSUtils\Internal\Cache::set() method.
     *
     * @param \PHP_CodeSniffer\Files\File $phpcsFile
     * @param string $key
     * @param int|string $id
     * @param mixed $value
     * @return void
     * @see \PHPCSUtils\Internal\Cache::set()
     */
    public static function set(File $phpcsFile, $key, $id, $value)
    {
        \PHPCSUtils\Internal\Cache::set($phpcsFile, $key, $id, $value);
    }

    /**
     * Wrapper for \PHPCSUtils\Internal\Cache::clear() method.
     *
     * @return void
     * @see \PHPCSUtils\Internal\Cache::clear()
     */
    public static function clear()
    {
        \PHPCSUtils\Internal\Cache::clear();
    }
}
