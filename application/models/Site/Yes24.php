<?php

class Application_Model_Site_Yes24
{
	protected static $_instance = null;
	var $cookie = '';
	var $state = '';
	public static function getInstance($className=__CLASS__){
		//Check instance
		if(empty(self::$_instance)){
			self::$_instance = new $className;
		}
		//Return instance
		return self::$_instance;
	}
	public function __construct($cookie,$state){
		if(empty($cookie)) die('cookie empty');
		$this->cookie = 'Cookie: '.$cookie; 
		$this->state = $state;
	}
	public function getContent($url) {
		if(empty($url)) $url='http://www.yes24.vn';
		$url = trim($url);
		$cUrl = new Core_Dom_Curl(array(
			'method' => 'GET',
			'cookie' => $this->cookie
		));
		return $cUrl->getContent($url);
	}
	public function checkOut() {
		$array = array(
				'http://www.yes24.vn/Display/MobileProductDetail.aspx?ProductNo=851780',
				'http://www.yes24.vn/Display/MobileProductDetail.aspx?ProductNo=965746',
				'http://www.yes24.vn/Display/MobileProductDetail.aspx?ProductNo=944874',
		);
		$cUrl = new Core_Dom_Curl(array(
				'method' => 'GET',
				'header' => array(
						'Accept: */*',
						'Accept-Encoding: gzip, deflate',
						'Accept-Language: en-US,en;q=0.5',
						'Host: www.yes24.vn',
						'Referer: http://www.yes24.vn/Event/2013/san-hang-gio-vang-san-pham.aspx',
						'X-Requested-With: XMLHttpRequest',
						'User-Agent: Mozilla/5.0 (Windows NT 6.1; rv:20.0) Gecko/20100101 Firefox/20.0'
					),
				'cookie' => $this->cookie,
		));
		$url = 'http://www.yes24.vn/Event/2013/san-hang-gio-vang-data.aspx?act=submit';
		$images = array();
		foreach ($array as $index => $item) {
			$cUrl->getContent('http://www.yes24.vn/Event/2013/san-hang-gio-vang-data.aspx?Product='.$item.'&ProductType=M&_='.microtime(true));
			preg_match('/ProductNo=\s*([^;]*)/mi', $item, $m);
			$url.='&hdPro'.($index+1).'='.$m[1];
			$images[] = 'http://www.yes24.vn/Upload/ProductImage/YES24DTDD/'.$m[1].'_M.jpg';
		}
		$cUrl = new Core_Dom_Curl(array(
				'method' => 'POST',
				'header' => array(
						'Accept: text/plain, */*; q=0.01',
						'Accept-Encoding: gzip, deflate',
						'Accept-Language: en-US,en;q=0.5',
						'Host: www.yes24.vn',
						'Content-Type: application/x-www-form-urlencoded; charset=UTF-8',
						'Referer: http://www.yes24.vn/Event/2013/san-hang-gio-vang-san-pham.aspx',
						'X-Requested-With: XMLHttpRequest',
						'User-Agent: Mozilla/5.0 (Windows NT 6.1; rv:20.0) Gecko/20100101 Firefox/20.0',
						'Pragma: no-cache',
						'Cache-Control: no-cache',
						'Connection: keep-alive'
					),
				'cookie' => $this->cookie,
				'url' => $url,
				'post_fields' => '<table border="0" cellpadding="0" cellspacing="0">
        <tbody><tr>
        <td>
            <ul style="width:628px;">
            <li class="draggable1"><img style="cursor: move; position: relative;" src="'.$images[0].'" class="drag-image ui-draggable" id="draggable1"></li>
            <li class="draggable2"><img style="cursor: move; position: relative;" src="'.$images[1].'" class="drag-image ui-draggable" id="draggable2"></li>
            <li class="draggable3"><img style="cursor: move; position: relative;" src="'.$images[2].'" class="drag-image ui-draggable" id="draggable3"></li>
        </ul>
        </td>
        
        </tr>
        </tbody></table>',
		));
		$result = $cUrl->exec();
		return $result['body'];
	}
	public function getCoupon() {
		$post_items = array(
			'__EVENTARGUMENT=',
			'__EVENTTARGET=',
			'__VIEWSTATE='. $this->state,
			'ctl00$ContentPlaceHolder2$imageField1.x=62',
			'ctl00$ContentPlaceHolder2$imageField1.y=75',
			'ctl00$hdfSearchType=',
			'ctl00$txtSearch=',
			'searchType=0'
		);
		$post_string = implode ('&', $post_items);
		$cUrl = new Core_Dom_Curl(array(
			'method' => 'POST',
			'header' => array(
				'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
				'Accept-Encoding: gzip, deflate',
				'Accept-Language: en-US,en;q=0.5',
				'Connection: keep-alive',
				'Host: www.yes24.vn',
				'Referer: http://www.yes24.vn/Event/2013/nhan-qua-ung-y.aspx',
				'User-Agent: Mozilla/5.0 (Windows NT 6.1; rv:20.0) Gecko/20100101 Firefox/20.0'
			),
			'post_fields' => $post_string,
			'url' => 'http://www.yes24.vn/Event/2013/nhan-qua-ung-y.aspx',
			'cookie' => $this->cookie
		));
		$result = $cUrl->exec();
		return $result['body'];
	}
	public function start() {
		$this->getCoupon();
		//$this->checkOut();
	}
}

