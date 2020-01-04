<?php
namespace zero;
use Exeception;

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
	 */
	public function  customError($errno , $errstr, $errfile, $errline)
	{
		$error['function'] = __FUNCTION__;
		$error['message'] = $errstr;
		$error['file'] = $errfile;
		$error['line'] = $errline;
		$this->execution($error);	
	}

	/**
	 * Exception Handler
	 */
	public function customException($exception)
	{
		$error['function'] = __FUNCTION__;
		$error['message'] = $exception->getMessage();
		$error['file'] = $exception->getFile();
		$error['line'] = $exception->getLine();
		$error['trace'] = $exception->getTraceAsString();
		$this->execution($error);
	}

	/**
	 * Shutdown Handler 
	 */
	public function parseError()
	{
		if( $error = error_get_last() ) {
			switch ($error['type']) {
				case E_PARSE:
				case E_ERROR:
				case E_CORE_ERROR:
				case E_CORE_WARNING:
				case E_COMPILE_ERROR:
					$error['function'] = __FUNCTION__;
					// clear error
					// ob_end_clean();
					$this->execution($error);
					break;
				
				default:
					# code...
					break;
			}
		}
	}

	public function execution($error)
	{
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