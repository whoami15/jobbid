<?php

class Application_Model_Worker_Test 
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
						'X-Requested-With: 	XMLHttpRequest',
						'Cookie: __utma=259897482.1689604994.1351605073.1366299993.1366340806.53; __utmz=259897482.1366198743.50.6.utmcsr=facebookad|utmccn=pro_tangtientrieu_thang04|utmcmd=PromoP|utmctr=Fans_Friend_123vn|utmcct=tang-tien-trieu; __utmv=259897482.|1=User%20ID=thanhphuong7486=1; __atuvc=0%7C12%2C0%7C13%2C0%7C14%2C0%7C15%2C16%7C16; __utmx=259897482.YNCbXckDSTOh7MhnaRUGCQ$54197633-8:1; __utmxx=259897482.YNCbXckDSTOh7MhnaRUGCQ$54197633-8:1358337355:15552000; s3=1360132972; banner_footer_count=19; zingid=1366125523_128; __atssc=facebook%3B1; PHPSESSID=uu95rnj0ic5782lcf5hn0l5363; __utmb=259897482.17.9.1366341461284; __utmc=259897482; uin=213504237; acn=thanhphuong7486; vngauth=AAEMWdq0cFHt0LkMAAAAAGGgMHA%3D; s1=1366341418; s2=11a4511a49a0d221ea07d7a460c49371'
				)
		));
		 
	}
	public function start() {
		$date = new Zend_Date(1366390800);
		echo $date->toString('dd/MM/Y HH:mm:ss');die;
		//echo Core_Utils_String::getSlug('Hà Nội');die;
		$url = 'http://123.vn/tang-tien-trieu.html';
		//$content = $this->_cUrl->getContent($url);
		//Core_Utils_Log::write($content);die;
		//$url = 'http://localhost/jobbid/test/test';
		$i = 0;
		$flag = false;
		Core_Dom_Query::cleanup();
		$content = $this->_cUrl->getContent($url);
		//Core_Utils_Log::write($content);die('OK');
		$doc = Core_Dom_Query::newDocumentHTML($content,'UTF-8');
		$post_data = $doc->find('#frm_lucky')->serializeArray();
		$post_items = array();
		foreach ($post_data as $item) {
			$post_items[] = $item['name'] . '=' . $item['value'];
		}
		print_r($post_items);
		if(empty($post_items)) {
			die('Not 12h');
		}
		/*print_r($post_data);die;
		//$doc->find("#frm_lucky #btSubmit")->click();
		foreach ( $post_data as $key => $value) {
		    $post_items[] = $key . '=' . $value;
		}*/
		$post_string = implode ('&', $post_items);
		//Core_Utils_Log::log($post_string);die;
		//create cURL connection
		$curl_connection = 
		  curl_init($url);
		 
		//set options
		curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
		curl_setopt($curl_connection, CURLOPT_USERAGENT, 
		  "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)");
		curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl_connection, CURLOPT_FOLLOWLOCATION, 1);
		 
		//set data to be posted
		curl_setopt($curl_connection, CURLOPT_POSTFIELDS, $post_string);
		 
		//perform our request
		$i = 0;
		while($i < 1000) {
			curl_exec($curl_connection);
			$i++;
		}
		
		 
		//show information regarding the request
		/*print_r(curl_getinfo($curl_connection));
		echo curl_errno($curl_connection) . '-' . 
		                curl_error($curl_connection);*/
		 
		//close the connection
		curl_close($curl_connection);
		die('OK');
	}
}

