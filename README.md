# Magento Coding Standard

A set of Magento rules for [PHP_CodeSniffer](https://github.com/squizlabs/PHP_CodeSniffer) tool.

### Installation
For development puposes you can install Magento Coding Standard by cloning this GitHub repo
```
$ git clone git@github.com:magento/magento-coding-standard.git
$ cd magento-coding-standard
$ composer install
```
It is possible also to install a standalone application via [Composer](https://getcomposer.org)
```
$ composer create-project magento/magento-coding-standard --stability=dev magento-coding-standard
```
Or require `magento/magento-coding-standard` inside your project using  `composer require` command.

#### Verify installation
Command should return the list of installed coding standards including Magento.
```
$ bin/phpcs -i
```
### Usage
Once installed, you can run `phpcs` from the command-line to analyse your code `MyAwesomeExtension`
```
$ bin/phpcs --standard=Magento app/code/MyAwesomeExtension
```
## Where to contribute
- Documentation of existing rules. See [ExtDN PHP CodeSniffer rules for Magento 2](https://github.com/extdn/extdn-phpcs) as a good example.
- Bug fixes and improvements of existing rules.
- Creation of new PHP CodeSniffer rules.
- Discussions on new rules (through periodic hangouts or discussions per GitHub issue).

## How to contribute
1) Start with looking into [Community Dashboard](https://github.com/magento/magento-coding-standard/projects/1). Any ticket in `Up for grabs` is a good candidate to start.
2) Didn't satisfy your requirements? [Create one of three types of issues](https://github.com/magento/magento-coding-standard/issues/new/choose):
   - **Bug report** - Found a bug in the code? Let us know!
   - **Existing rule enhancement** - Know how to improve existing rules? Open an issue describe how to enhance Magento Coding Standard.
   - **New rule proposal** - Know how to improve Magento ecosystem code quality? Do not hesitate to open a proposal.
3) The issue will appear in the `Backlog` column of the [Community Dashboard](https://github.com/magento/magento-coding-standard/projects/1). Once it will be discussed and get `Accepted` label the issue will appear in the `Up for grabs` column.

## Testing
All rules should be covered by unit tests. Each `Test.php` class should be accompanied by a `Test.inc` file to allow for unit testing based upon the PHP CodeSniffer parent class `AbstractSniffUnitTest`.
You can verify your code by running
```
$ bin/phpunit
```
