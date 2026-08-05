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

// Accumulates in a while loop.
$options = [];
while (count($configurationSources) > 0) {
    $source = array_shift($configurationSources);
    $options = array_merge($options, $source);
}

// Accumulates in a do-while loop.
$options = [];
do {
    $options = array_merge($options, $configurationSources);
} while (count($options) < 10);

// Accumulates into the array offset of a property.
class DataProvider
{
    private $data = ['rows' => []];

    private $fields = [];

    public function collect(array $fieldsets, array $rows)
    {
        foreach ($fieldsets as $fieldset) {
            $this->fields = array_merge($this->fields, $fieldset);
        }

        foreach ($rows as $row) {
            $this->data['rows'] = array_merge($this->data['rows'], $row);
        }

        // Accumulator passed as the last argument.
        $result = [];
        foreach ($rows as $row) {
            $result = array_merge($row, $result);
        }

        return $result;
    }
}

// Constant amount of work per iteration: nothing is accumulated.
$rows = [];
foreach ($configurationSources as $source) {
    $row = array_merge(['default' => 1], $source);
    $rows[] = array_merge($row, ['extra' => 2]);
}

// Setter fed by a getter of a different object does not accumulate.
$otherBuilder = new SelectBuilder();
foreach ($configurationSources as $source) {
    $selectBuilder->setColumns(array_merge($otherBuilder->getColumns(), $source));
}

// Method named array_merge is not the global function.
class ArrayHelper
{
    public function array_merge(array $a, array $b)
    {
        return $a;
    }
}

$helper = new ArrayHelper();
$merged = [];
foreach ($configurationSources as $source) {
    $merged = $helper->array_merge($merged, $source);
}

// Overwritten on every iteration: the merge starts from scratch and nothing grows.
foreach ($configurationSources as $source) {
    $ids = array_keys($source);
    $ids = array_merge($ids, $source);
}

// Two merges into the same accumulator are both part of the same accumulation.
$columns = [];
foreach ($configurationSources as $source) {
    $columns = array_merge($columns, $source);
    $columns = array_merge($columns, array_keys($source));
}

// The foreach value variable is a fresh copy on every iteration.
foreach ($configurationSources as $source) {
    $source = array_merge($source, ['extra' => 1]);
}

foreach ($configurationSources as $key => $source) {
    $key = array_merge($key, ['extra' => 1]);
}

// Only the inner loop is reported for a nested accumulation.
$rows = [];
foreach ($configurationSources as $source) {
    foreach ($source as $item) {
        $rows = array_merge($rows, $item);
    }
}
