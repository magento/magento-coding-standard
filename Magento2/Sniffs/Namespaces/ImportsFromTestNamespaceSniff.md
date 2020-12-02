# Rule: Do not import from `Test` namespaces
## Background
Sometimes IDE imports the namespace with `Test` automatically for return data type like string, float etc or any other means.

## Reasoning
Time to time we're getting issue with running tests on PRs in magento/magento2 repository because someone imported `\Magento\Tests\NamingConvention\true\string` by mistake. As result - we have "No build reports available" for "Database Compare build", "Functional Tests build", "Sample Data Tests build" while Static tests are shown as "failing" but in results - we don't really have reason

## How it works
Any occurrence starts with `Magento\Tests` in import from the namespace will raise the warning. 

## How to fix

Remove `Magento\Tests` from the imported namespaces
