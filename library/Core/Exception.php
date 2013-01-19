<?php
class Core_Exception extends Exception {
	public function __construct($message) {
		$this->message = $message;
	}
	public static function getErrorMessage($e) {
		if(isset(Core_Const::$messages[$e->getMessage()])) 
    		return Core_Const::$messages[$e->getMessage()];
    	else 
    		return $e->getMessage();
	}
}