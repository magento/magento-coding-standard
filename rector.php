<?php

declare(strict_types=1);

use Rector\Core\Configuration\Option;
use Rector\Core\ValueObject\PhpVersion;
use Rector\Php80\Rector\Class_\StringableForToStringRector;
use Rector\Php80\Rector\ClassMethod\FinalPrivateToPrivateVisibilityRector;
use Rector\Php80\Rector\ClassMethod\OptionalParametersAfterRequiredRector;
use Rector\Php80\Rector\ClassMethod\SetStateToStaticRector;
use Rector\Php81\Rector\FuncCall\Php81ResourceReturnToObjectRector;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    // get parameters
    $parameters = $containerConfigurator->parameters();

    $parameters->set(Option::PHP_VERSION_FEATURES, PhpVersion::PHP_80);
    $parameters->set(Option::PHP_VERSION_FEATURES, PhpVersion::PHP_81);

    // get services (needed for register a single rule)
    $services = $containerConfigurator->services();

    // register a single rule
    $services->set(FinalPrivateToPrivateVisibilityRector::class);
    $services->set(OptionalParametersAfterRequiredRector::class);
    $services->set(SetStateToStaticRector::class);
    $services->set(StringableForToStringRector::class);
    $services->set(Php81ResourceReturnToObjectRector::class);
};
