<?php
return  [
    'exception_tmpl' => '',
    'http_exception_template'    =>  [
        // 定义404错误的模板文件地址
        404 =>   './404.html',
        // 还可以定义其它的HTTP status
        401 =>  './401.html',
    ],
    // true debug on or flase debug off 
    'debug' => false,
];