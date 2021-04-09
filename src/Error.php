<?php
namespace zero;

use Exception;
use zero\exception\ErrorException;
use zero\exception\Handle;
use zero\exception\ThrowableError;

class Error
{
	/**
	 * configs
	 *
	 * @var array
	 */
	public $config = [];	

	private $handle;

	public function __construct(array $config)
	{
		$this->config = $config;

		try{			

			register_shutdown_function([$this, 'appShutdown']);
			set_error_handler([$this, 'appError']);
			set_exception_handler([$this, 'appException']);
			
		} catch(Exception $e) {
			echo $e->getMessage();
		}

	}	

	/**
	 * Error Handler
	 *
	 * @param integer $errno
	 * @param string $errstr
	 * @param string $errfile
	 * @param integer $errline
	 * @param array $errcontext
	 * @return void
	 */
	public function appError(int $errno , string $errstr , string $errfile , int $errline , array $errcontext)
	{
		$exception = new ErrorException($errno, $errstr, $errfile , $errline);
		throw $exception;
	}

	/**
	 * Exception Handler
	 */
	public function appException($exception)
	{
		
		if( !$exception instanceof Exception ) {
			$exception = new ThrowableError($exception);
		}

		$exceptionHandle = $this->getExceptionHandler();
		$renderRes = $exceptionHandle->render($exception);
		return $renderRes->send();
	}

	/**
	 * Shutdown Handler 
	 */
	public function appShutdown()
	{	
		$error = error_get_last();
		if( $error && $this->isFatal($error['type']) ) {
			$exception = new ErrorException($error['type'], $error['message'], $error['file'] , $error['line']);
			$this->appException($exception);
		}
	}

	protected function isFatal($type)
	{
		return in_array($type, [E_PARSE, E_ERROR, E_CORE_ERROR, E_CORE_WARNING, E_COMPILE_ERROR]);
	}

	/**
	 * Get an instance of the exception handler
	 *
	 * @return void
	 */
	public function getExceptionHandler()
	{
		$class = $this->config['exception_handle'];
		if( $class && class_exists($class) && is_subclass_of($class, 'zero\\exception\\Handle') ) {
			$this->handle = new $class($this->config);
		} else  {
			$this->config['exception_tmpl'] = $this->config['exception_tmpl'] ?: dirname(__DIR__) . DIRECTORY_SEPARATOR . 'template' . DIRECTORY_SEPARATOR . 'error.php';
			if( !file_exists($this->config['exception_tmpl']) ){
				throw new Exception('The template doesn\'t exist:' . $file  );
			}
			$this->handle = new Handle($this->config);
		}

		return $this->handle;
	}

}