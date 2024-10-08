<?php
/**
 * Copyright 2024 Adobe
 * All Rights Reserved.
 */
declare(strict_types = 1);

namespace Magento2Framework\Sniffs\Header;

trait CopyrightValidation
{

  /**
   * Check if copyright content/year valid or not
   *
   * @param string $content
   * @return bool
   */
    private function isCopyrightYearValid(string $content): bool
    {
        $pattern = '/Copyright (\d{4}) Adobe/';
        if (preg_match($pattern, $content, $matches)) {
            $year = (int) $matches[1];
            if ($year >= 2010 && $year <= date("Y")) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}
