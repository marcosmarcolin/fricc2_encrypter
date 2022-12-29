# Package under development

## FRICC2 encrypter tool

This package aims to facilitate the encryption of your PHP scripts using the [FRICC2](https://github.com/hoowa/PHP-FRICC2) extension.

It is just a resource to facilitate the use of the Encoder which is executed via Shell.

## Encoder

For the tool to work, you need to have the encoder in `/usr/bin/fricc2` installed on your OS.

By default, it will use the name `fricc2`, but if you installed it with another name, you can inform it in the constructor of the `Encrypter` class.

## Installation

`composer require marcosmarcolin/fricc2_encrypter`

## Compatibility

Tested only in **Linux** environment: Ubuntu and Debian.

**PHP version >= 7.4.x is required.**

## How to use

#### To encode only 1 file:

```php
<?php

use MarcosMarcolin\Fricc2Encrypter\Encrypter;

include 'vendor/autoload.php';

$from = __DIR__ . '/src/file.php';
$to = __DIR__ . '/src/new_file.php';

try {
    $Encrypter = new Encrypter($from, $to);
    $Encrypter->simpleEncrypt(); // true or false
} catch (Exception $e) {
    // Any error that occurs will throw an exception.
    var_dump($e->getMessage());
}
```

#### To code one directory to another recursively, use:

```php
<?php

try {
    $Encrypter = new Encrypter($from, $to);
    $Encrypter->recursiveEncrypt(); // true or false
} catch (Exception $e) {
    // Any error that occurs will throw an exception.
    var_dump($e->getMessage());
}
```

To capture the files that failed or succeeded use:

```php
<?php

// Only for recursive encoder

$faileds = $Encrypter->getFaileds()); // array
$success = $Encrypter->getSuccess()); // array
```

## Code quality

To check for errors with PHPCS:

```shell
composer phpcs
``` 

To automatically correct errors with PHPCS:

```shell
composer phpcbf
``` 

## Author

Marcos Marcolin <marcolindev@gmail.com>
