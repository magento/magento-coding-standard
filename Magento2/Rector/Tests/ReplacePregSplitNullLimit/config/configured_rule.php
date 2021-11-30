<?php

declare(strict_types=1);

use Magento2\Rector\Src\ReplacePregSplitNullLimit;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();
    $services->set(ReplacePregSplitNullLimit::class);
};