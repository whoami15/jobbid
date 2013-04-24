<?php

class Application_Model_Worker_Hack
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
			'method' => 'GET'
		));
		 
	}
	public function start() {
		$minute = date('i');
		$row = Core_Utils_DB::query('SELECT * FROM zing WHERE `status` = 1 AND `minute` = ?',2,array($minute));
		if($row == null) die;
		$zingid = 'bbd'.$row['zingid'];
		$uin = $row['uin'];
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
		//$content = $this->_cUrl->getContent('https://plus.123pay.vn/product/tv-lcd-42-sony_63099.html');
		//Core_Utils_Log::write($content);die;
		$vngauth = $result['cookie']['vngauth'];
		$cUrl = new Core_Dom_Curl(array(
			'method' => 'POST',
			'post_fields' => 'cur=%2F&ref=&type=1&pid=0&num=0&pl=',
			'cookie' => 'Cookie: uin='.$uin.'; vngauth='.$vngauth.'; acn='.$zingid,
			'url' => 'http://123.vn/ajax/log?t=1366792709368'
		));
		$cUrl->exec();
		$cUrl = new Core_Dom_Curl(array(
			'method' => 'POST',
			'post_fields' => '',
			'cookie' => 'Cookie: uin='.$uin.'; vngauth='.$vngauth.'; acn='.$zingid,
			'url' => 'http://123.vn/luckybox/checkgift/id/1'
		));
		$i = 0;
		while ($i<3) {
			$cUrl->exec();
			$i++;
			sleep(1);
		}
		$mailbody = 'Zing id :'.$zingid.'<br>';
		$mailbody .= 'Vngauth :'.$vngauth.'<br>';
		$mailbody .= 'Minute :'.$minute.'<br>';
		//echo $mailbody;
		$coreEmail = new Core_Email();
		$coreEmail->send('nclong87@gmail.com', 'Complete', $mailbody);
		die('OK');
	}
}

