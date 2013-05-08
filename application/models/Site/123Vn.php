<?php

class Application_Model_Site_123Vn
{
	protected static $_instance = null;
	var $cookie = '';
	public static function getInstance($className=__CLASS__){
		//Check instance
		if(empty(self::$_instance)){
			self::$_instance = new $className;
		}
		//Return instance
		return self::$_instance;
	}
	public function __construct($cookie){
		if(empty($cookie)) die('cookie empty');
		$this->cookie = 'Cookie: '.$cookie; 
	}
	
	public function start() {
		$cUrl = new Core_Dom_Curl(array(
			'method' => 'POST',
			'post_fields' => '',
			'url' => 'http://123.vn/guesswin/coupon300',
			'cookie' => $this->cookie
		));
		return $cUrl->exec();
		
		//$content = $cUrl->getContent('http://www.yes24.vn/Event/2013/san-hang-gio-vang-san-pham.aspx');
		//Core_Utils_Log::write($content);
		//$result = $cUrl->getContent('http://localhost/jobbid/test/test');
		//echo $result;
	}
}

