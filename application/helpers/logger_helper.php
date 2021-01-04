<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Logger Class
 *
 * @package    	helpers
 * @category    Logger
 */
class Logger {

  public static function write($type, $title, $text) {
    $today = date('Y-m-d');
    $now = date('Y-m-d H:i:s');

    $logger_filedir = "logs/systemLog/";
    
    // create directory/folder loggerger
		if (!file_exists($logger_filedir))
		{
			mkdir($logger_filedir, 0777, true);
    }
    
    $logger = "".$logger_filedir."/".$today."";
    

		$logger_file = fopen($logger, 'a');
		$loggertext = "[" . $now . "] " . "[" . $type . "] " . "[" . $title . "]: " . $text;

    fwrite($logger_file, "\r\n". $loggertext);
		fclose($logger_file);
  }
}