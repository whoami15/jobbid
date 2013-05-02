<?php

class Application_Model_Worker_Poster
{
	protected static $_instance = null;
	var $_header;
	var $_cUrl;
	var $_formFw = '';
	public static function getInstance($className=__CLASS__){
		//Check instance
		if(empty(self::$_instance)){
			self::$_instance = new $className;
		}
		//Return instance
		return self::$_instance;
	}
	public function __construct(){
		/*$this->_cUrl = new Core_Dom_Curl(array(
			'method' => 'GET',
			'cookie' => 'Cookie: cprelogin=no; cpsession=bamboode%3avXE5mTVeFQdlsl2WG6o6XlR8owCLtnpgWIfr13XvEiew5l91VMWwAmFewgci38B_; langedit=; lang=; webmailsession=center%40bamboodev.us%3aHiTH9yjSvMJSWlUDxGXiErCdKKPraHyQKKzXIaPFF6iuVgOf3sK1TuI__mNEODPF; webmailrelogin=no; roundcube_sessauth=S612075c9da1c428b8c0bb0610fdbc4cc9ef69189'
		));*/
		 
	}
	public function start() {
		$goVn = Application_Model_Site_GoVn::getInstance();
		$goVn->post('105349207');
		die('OK');
		//login
		/*$post_string = 'vb_login_username=chuvandu87&vb_login_password=&x=31&y=16&cookieuser=1&s=9c66b0086628a00af7df6767f1b3ca98&securitytoken=guest&do=login&vb_login_md5password=03e4c83055481daef02e63b77047c826&vb_login_md5password_utf=03e4c83055481daef02e63b77047c826';
			
		//Core_Utils_Log::write($content);die;
		$cUrl = new Core_Dom_Curl(array(
			'method' => 'POST',
			'post_fields' => $post_string,
			'url' => 'http://www.5giay.vn/login.php?do=login'
		));
		$result = $cUrl->exec();
		Core_Utils_Log::write($result['body']);*/
		$cUrl = new Core_Dom_Curl(array(
			'method' => 'GET',
		));
		/*$doc = Core_Dom_Query::newDocumentHTML($content,'UTF-8');
		$post_data = $doc->find('#login_form')->serializeArray();
		$post_items = array();
		$array = array(
			'email' => 'test@jobbid.vn',
			'pass' => '74198788'
		);
		foreach ($post_data as $item) {
			if(isset($array[$item['name']])) $item['value'] = $array[$item['name']];
			$post_items[] = $item['name'] . '=' . $item['value'];
		}
		$post_string = implode ('&', $post_items);
		$cUrl = new Core_Dom_Curl(array(
			'method' => 'POST',
			'post_fields' => $post_string,
			'url' => 'https://www.facebook.com/login.php?login_attempt=1',
		));
		$result = $cUrl->exec();*/
		//$content = $cUrl->getContent('https://www.facebook.com/find-friends/browser/?rpix=1');
		/*$doc = Core_Dom_Query::newDocumentHTML($content,'UTF-8');
		foreach ($doc['.friendBrowserListUnit'] as $item) {
			$item = pq($item);
			$uid = $item->find('.friendBrowserID')->val();
			echo 'Add friend '.$uid.PHP_EOL;
			$cUrl = new Core_Dom_Curl(array(
				'method' => 'POST',
				'post_fields' => 'to_friend='.$uid.'&action=add_friend&how_found=friend_browser&ref_param=none&&&outgoing_id=&logging_location=friend_browser&no_flyout_on_click=true&ego_log_data&http_referer&__user=100005325785808&__a=1&__dyn=7n8aD5z5zu&__req=g&fb_dtsg=AQB8OFrV&phstamp=165816656797011486251',
				'url' => 'https://www.facebook.com/ajax/add_friend/action.php',
			));
			$result = $cUrl->exec();
			echo $result['body'].PHP_EOL;
		}*/
		//$textContent = $doc->find('.friendBrowserContentAlignMiddle .friendBrowserID')->get(0)->textContent;
		
		//Core_Utils_Log::write($textContent);
		
		$content = $cUrl->getContent('http://group.apps.zing.vn/me?_v=3&sign_user=2751017&username=nclong87&params=groupwall%2F393767&session_id=1F0189881C994718071E8FD1&signed_request=9ZiMCPz_EZkIf0wV3aY_ffXlWBw07Fx35rXXftW222M=.eyJhbGdvcml0aG0iOiJITUFDLVNIQTI1NiIsImV4cGlyZXMiOjcyMDAsImlzc3VlZF9hdCI6MTM2NzE3MzIxMCwiYWNjZXNzX3Rva2VuIjoiOGRiYmY3NDJkZjdmN2M4YmM5ZTNkMGU3NjhhYmE2ZjYuTnpjeFl6RmhPRE09eFFTNHhwa2hzTmRsYTd3ZUt3cEFVOC01RlNqcnBncVRwUmZPLTNFZ2RZVlV0M01kUEEtNjdra3ZOUm1uLVVXOGx4Q254ZDN4ZXQzZmo1TkNGXzBDMklKd2NFd2xyYUxFNEV0N3RQWUUxczlCeDlVZ3REQ09SYlIxbWVkLW03TGhMOEFtWFlRRTh3ZWM4VXhvS209PSIsInVpZCI6Mjc1MTAxN30=&code=JcLcvV4Hw08kKthvbW61VN5N1goGNlKcSWW1hUzUXG5NDsEdZ3cLB64rOA3E0VL4P5GNduTPiKGw05BTkIUgL0Pu0ugxBVLK0YLGY-OXfLi8Ub3Mx2QeN38ePuwJRRD0EYHqdeGmsHLVBHMj_oQp4mTESVgk8xTFKXnng-PTv113INkG1ifwVDJmxxG9sNikmiNfvakcVocNwwIvLgncLCgTq_XbfsSHNbacqW5YVCi6g5S=');
		Core_Utils_Log::write($content);die;
		$doc = Core_Dom_Query::newDocumentHTML($content,'UTF-8');
		$post_data = $doc->find('.timelineUnitContainer form')->serializeArray();
		$post_items = array();
		print_r($post_data);die;
		die('OK');
	}
}

