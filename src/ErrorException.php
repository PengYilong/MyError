<?php
namespace zero;
use Exception;

class ErrorException extends Exception
{
    public function __construct(int $errno , string $errstr , string $errfile , int $errline)
    {
        $this->file = $errfile;
        $this->line = $errline;
        $this->message = $errstr;
    }
}