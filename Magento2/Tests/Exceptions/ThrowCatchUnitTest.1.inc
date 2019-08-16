<?php

// This file contains all false positive cases that were found with previous implementation
// Check  Exceptions MUST NOT handled in same function should fin nothing there

/**
 * @throws \Magento\Framework\Exception\LocalizedException
 */
function creatDir()
{
    try {
        // call internal code that throw an Exception
        throw new \Magento\Framework\Exception\LocalizedException('Nice user friendly message');
    }
    catch (\Magento\Framework\Exception\FileSystemException $e) {
        throw new \Magento\Framework\Exception\LocalizedException('Nice user friendly message');
    }
}
