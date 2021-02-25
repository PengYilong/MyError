<?php
namespace zero\exception;

use Throwable;

class ThrowableError extends \ErrorException
{

    public $statusCode;
    public $headers;

    public function __construct(Throwable $e)
    {
        if($e instanceof \PareseError) {
            $message = 'Parse error: ' . $e->getMessage();
            $serverity = E_PARSE;
        } else if ($e instanceof \TypeError) {
            $message = 'Type error: ' . $e->getMessage();
            $serverity = E_RECOVERABLE_ERROR;
        } else {
            $message = 'Fatal error: ' . $e->getMessage();
            $serverity = E_ERROR;
        }
        
        parent::__construct(
            $message,
            $e->getCode(),
            $serverity,
            $e->getFile(),
            $e->getLine()
        );

        $this->setTrace($e->getTrace());
    }   
    
    protected function setTrace($trace)
    {
        $traceReflector = new \ReflectionProperty('Exception', 'trace');
        $traceReflector->setAccessible(true);
        $traceReflector->setValue($this, $trace); 
    }
}