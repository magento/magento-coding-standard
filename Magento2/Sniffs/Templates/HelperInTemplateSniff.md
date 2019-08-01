# Rule: Do not use `helpers` in templates
## Background
The use of helpers is in general discouraged. Consider using a ViewModel instead.

## Reasoning
The use of helpers is in general discouraged therefore any `$this->helper(<helper_class>)` code used in PHTML templates should be refactored.

Consider using ViewModel instead.

## How to fix

Typical example of a helper being used in a PHTML:
```html
<?php $_incl = $block->helper(<helper_class>)->...; ?>
```

Once the ViewModel is created, call it in the PHTML as follow:

```html
<?php $viewModel = $block->getViewModel(); ?>
```
or
```html
<?php $viewModel = $block->getData('viewModel'); ?>
```
