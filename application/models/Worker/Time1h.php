<?php

class Application_Model_Worker_Time1h
{
	protected static $_instance = null;
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
			Core_Utils_Job::autoUpdateJob(5);
			Core_Utils_Job::grabContent();
			Core_Utils_Job::sendEmails();
		} catch (Exception $e) {
			Core_Utils_Log::error($e,Zend_Log::EMERG);
			
		}
		
	}
}

