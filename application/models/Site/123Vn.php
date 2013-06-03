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
	public function __construct($cookie=''){
		if(!empty($cookie)) 
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
	public function login($zingid) {
		if(Core_Utils_String::contains($zingid, 'bbd') == false) {
			$zingid = 'bbd'.$zingid;
		}
		$uin = '214382341';
		$content = '<form action="https://sso2.zing.vn/index.php?method=xdomain_login" method="post" onsubmit="return onSubmitPopup();" id="frm_submit_login"><div class="Popup_tbl"><div style="width: 417px;" class="wrapper"><h3>ĐĂNG NHẬP</h3><div class="padd_2"><div style="margin-top:20px"></div><p><label>Tài khoản</label><input type="text" placeholder="Zing ID hoặc Email" id="u" name="u"></p><p><label>Mật khẩu</label><input type="password" onkeydown="searchKeyPress(event)" id="p" name="p"></p><p style="margin-left:83px;"><input type="submit" value="Đăng nhập" class="login123" style="cursor:pointer; padding:4px;" id="submit_login">&nbsp;<a rel="nofollow" target="_blank" href="https://id.zing.vn/forgotinfo/index.38.html" style="margin-top:7px;font-size:11px">Quên mật khẩu ?</a>&nbsp; |  &nbsp;<a rel="nofollow" id="popup_register_menu" href="https://123.vn/register/popup?redirect=%2F" style="font-size:11px">Đăng ký mới</a></p><div class="c2"></div></div></div></div><input type="hidden" name="u1" value="https://123.vn/login/verify?redirect=%2F"><input type="hidden" name="fp" value="https://123.vn/login/index?redirect=%2F"><input type="hidden" name="pid" value="123"></form>';
		$doc = Core_Dom_Query::newDocumentHTML($content,'UTF-8');
		$post_data = $doc->find('#frm_submit_login')->serializeArray();
		$post_items = array();
		foreach ($post_data as $item) {
			if($item['name'] == 'u') $item['value'] = $zingid;
			if($item['name'] == 'p') $item['value'] = '74198788';
			$post_items[] = $item['name'] . '=' . $item['value'];
		}
		$post_string = implode ('&', $post_items);
		
		//Core_Utils_Log::write($content);die;
		$cUrl = new Core_Dom_Curl(array(
			'method' => 'POST',
			'post_fields' => $post_string,
			'url' => 'https://sso2.zing.vn/index.php?method=xdomain_login'
		));
		$result = $cUrl->exec();
		$vngauth = $result['cookie']['vngauth'];
		$this->cookie = 'Cookie: uin='.$uin.'; vngauth='.$vngauth.'; acn='.$zingid;
		return $result;
	}
	public function guest($price) {
		$price = Core_Utils_NumberUtil::parseInt($price);
		$array = array(
			'product_id' => '71620',
			'price' => $price,
		);
		$post_items = array();
		foreach ($array as $name=>$value) {
			$post_items[] = $name.'='.$value;
		}
		//return implode ('&', $post_items);
		$cUrl = new Core_Dom_Curl(array(
			'method' => 'POST',
			'header' => array(
				'Accept: */*',
				'Accept-Encoding: gzip, deflate',
				'Accept-Language: en-US,en;q=0.5',
				'Content-Type: application/x-www-form-urlencoded; charset=UTF-8',
				'Host: 123.vn',
				'Referer: http://123.vn/dau-gia-nguoc.html?b_source=123.vn&b_medium=123.vn&b_campaign=dau+gia+nguoc&block=HOMExTOP&adv_type=banner',
				'User-Agent: Mozilla/5.0 (Windows NT 6.1; rv:21.0) Gecko/20100101 Firefox/21.0',
				'X-Requested-With: XMLHttpRequest'
			),
			'post_fields' => implode ('&', $post_items),
			'url' => 'http://123.vn/dau-gia-nguoc.html',
			'cookie' => $this->cookie
		));
		$result = $cUrl->exec();
		$result = json_decode($result['body'],true);
		//print_r($result);
		return $result;
	}
	public function start() {
		$h = date('H');
		if($h > 7) return ;
		//die($h);
		$row = Core_Utils_DB::query('SELECT * FROM `zing` WHERE `status` = 1 ORDER BY id LIMIT 0,1',2);
		if($row==null) exit;
		$msg = $row['zingid'].PHP_EOL;
		$this->login($row['zingid']);
		$num = Core_Utils_DB::query('SELECT MAX(number) as num FROM `bbd_guest` WHERE zingid IS NOT NULL',2);
		$rows = Core_Utils_DB::query('SELECT * FROM `bbd_guest` WHERE `zingid` IS NULL and number >= '.$num['num'].' ORDER BY `number` LIMIT 0,20');
		$i = 0;
		foreach ($rows as $item) {
			if($i % 3 != 0) {
				$i++;
				continue;
			}
			$num = $item['number'].'000';
			$msg.='Guest num '.$num.PHP_EOL;
			$result = $this->guest($num);
			if($result['valid'] == true) {
				Core_Utils_DB::update('bbd_guest', array('zingid' => $row['zingid'],'time_create' => Core_Utils_Date::getCurrentDateSQL()), array('number' => $item['number']));
			}
			if($result['user_bid_max'] <= 0) {
				break;
			}
			sleep(5);
			$i++;
		}
		Core_Utils_DB::update('zing', array('status' => '0'), array('id' => $row['id']));
		Core_Utils_Log::log123($msg);
		//echo 'DONE'.PHP_EOL;
		//return $this->login($num);
	}
	public function test($num) {
		return $this->guest($num);
	}
	public function getGuest($zingid) {
		//return $zingid.' dasda';
		if(empty($this->cookie))
			$this->login($zingid);
		$cUrl = new Core_Dom_Curl(array(
			'method' => 'GET',
			'cookie' => $this->cookie
		));
		return $cUrl->getContent('http://123.vn/auction/historybid?product_id=71620');
	}
}

