<?php
namespace Nezimi;
use Exeception;

class Error
{

	/**
	 * @var int 1 debug on or 0 debug off 
	 */
	public $debug = '1';

	/**
	 * @var string 
	 */
	protected $file;

	/**
	 * @var 
	 */
	protected $log;

	public function __construct($path, $rule, $file = './template/error.php')
	{
		$this->file = $file;
		/**
		 * E_WARNING
		 * 
		 */
		set_error_handler([$this, 'customError']);
		set_exception_handler([$this, 'customException']);
		register_shutdown_function([$this, 'parseError']);
		$this->log = new Log($path, $rule);		

	}	

	public function  customError($errno , $errstr, $errfile, $errline)
	{
		$error['function'] = __FUNCTION__;
		$error['message'] = $errstr;
		$error['file'] = $errfile;
		$error['line'] = $errline;
		$this->execution($error);	
	}

	public function customException($exception)
	{
		$error['function'] = __FUNCTION__;
		$error['message'] = $exception->getMessage();
		$error['file'] = $exception->getFile();
		$error['line'] = $exception->getLine();
		$error['trace'] = $exception->getTraceAsString();
		$this->execution($error);
	}

	public function parseError()
	{
		if( $error = error_get_last() ) {
			$error['function'] = __FUNCTION__;
			// clear error
			ob_end_clean();
			$this->execution($error);
		}
	}

	public function execution($error)
	{
		if( $this->debug ){
			include $this->file;
		} 
		$this->log->write($error['message']);
	}


}