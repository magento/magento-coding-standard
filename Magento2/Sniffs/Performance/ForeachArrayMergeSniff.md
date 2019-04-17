# Rule: array_merge(...) is used in a loop and is a resources greedy construction

## Reason
Merging arrays in a loop is slow and causes high CPU usage.

## How to Fix
Typical example when `array_merge` is being used in the loop:
``` php
    $options = [];
    foreach ($configurationSources as $source) {
        // code here
        $options = array_merge($options, $source->getOptions());
    }
```

In order to reduce execution time `array_merge` can be called only once:
``` php
    $options = [[]];
    foreach ($configurationSources as $source) {
        // code here
        $options[] = $source->getOptions();
    }

    // PHP 5.6+
    $options = array_merge(...$options);
```
