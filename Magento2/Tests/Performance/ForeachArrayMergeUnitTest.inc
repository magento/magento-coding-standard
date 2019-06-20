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
    $options = array_merge($options, $source);
}

class SelectBuilder
{
    private $columns = [];

    public function getColumns()
    {
        return $this->columns;
    }

    public function setColumns(array $columns)
    {
        $this->columns = $columns;
    }
}

$selectBuilder = new SelectBuilder();

foreach ([] as $collection) {
    foreach ($configurationSources as $source) {
        $selectBuilder->setColumns(array_merge($selectBuilder->getColumns(), $source));
    }
}

foreach ([] as $item)
    // inline foreach
    $a = array_merge([], []);

foreach ([] as $item)
// array_merge after inline foreach
$a = array_merge([], []);
