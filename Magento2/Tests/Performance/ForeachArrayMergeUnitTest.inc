<?php
$configurationSources = [
    0 => 'value',
    1 => 'value2',
];

$options = [];
foreach ($configurationSources as $source) {
    $options = array_merge($options, $source);
}

$options = [];
$itemCount = count($configurationSources);
for ($i = 0; $i <= $itemCount; $i++) {
    $source = $options[$itemCount];
    $options = array_merge($options, $source));
}
