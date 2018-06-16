<?php
namespace Nezumi;
use Exception;

class MyError
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

	public function __construct($path, $rule, $file = './template/error.php', $debug = 1)
	{
		$this->file = $file;
		try{
			if( !file_exists($file) ){
				throw new Exception('myerror template:'.$file.' doesn\'t exist');
			}
			$this->debug = $debug;
			/**
			 * E_WARNING
			 * 
			 */
			set_error_handler([$this, 'customError']);
			set_exception_handler([$this, 'customException']);
			register_shutdown_function([$this, 'parseError']);

			$this->log = new Log($path, $rule);	
		} catch(Exception $e) {
			echo $e->getMessage();
		}

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