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
		$content = '<form id="frm_submit_login" method="post" action="https://sso2.zing.vn/index.php?method=xdomain_login">
      <p>Tài khoản<br>
        <label>
          <input type="text" style="width: 215px;height: 22px;margin-top: 5px;" name="u" id="u" placeholder="Zing ID" value="">
        </label>
      </p>
      <p>Mật khẩu<br>
        <label>
          <input type="password" style="width: 215px;height: 22px;margin-top: 5px;" name="p" id="p">
        </label>
      </p>     
      <input type="hidden" value="https://plus.123pay.vn/login/verify?redirect=%2F" id="u1" name="u1">
      <input type="hidden" value="https://plus.123pay.vn/?code=1" id="fp" name="fp">
      <input type="hidden" value="123" id="pid" name="pid">
      <input type="submit" style="padding:6px 0 5px 3px;height:30px;" id="button" value="Đăng nhập">
      <h1 style="text-align:right"><a target="_blank" href="https://id.zing.vn/forgotinfo/index.38.html" class="gray">Quên mật khẩu</a> <span class="gray">|</span> <a href="https://id.zing.vn/register/index.38.html" target="_blank" class="gray">Đăng ký</a></h1>
    </form>';
		$doc = Core_Dom_Query::newDocumentHTML($content,'UTF-8');
		$post_data = $doc->find('#frm_submit_login')->serializeArray();
		$post_items = array();
		foreach ($post_data as $item) {
			if($item['name'] == 'u') $item['value'] = 'thaovy_bbd';
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
		print_r($result['cookie']);
		//$content = $this->_cUrl->getContent('https://plus.123pay.vn/product/tv-lcd-42-sony_63099.html');
		//Core_Utils_Log::write($content);die;
		$vngauth = $result['cookie']['vngauth'];
		$cUrl = new Core_Dom_Curl(array(
			'method' => 'POST',
			'post_fields' => '',
			'cookie' => 'Cookie: uin=213995539; vngauth='.$vngauth.'; acn=thaovy_bbd',
			'url' => 'http://123.vn/luckybox/checkgift/id/1'
		));
		$i = 0;
		while ($i<10) {
			$cUrl->exec();
			$i++;
			sleep(1);
		}
		$coreEmail = new Core_Email();
		$coreEmail->send('nclong87@gmail.com', 'Hack complete', 'Hack complete');
		die('OK');
	}
}

