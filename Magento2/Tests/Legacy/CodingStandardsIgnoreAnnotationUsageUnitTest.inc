<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

// @codingStandardsIgnoreFile
class Sample
{
    /**
     * @var int
     */
    private $randomNumber;

    /**
     * @throws Exception
     */
    public function __construct() {
        $this->randomNumber = random_int(0, 999);
    }

    /**
     * @return int
     */
    public function getRandomNumber(): int
    {
        return $this->randomNumber;
    }

    /**
     * @param int $randomNumber
     */
    public function setRandomNumber(int $randomNumber): void
    {
        $this->randomNumber = $randomNumber;
    }
}
