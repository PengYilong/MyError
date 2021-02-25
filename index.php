<?php
include './Loader.php';
spl_autoload_register('Loader::_autoload');
date_default_timezone_set('PRC');

use zero\Error;

$config = [
    'exception_tmpl' => '',
    // true debug on or flase debug off 
    'debug' => false,
];
new Error($config);;
// throw new Exception('throw a Exception');
$test = new  principle\testA();
$test->index();
