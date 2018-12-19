<?php

namespace Magento\Backend\Block\Widget\Grid\Column\Renderer;

use \Magento\Framework\Stdlib\DateTime\TimezoneInterface;

class Test
{
    protected $localeDate;

    public function __construct(

        \Magento\Framework\Stdlib\DateTime\TimezoneInterface $localeDate

    ) {
        $this->localeDate = $localeDate;
    }

    public function getDate()
    {
        return new \DateTime();
    }

    public function getTimeZone()
    {
        return new \DateTimeZone();
    }

    public function getTimeZoneInterfase()
    {
        return $this->localeDate->date();
    }
}
