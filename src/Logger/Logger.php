<?php

/**
 * @Author: i.torso
 * @Date:   2017-11-13 15:44:08
 * @Last Modified by:   i.torso
 * @Last Modified time: 2017-12-14 10:45:10
 */
namespace Logger;

use Monolog\Logger as MonologLogger;
use Monolog\Handler\StreamHandler;

class Logger{

	/**
	 * Monolog logger instance
	 */
	protected $_logger;

	/**
	 * You can extend Logger class and change this default value
	 * @var string
	 */
	protected $_path = "var/log/";

	/**
	 * You can extend Logger class and change this default value
	 * @var string
	 */
	protected $_filename = "debug";

	/**
	 * @var integer
	 */
	protected $_level = MonologLogger::DEBUG;


	/**
	 * Logger construct
	 * @param string $filename
	 * @param integer $level
	 * @param string $loggerName
	 */
	public function __construct(
		$filename = "log",
		$level = MonologLogger::DEBUG,
		$loggerName = 'Logger'
	){

		// if $filename is specified use that
		// else use 'log'
		if($filename){
			$this->_filename = $filename;
		}

		// if $level is specified use that
		// else use DEBUG level
		if($level){
			$this->_level = $level;
		}

		$log = $this->_path . $this->_filename . ".log";

		//initialize logger
		$this->_logger = new MonologLogger($loggerName);
		$this->_logger->pushHandler(new StreamHandler($log, $this->_level));
	}


	/**
	* Returns the calling function through a backtrace
	* @return array
	*/
	public function get_calling_function() {

	  // retrieve caller
	  $caller = debug_backtrace();
	  $caller = $caller[2];

	  $r = "";
	  if (isset($caller['class'])) {
	  	// beautify logging stack trace
	    $r .= $caller['class'] . "::" . $caller['function'] . '()';
	  }
	  return $r;
	}


	/**
	 * Write data in a log file
	 * $message can be object, array or string
	 * @param  String|Array|Object $message
	 * @param  integer|null $level
	 * @param  array  $context
	 */
	public function log(
		$message,
		$level = null,
		array $context = []
	){

		// if $level is not specified use default
		// level setted in constructor
		if(!$level){
			$level = $this->_level;
		}


		if(is_array($message)){

			// if $message is of type Array use print_r to beautify log
			$message = print_r($message, true);

		} elseif(is_object($message)){

			// if $message is an PHP object print just object methods
			$class = get_class($message);
			$methods = 'Methods: ' . print_r(get_class_methods($message), true);
			$message = "$class | $methods";
		}

		// add to message the stack function which call the logger
		$message = $this->get_calling_function() . " -> " . $message;
		return $this->_logger->log($level, $message, $context);
	}


	/**
	 * Helper function to call log function
	 * without pass Monolog constant as parameter
	 * @param  String|Array|Object $message
	 * @param  array  $context
	 */
	public function debug($message, array $context = []){
		return $this->log($message, Monolog::DEBUG, $context);
	}


	/**
	 * Helper function to call log function
	 * without pass Monolog constant as parameter
	 * @param  String|Array|Object $message
	 * @param  array  $context
	 */
	public function info($message, array $context = []){
		return $this->log($message, Monolog::INFO, $context);
	}


	/**
	 * Helper function to call log function
	 * without pass Monolog constant as parameter
	 * @param  String|Array|Object $message
	 * @param  array  $context
	 */
	public function warning($message, array $context = []){
		return $this->log($message, Monolog::WARNING, $context);
	}


	/**
	 * Helper function to call log function
	 * without pass Monolog constant as parameter
	 * @param  String|Array|Object $message
	 * @param  array  $context
	 */
	public function error($message, array $context = []){
		return $this->log($message, Monolog::ERROR, $context);
	}


	/**
	 * Helper function to call log function
	 * without pass Monolog constant as parameter
	 * @param  String|Array|Object $message
	 * @param  array  $context
	 */
	public function critical($message, array $context = []){
		return $this->log($message, Monolog::CRITICAL, $context);
	}
}