<?php
namespace zero\exception;
use Exception;

class Handle
{

	/**
	 * @var boolean true debug on or flase debug off 
	 */
	public $debug = true;

	/**
	 * @var string 
	 */
	protected $file;

    public function __construct($config)
    {
		$this->config = $config;
	}
	
	public function render(Exception $e)
	{
		if($e instanceof HttpException) {
			return $this->renderHttpException($e);
		} else {
			return $this->convertExceptionToResponse($e);
		}
	}

	/**
	 * 
	 *
	 * @param HttpException $e
	 * @return void
	 */
	public function renderHttpException(HttpException $e)
	{
		$status = $e->statusCode;
		$template = $this->config['http_exception_template'];
		if(!$this->config['debug'] && !empty($template[$status])) {
			return $this->convertHttpException($e);
		} else {
			return $this->convertExceptionToResponse($e);
		}
	}

	public function convertHttpException(Exception $e)
	{
		$status = $e->statusCode;
		$template = $this->config['http_exception_template'];

		if( !$this->config['debug'] && !empty($template[$status]) ) {
			include $template[$status];
		} else {
			return $this->convertExceptionToResponse();	
		}
		
	}

    public function convertExceptionToResponse(Exception $exception)
	{
		$error['message'] = $exception->getMessage();
		$error['file'] = $exception->getFile();
		$error['line'] = $exception->getLine();
		$error['trace'] = $exception->getTraceAsString();
		
		include __DIR__.'/../../template/header.php';
		include __DIR__.'/../../css/normalize.css';
		include __DIR__.'/../../css/error.css';
		include $this->config['exception_tmpl'];
	} 
}