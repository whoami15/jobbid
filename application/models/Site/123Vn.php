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
	public function getContent($url) {
		if(empty($url)) $url='http://123.vn';
		$url = trim($url);
		$cUrl = new Core_Dom_Curl(array(
			'method' => 'GET',
			'cookie' => $this->cookie
		));
		return $cUrl->getContent($url);
	}
	public function start() {
		$cUrl = new Core_Dom_Curl(array(
			'method' => 'GET',
			'cookie' => $this->cookie
		));
		$content = $cUrl->getContent('http://123.vn/trung-lien-tay.html');
		$doc = Core_Dom_Query::newDocumentHTML($content,'UTF-8');
		$forms = $doc->find('form');
		foreach ($forms as $form) {
			$form = pq($form);
			$name = trim($form->attr('name'));
			if($name == 'frm_coupon300') {
				$post_data = $form->serializeArray();
				$post_items = array();
				foreach ($post_data as $item) {
					$post_items[] = $item['name'] . '=' . $item['value'];
				}
				$cUrl = new Core_Dom_Curl(array(
					'method' => 'POST',
					'post_fields' => implode ('&', $post_items),
					'url' => 'http://123.vn'.trim($form->attr('action')),
					'cookie' => $this->cookie
				));
				$cUrl->exec();
				return true;
			}
		}
		return false;
		
		//$content = $cUrl->getContent('http://www.yes24.vn/Event/2013/san-hang-gio-vang-san-pham.aspx');
		//Core_Utils_Log::write($content);
		//$result = $cUrl->getContent('http://localhost/jobbid/test/test');
		//echo $result;
	}
}

