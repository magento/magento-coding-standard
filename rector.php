<?php

declare(strict_types=1);

use Magento2\Rector\Src\ReplaceMbStrposNullLimit;
use Magento2\Rector\Src\ReplaceNewDateTimeNull;
use Rector\Config\RectorConfig;
use Rector\ValueObject\PhpVersion;
use Rector\Php80\Rector\Class_\StringableForToStringRector;
use Rector\Php80\Rector\ClassMethod\FinalPrivateToPrivateVisibilityRector;
use Rector\CodeQuality\Rector\ClassMethod\OptionalParametersAfterRequiredRector;
use Rector\Php80\Rector\ClassMethod\SetStateToStaticRector;
use Rector\Php81\Rector\FuncCall\Php81ResourceReturnToObjectRector;
use Magento2\Rector\Src\ReplacePregSplitNullLimit;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->phpVersion(PhpVersion::PHP_80);
    $rectorConfig->phpVersion(PhpVersion::PHP_81);

    // register a single rule
    $rectorConfig->singleton(FinalPrivateToPrivateVisibilityRector::class);
    $rectorConfig->singleton(OptionalParametersAfterRequiredRector::class);
    $rectorConfig->singleton(SetStateToStaticRector::class);
    $rectorConfig->singleton(StringableForToStringRector::class);
    $rectorConfig->singleton(Php81ResourceReturnToObjectRector::class);
    $rectorConfig->singleton(ReplacePregSplitNullLimit::class);
    $rectorConfig->singleton(ReplaceMbStrposNullLimit::class);
    $rectorConfig->singleton(ReplaceNewDateTimeNull::class);
};
