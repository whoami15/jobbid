<?php

class Application_Model_Worker_Time24h
{
	protected static $_instance = null;
	var $_header;
	var $_cUrl;
	public static function getInstance($className=__CLASS__){
		//Check instance
		if(empty(self::$_instance)){
			self::$_instance = new $className;
		}
		//Return instance
		return self::$_instance;
	}
	public function __construct(){
		 
		 
	}
	public function start() {
		Core_Utils_Job::removeExpriedSecureKeys();
		die;
		Core_Utils_Job::updateFulltextData();
		Core_Utils_Job::updateTags();
	}
}

