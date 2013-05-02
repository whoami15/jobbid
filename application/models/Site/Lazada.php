<?php

class Application_Model_Site_Lazada
{
	protected static $_instance = null;
	var $cookie = 'Cookie: userLanguage=vi; browserDetection=eyJ0eXBlIjoiYnJvd3NlciIsIm5hbWUiOiJGaXJlZm94IiwiY3NzQ2xhc3MiOiJmaXJlZm94IiwidmVyc2lvbiI6IjIwIn0%3D; __cfduid=dbf08cadd345acc05ac260556efcbc0221367257597; wt3_eid=%3B409851756870964%7C2136725760000375719; __utma=234641283.624638566.1367257600.1367332484.1367341764.3; __utmz=234641283.1367257600.1.1.utmcsr=(direct)|utmccn=(direct)|utmcmd=(none); __auc=4f91ddf513e56e75e8926a897a3; PHPSESSID_9660cdb704026c618a09bd6ad453be3f=j0qohn816flv2erc3p4nuek4p6; wt3_sid=%3B409851756870964; __utmc=234641283; __utmb=234641283.26.9.1367343473621; __asc=1a3a072e13e5beb9494c8e3d15c; prudsys-uid=41c7656bebbb12c181d2efdfdbdb35ca';
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
	public function checkOut() {
		$cUrl = new Core_Dom_Curl(array(
			'method' => 'GET',
			'cookie' => $this->cookie
		));
		$content = $cUrl->getContent('https://www.lazada.vn/checkout/finish');
		//Core_Utils_Log::write($content);die;
		$doc = Core_Dom_Query::newDocumentHTML($content,'UTF-8');
		$post_data = $doc->find('form')->serializeArray();
		$post_data[] = array(
			'name' => 'selectTranslation',
			'value' => 1
		);
		//print_r($post_data);die;
		$array = array(
			'couponcode' => '1ESCA264.306ueIQ',
		);
		$post_items = array();
		foreach ($post_data as $item) {
			if(isset($array[$item['name']])) {
				$post_items[] = $item['name'] . '=' . $array[$item['name']];
			} else {
				$post_items[] = $item['name'] . '=' . $item['value'];
			}
		}
		$post_string = implode ('&', $post_items);
		$cUrl = new Core_Dom_Curl(array(
			'header' => array(
				'Accept: application/json, text/javascript, */*; q=0.01',
				'Accept-Encoding: gzip, deflate',
				'Accept-Language: en-US,en;q=0.5',
				//'Content-Length: 750',
				'Content-Type: application/x-www-form-urlencoded; charset=UTF-8',
				'Host: www.lazada.vn',
				'Referer: https://www.lazada.vn/checkout/finish/',
				'User-Agent: Mozilla/5.0 (Windows NT 6.1; rv:20.0) Gecko/20100101 Firefox/20.0',
				'X-Requested-With: XMLHttpRequest',
				$this->cookie
			),
			'method' => 'POST',
			'post_fields' => $post_string,
			'url' => 'https://www.lazada.vn/checkout/finishajax/processlocations/',
			'cookie' => $this->cookie,
			'return' => 0
		));
		echo 'commit';
		$cUrl->exec(false);
		//print_r($result);die;
		//echo $result['body'];
		//print_r($post_data);die;
		//Core_Utils_Log::write($result['body']);
		//die('OK');
	}
	
	public function start() {
		$this->checkOut();
	}
}

