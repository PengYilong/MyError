Zero Error
====

## Installation

Use [composer](http://getcomposer.org) to install zero-systems/zero-error in your project:
```
composer require zero-systems/zero-error
```


## Usage
```php
use zero\Error;

$config = include './config/log.php';
$path = dirname(__FILE__).'/runtime/log/';
$rule = $config['rule'];
new Error($path, $rule, $file = './template/error.php');
```

