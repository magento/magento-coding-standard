<?php

declare(strict_types=1);

use Rector\Core\Configuration\Option;
use Rector\Core\ValueObject\PhpVersion;
use Rector\Php80\Rector\Catch_\RemoveUnusedVariableInCatchRector;
use Rector\Php80\Rector\FuncCall\ClassOnObjectRector;
use Rector\Php80\Rector\FuncCall\Php8ResourceReturnToObjectRector;
use Rector\Php80\Rector\FuncCall\TokenGetAllToObjectRector;
use Rector\Php80\Rector\FunctionLike\UnionTypesRector;
use Rector\Php80\Rector\Identical\StrEndsWithRector;
use Rector\Php80\Rector\Identical\StrStartsWithRector;
use Rector\Php80\Rector\NotIdentical\StrContainsRector;
use Rector\Php80\Rector\Switch_\ChangeSwitchToMatchRector;
use Rector\Php80\Rector\Ternary\GetDebugTypeRector;
use Rector\Php81\Rector\Class_\MyCLabsClassToEnumRector;
use Rector\Php81\Rector\Class_\SpatieEnumClassToEnumRector;
use Rector\Php81\Rector\ClassConst\FinalizePublicClassConstantRector;
use Rector\Php81\Rector\ClassMethod\NewInInitializerRector;
use Rector\Php81\Rector\FunctionLike\IntersectionTypesRector;
use Rector\Php81\Rector\MethodCall\MyCLabsMethodCallToEnumConstRector;
use Rector\Php81\Rector\Property\ReadOnlyPropertyRector;
use Rector\Set\ValueObject\SetList;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    // get parameters
    $parameters = $containerConfigurator->parameters();
    $parameters->set(Option::PATHS, [
        __DIR__ . '/Magento2',
        __DIR__ . '/Magento2Framework',
        __DIR__ . '/PHP_CodeSniffer'
    ]);
    $parameters->set(Option::BOOTSTRAP_FILES, [__DIR__ . '/vendor/squizlabs/php_codesniffer/autoload.php']);

    $parameters->set(Option::PHP_VERSION_FEATURES, PhpVersion::PHP_80);
    $parameters->set(Option::PHP_VERSION_FEATURES, PhpVersion::PHP_81);
    
    $parameters->set(Option::SKIP, [
        ReadOnlyPropertyRector::class, 
        StrContainsRector::class,
        UnionTypesRector::class,
        StrStartsWithRector::class,
        StrEndsWithRector::class,
        FinalizePublicClassConstantRector::class,
        RemoveUnusedVariableInCatchRector::class,
        ClassOnObjectRector::class,
        Php8ResourceReturnToObjectRector::class,
        TokenGetAllToObjectRector::class,
        GetDebugTypeRector::class,
        ChangeSwitchToMatchRector::class,
        NewInInitializerRector::class,
        IntersectionTypesRector::class,
        MyCLabsMethodCallToEnumConstRector::class,
        MyCLabsClassToEnumRector::class,
        SpatieEnumClassToEnumRector::class
    ]);

    // Define what rule sets will be applied
    $containerConfigurator->import(SetList::PHP_80);
    $containerConfigurator->import(SetList::PHP_81);

    // get services (needed for register a single rule)
    // $services = $containerConfigurator->services();

    // register a single rule
    // $services->set(TypedPropertyRector::class);
};
