<?php

use PHPCompatibility\PHPCSHelper;
use Magento2\PhpVersionFinder;

$phpVersionFinder  = new PhpVersionFinder();
PHPCSHelper::setConfigData('testVersion', $phpVersionFinder->getPhpVersion($this) , true);