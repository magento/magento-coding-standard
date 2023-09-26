# Magento Coding Standard

A set of Magento rules for [PHP_CodeSniffer](https://github.com/squizlabs/PHP_CodeSniffer) tool.

## Installation within a Magento 2 site

To use within your Magento 2 project you can use:

```bash
composer require --dev magento/magento-coding-standard
```

Due to security, when installed this way the Magento standard for phpcs cannot be added automatically.
You can achieve this by adding the following to your project's `composer.json`:

```json
"scripts": {
    "post-install-cmd": [
      "([ $COMPOSER_DEV_MODE -eq 0 ] || vendor/bin/phpcs --config-set installed_paths ../../magento/magento-coding-standard/)"
    ],
    "post-update-cmd": [
      "([ $COMPOSER_DEV_MODE -eq 0 ] || vendor/bin/phpcs --config-set installed_paths ../../magento/magento-coding-standard/)"
    ]
}
```

### Installation for development

You can install Magento Coding Standard by cloning this GitHub repo:

```bash
git clone git@github.com:magento/magento-coding-standard.git
cd magento-coding-standard
composer install
```

It is possible also to install a standalone application via [Composer](https://getcomposer.org)

```bash
composer create-project magento/magento-coding-standard --stability=dev magento-coding-standard
```

### Verify installation

Command should return the list of installed coding standards including Magento2.

```bash
vendor/bin/phpcs -i
```

## Usage

Once installed, you can run `phpcs` from the command-line to analyze your code `MyAwesomeExtension`

```bash
vendor/bin/phpcs --standard=Magento2 app/code/MyAwesomeExtension
```

### Fixing issues automatically

Also, you can run `phpcbf` from the command-line to fix your code `MyAwesomeExtension` for warnings like "PHPCBF CAN FIX THE [0-9]+ MARKED SNIFF VIOLATIONS AUTOMATICALLY"

```bash
vendor/bin/phpcbf --standard=Magento2 app/code/MyAwesomeExtension
```

## Contribution

See the community [contribution model](https://github.com/magento/magento-coding-standard/blob/develop/.github/CONTRIBUTING.md).

### Where to contribute

- Documentation of existing rules. See [ExtDN PHP CodeSniffer rules for Magento 2](https://github.com/extdn/extdn-phpcs) as a good example.
- Bug fixes and improvements of existing rules.
- Creation of new PHP CodeSniffer rules.
- Discussions on new rules (through periodic hangouts or discussions per GitHub issue).

### How to contribute

1) Start with looking into [Community Dashboard](https://github.com/magento/magento-coding-standard/projects/1). Any ticket in `Up for grabs` is a good candidate to start.
2) Didn't satisfy your requirements? [Create one of three types of issues](https://github.com/magento/magento-coding-standard/issues/new/choose):
   - **Bug report** - Found a bug in the code? Let us know!
   - **Existing rule enhancement** - Know how to improve existing rules? Open an issue describe how to enhance Magento Coding Standard.
   - **New rule proposal** - Know how to improve Magento ecosystem code quality? Do not hesitate to open a proposal.
3) The issue will appear in the `Backlog` column of the [Community Dashboard](https://github.com/magento/magento-coding-standard/projects/1). Once it will be discussed and get `accepted` label the issue will appear in the `Up for grabs` column.

## Testing

All rules should be covered by unit tests. Each `Test.php` class should be accompanied by a `Test.inc` file to allow for unit testing based upon the PHP_CodeSniffer parent class `AbstractSniffUnitTest`.
You can verify your code by running

```bash
vendor/bin/phpunit
```

Also, verify that the sniffer code itself is written according to the Magento Coding Standard:

```bash
vendor/bin/phpcs --standard=Magento2 Magento2/ --extensions=php
```

### ESLint
Prerequisites: [Node.js](https://nodejs.org/) (`^12.22.0`, `^14.17.0`, or `>=16.0.0`).

You need to run the following command to install all the necessary packages described in the `package.json` file:
```bash
npm install
```

You can execute ESLint as follows:
```bash
npm run eslint -- path/to/analyze
```

### RECTOR PHP
From `magento-coding-standard` project, you can execute rector php as follows:
```bash
vendor/bin/rector process Magento2 Magento2Framework PHP_CodeSniffer --dry-run --autoload-file vendor/squizlabs/php_codesniffer/autoload.php
```
The rules from rector that are applied are set inside the config file: `rector.php`

The option `--dry-run` displays errors found, but code is not automatically fixed.

To run rector for `magento` projects you need to:
- Specify the magento path and the autoload file for the magento project: 
```bash
vendor/bin/rector process MAGENTO_PATH --dry-run --autoload-file MAGENTO_AUTOLOAD_FILE
```
Example:
```bash
vendor/bin/rector process magento2ce/app/code/Magento/Cms/Model --dry-run --autoload-file magento2ce/vendor/autoload.php
```

## License

Each Magento source file included in this distribution is licensed under the OSL-3.0 license.

Please see [LICENSE.txt](https://github.com/magento/magento-coding-standard/blob/master/LICENSE.txt) for the full text of the [Open Software License v. 3.0 (OSL-3.0)](https://opensource.org/licenses/osl-3.0.php).
