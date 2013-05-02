<?php

class Application_Model_Worker_Promotion
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
		/*$this->_cUrl = new Core_Dom_Curl(array(
			'method' => 'GET'
		));*/
		 
	}
	public function start() {
		$model = Application_Model_Site_Lazada::getInstance();
		$model->start();
		die('OK');
	}
}

