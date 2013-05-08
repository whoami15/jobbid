<?php

class Application_Model_Worker_GrabProxy 
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
		$this->_cUrl = new Core_Dom_Curl(array(
				'method' => 'GET',
				'header' => array(
						'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
						'Accept-Encoding: gzip, deflate',
						'Accept-Language: en-US,en;q=0.5',
						'Connection: keep-alive',
						'DNT: 1',
						'User-Agent: Mozilla/5.0 (Windows NT 6.1; WOW64; rv:19.0) Gecko/20100101 Firefox/19.0',
						'X-Requested-With: 	XMLHttpRequest'
				)
		));
		 
	}
	public function start() {
		try {
    		if(connection_status() != CONNECTION_NORMAL)
    			throw new Exception('CONNECTION ERROR');
    		echo 'BEGIN'.PHP_EOL;
    		$proxy = new Core_Grabber_Proxy();
    		$proxy->updateProxy();
    		echo 'END'.PHP_EOL;
    	} catch (Exception $e){
    		echo $e->getTraceAsString();
    	}
	}
}

