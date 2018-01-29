# PHP easy logger helper
Basic logger to log string, array and PHP class.

## Installation
Download logger as composer package:

```bash
$ composer require itorso/logger
```

## Example Usage

```php
	
	$logger = new Logger\Logger();
	$logger->debug('It works!');

```
It will output a log file like `<project_folder>/var/log/log.log`


```php
	
	$logger = new Logger\Logger('custom_log');
	$logger->error('Something goes wrong...');

```
It will output a log file like `<project_folder>/var/log/custom_log.log`


```php
	
	$myArr = ['1','2','x' => 'y'];
	$logger = new Logger\Logger();
	$logger->info($myArr);

```
It will output the beautify version of the array in the log file


```php
	
	$myInstance = new MyClass();
	$logger = new Logger\Logger();
	$logger->info($myInstance);

```
It will output the beautify version of all the methods available for that class