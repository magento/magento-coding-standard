<?php
$configurationSources = [
    0 => 'value',
    1 => 'value2',
];

$options = [];

foreach ([] as $collection) {
    foreach ($configurationSources as $source) {
        $options = array_merge($options, $source);
    }
}

$options = [];
$itemCount = count($configurationSources);
for ($i = 0; $i <= $itemCount; $i++) {
    $source = $options[$itemCount];
    $options = array_merge($options, $source));
}

class CSV
{
    public static function getColumns()
    {
        return [];
    }
}

foreach ([] as $collection) {
    foreach ($configurationSources as $source) {
        $options = array_merge(CSV::getColumns(), $source);
    }
}