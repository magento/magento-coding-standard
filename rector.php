<?php

declare(strict_types=1);

use Rector\Core\Configuration\Option;
use Rector\Core\ValueObject\PhpVersion;
use Rector\Set\ValueObject\SetList;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    // get parameters
    $parameters = $containerConfigurator->parameters();
    $parameters->set(Option::PATHS, [
        __DIR__ . '/Magento2',
        __DIR__ . '/Magento2Framework',
        __DIR__ . '/PHP_CodeSniffer',
    ]);
    $parameters->set(Option::BOOTSTRAP_FILES, [__DIR__ . '/vendor/squizlabs/php_codesniffer/autoload.php']);

    $parameters->set(Option::PHP_VERSION_FEATURES, PhpVersion::PHP_80);
    $parameters->set(Option::PHP_VERSION_FEATURES, PhpVersion::PHP_81);

    // Define what rule sets will be applied
    $containerConfigurator->import(SetList::PHP_80);
    $containerConfigurator->import(SetList::PHP_81);

    // get services (needed for register a single rule)
    // $services = $containerConfigurator->services();

    // register a single rule
    // $services->set(TypedPropertyRector::class);
};
