<?php
include './Loader.php';
spl_autoload_register('Loader::_autoload');
date_default_timezone_set('PRC');

use zero\Error;

$config = include './config/log.php';
$path = dirname(__FILE__).'/runtime/log/';
new Error($path, $rule, $file = './template/error.php');
// throw new Exception('throw a Exception');
$test = new  principle\testA();
$test->index();
