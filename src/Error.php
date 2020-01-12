<?php
namespace zero;
use Exception;

class Error
{

	/**
	 * @var boolean true debug on or flase debug off 
	 */
	public $debug = true;

	/**
	 * @var string 
	 */
	protected $file;

	/**
	 * @var 
	 */
	protected $log;

	protected $path;

	public function __construct($file = __DIR__.'/../template/error.php', $path = '', $rule = [],  $debug = true)
	{
		$this->file = $file;
		try{
			if( !file_exists($file) ){
				throw new Exception('the my-error template doesn\'t exist:' . $file  );
			}
			$this->debug = $debug;
			/**
			 * E_WARNING
			 * 
			 */
			register_shutdown_function([$this, 'parseError']);
			set_error_handler([$this, 'customError']);
			set_exception_handler([$this, 'customException']);

			$this->path = $path;
			if( !empty($path) ){
				$this->log = new Log($path, $rule);	
			}
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
	public function  customError(int $errno , string $errstr , string $errfile , int $errline , array $errcontext)
	{
		$exception = new ErrorException($errno, $errstr, $errfile , $errline);
		throw $exception;
	}

	/**
	 * Exception Handler
	 */
	public function customException($exception)
	{
		if(!$exception instanceof Exception) {
			return 'Throwable';
		}
		$this->execution($exception);
	}

	/**
	 * Shutdown Handler 
	 */
	public function parseError()
	{
		if( $error = error_get_last() && $this->isFatal($error['type']) ) {
			$exception = new ErrorException($error['type'], $error['message'], $error['file'] , $error['line']);
			$this->customException($exception);
		}
	}

	protected function isFatal($type)
	{
		return in_array($type, [E_PARSE, E_ERROR, E_CORE_ERROR, E_CORE_WARNING, E_COMPILE_ERROR]);
	}

	public function execution($exception)
	{
		$error['message'] = $exception->getMessage();
		$error['file'] = $exception->getFile();
		$error['line'] = $exception->getLine();
		$error['trace'] = $exception->getTraceAsString();
		if( $this->debug ){
			include __DIR__.'/../template/header.php';
			include __DIR__.'/../css/normalize.css';
			include __DIR__.'/../css/error.css';
			include $this->file;
		}
		if( !empty($path) ){ 
			$this->log->write($error['message']);
		}
	}


}