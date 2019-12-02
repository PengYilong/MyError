my-error
====

## Installation

Use [composer](http://getcomposer.org) to install nezmi/my-error in your project:
```
composer require nezimi/my-error
```


## Usage
```php
use Nezimi\Error;

$config = include './config/log.php';
$path = dirname(__FILE__).'/runtime/log/';
$rule = $config['rule'];
new MyError($path, $rule, $file = './template/error.php');
```

