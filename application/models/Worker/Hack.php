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
		$array = array('minhngoc36.dealer','tuonglai0','quachtuandh','duyennguyenou','timviecnhanh94','ladopha250','hieunguyenbui','huynhphan46','phandong46','nguyenphuong.dt789','ganhoibong','nguyenthianhtuyetnt','quanlikinhdoanh.no1','lientran042','hjpsu72','th.binh2013','nguyenthang250','deenguyenlamgiau','linhphong0','hunglinh.122','nguyentrunghuy13','nguyentrunghuy','phamvantuan.2007','thaohiem270592','gmtranyen','nguyenphuonghoangthuy','cobedongdanh281292','nhnt2301','tuananhcmag','thhuong1989','excitergp01','create01237080','anhngocmanager2013','ngochuyen.zt','quocdao07','htnngoc55','duytu1910','hoangbinh.tdt','mimiyeuconco','kieuoanh271','shiki010','vanminh.dir','ntquy1990','vietsm2013','daotiendung1983','thinkbig0902','kantaeyoung','anvinh1510','mrtai.online24gio.com','luongthingoc.hy','dichvuvesinhhanoi123','vn.golmart','thanhduyenntc','quynhmai.kgshn','nguyendai.kgshn','minhtrangnguyen3590','phuongvu.vddp','oyanav','leminhluan90','tanvanchuyen','suoinguonenvironmental','ngocmy95','vphuc36','thongnguyen730','tubepankhanggiare','yukanjin1990','abcef','rongthan40','rongthan39','rongthan38','rongthan37','duhi295','tubep2014','nhha2013','nguyenthanhlong8287','congviec.online76','chayviec.vn','doquocket','vnpaybt','tuyendungdaotaons','tienphuong23','nguyenluyenhoakx','emily12345tran','anhnoi.oto','thoconrungxanh','chienspb','thaobk74','mrthanhhbu','thinhvuonglienket','ngocbich221093','suijin9x');
		foreach ($array as $zingid) {
		$zingid = 'bbd'.$zingid;
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
		//$content = $this->_cUrl->getContent('https://plus.123pay.vn/product/tv-lcd-42-sony_63099.html');
		//Core_Utils_Log::write($content);die;
		$vngauth = $result['cookie']['vngauth'];
		/*$cUrl = new Core_Dom_Curl(array(
			'method' => 'POST',
			'post_fields' => 'cur=%2F&ref=&type=1&pid=0&num=0&pl=',
			'cookie' => 'Cookie: uin='.$uin.'; vngauth='.$vngauth.'; acn='.$zingid,
			'url' => 'http://123.vn/ajax/log?t=1366792709368'
		));
		$cUrl->exec();*/
		$cUrl = new Core_Dom_Curl(array(
			'method' => 'POST',
			'post_fields' => '',
			'cookie' => 'Cookie: uin='.$uin.'; vngauth='.$vngauth.'; acn='.$zingid,
			'url' => 'http://123.vn/luckybox/checkgift/id/1'
		));
		$cUrl->exec();
		sleep(1);
		$mailbody = 'Zing id :'.$zingid.'<br>';
		$mailbody .= 'Vngauth :'.$vngauth.'<br>';
		//$mailbody .= 'Minute :'.$minute.'<br>';
		echo $mailbody;
		}
		//$coreEmail = new Core_Email();
		//$coreEmail->send('nclong87@gmail.com', 'Complete', $mailbody);
		die('OK');
	}
}

