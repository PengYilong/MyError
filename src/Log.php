<?php
namespace Nezimi;

class Log
{

	/**
	 * @var string log dir
	 */	
	public $path;

	/**
	 * @var string
	 */	
	public $file;

	/**
	 * @var string extension
	 */	
	public $ext = '.log';

	public function __construct($path, $rule)
	{
		//format	
		array_walk($rule, array($this, 'process'));
		//pop the last element
		$file = array_pop($rule);

		//gets dir
		$path_string = implode('/', $rule);
		$this->path = $path.$path_string;

		if(!is_dir($this->path)){
			mkdir($this->path, 0777, true);
		}

		$this->file = $this->path.DIRECTORY_SEPARATOR.$file.$this->ext;
	}
	
	public function write($message)
	{
		$message = $this->format($message);
		// file_put_contents($file, $message, FILE_APPEND);
		// $handle = fopen($this->file, 'a+');
		// fwrite($handle, $message);
		// fclose($handle);	
		error_log($message, 3, $this->file);
	}


	public function process(&$value)
	{
		date($value);
	}

	private function format($message)
	{
		return date('Y-m-d H:i:s').':'.$message.PHP_EOL;
	} 


}