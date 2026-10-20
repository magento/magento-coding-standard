# Rule: Sort `use` imports alphabetically
## Background
Import `use` statements end up in whatever order an IDE or a developer added them. The same set of imports is then written differently in every file and every merge adds lines at random positions.

## Reasoning
A fixed order makes imports easy to scan, keeps diffs small and turns parallel additions of imports into trivial merges instead of conflicts.

## How it works
Within each namespace, top-level import `use` statements are compared in this order:

1. Class, interface, trait and enum imports, then `use function`, then `use const`.
2. Within each type, names are compared case-insensitively, one namespace segment at a time, so `Foo\Bar` comes before `Foo\Bar\Baz`, which comes before `Foo\BarBaz`.

Closure `use` and trait `use` inside a class are ignored. A group use such as `use Foo\{Bar, Baz};` is sorted by its prefix `Foo`; names inside the braces are not checked.

## How to fix
Run `phpcbf --standard=Magento2 --sniffs=Magento2.Namespaces.AlphabeticallySortedUses <path>`. The fixer reorders the statements when only whitespace separates them. When comments sit between imports, reorder them by hand.
