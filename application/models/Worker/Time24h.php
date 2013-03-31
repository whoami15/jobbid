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
		try {
			Core_Utils_Job::newJobsDaily();
			Core_Utils_Job::removeExpriedSecureKeys();
			Core_Utils_Job::updateFulltextData();
			Core_Utils_Job::updateTags();
		} catch (Exception $e) {
			Core_Utils_Log::error($e,Zend_Log::EMERG);
		}
	}
}

