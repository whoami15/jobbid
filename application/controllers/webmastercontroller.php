<?php

class WebmasterController extends VanillaController {
	function __construct($controller, $action) {		
		global $inflect;
		$this->_controller = ucfirst($controller);		
		$this->_action = $action;
		$this->_template =& new Template($controller,$action);
	}
	function beforeAction () {
	}
	function setModel($model) {
		 $this->$model =& new $model;
	}
	function checkLogin($isAjax=false) {
		if(!isset($_SESSION['account'])) {
			if($isAjax == true) {
				die("ERROR_NOTLOGIN");
			} else {
				redirect(BASE_PATH.'/account/login');
				die();
			}
		}
	}
	function error() {	
		$msg = $_SESSION["msg"];
		$_SESSION["msg"] = null;
		$this->set("msg",$msg);
		$this->set('title','Thông báo : Có lỗi xảy ra!');
		$this->_template->render();  	  
	}
	function success() {	
		$msg = $_SESSION["msg"];
		$_SESSION["msg"] = null;
		$this->set("msg",$msg);
		$this->_template->render();  	  
	}
	function help() {	
		$this->updateStatistics();
		$this->_template->render();  	  
	}
	function activesuccess() {	
		$this->updateStatistics();
		$this->set('title','Thông báo : Đã xác nhận tài khoản thành công!');
		$this->_template->render();  	  
	}
	function registcomplete() {	
		$this->updateStatistics();
		$this->set('title','Bước 4: Hoàn tất đăng ký');
		$this->_template->render();  	  
	}
	function active($account_id=null) {
		if($account_id==null) {
			if(!isset($_SESSION['account']))
				error("Lỗi! Đường link truy cập không hợp lệ");
			else
				$account_id = $_SESSION['account']['id'];
		}
		$this->updateStatistics();
		$url = BASE_PATH;
		if(isset($_SESSION['redirect_url']))
			$url = $_SESSION['redirect_url'];
		$this->set('redirect_url',$url);
		$this->set('account_id',$account_id);
		$this->set('title','Bước 2: Kích hoạt tài khoản');
		$this->_template->render();  	  
	}
	function resetpass() {
		$this->updateStatistics();
		$this->set('title','Jobbid.vn - Hỗ trợ khôi phục mật khẩu');
		$this->_template->render();  	  
	}
	function doActive($isAjax=false) {
		try {
			$this->updateStatistics();
			//Validate data submit
			$validate = new Validate();
			if($validate->check_submit(2,array("account_id","active_code"))==false)
				die('ERROR_SYSTEM');
			$account_id = $_GET['account_id'];
			$active_code = $_GET['active_code'];
			$this->setModel('activecode');
			$account_id = mysql_real_escape_string($account_id);
			$active_code = mysql_real_escape_string($active_code);
			if($validate->check_null(array($account_id,$active_code))==false)
				die('ERROR_SYSTEM');
			//End validate
			$this->activecode->where(" and account_id=$account_id and active_code='$active_code'");
			$data = $this->activecode->search();
			if(empty($data)) {
				if($isAjax)
					error('Xác nhận tài khoản không thành công!');
				die('ERROR_WRONG');
			}
			$this->activecode->id = $data[0]['activecode']['id'];
			$this->activecode->delete();
			$this->setModel('account');
			$this->account->id = $account_id;
			$this->account->active = 1;
			$this->account->update();
			if(isset($_SESSION['account']) && $_SESSION['account']['id'] == $account_id) {
				$_SESSION['account']['active'] = 1;
			} else {
				$this->account->id = $account_id;
				$account = $this->account->search();
				$_SESSION['account'] = $account['account'];
			}
			$this->setModel('email');
			$email = $_SESSION['account']['username'];
			$this->email->where(" and email = '$email'");
			$data = $this->email->search();
			if(empty($data)) {
				$this->email->id = null;
				$this->email->email = $email;
				$this->email->insert();
			}
			$this->setModel('duan');
			$this->duan->active = 1;
			$this->duan->update(' active=-1 and account_id='.$account_id);
			$this->setModel('raovat');
			$this->raovat->status = 1;
			$this->raovat->update(' status=0 and account_id='.$account_id);
			$result = $this->raovat->custom("SELECT id,tieude,alias FROM `raovats` as `raovat` WHERE status=1 order by ngayupdate desc LIMIT 7 OFFSET 0");
			global $cache;
			$data = array();
			foreach($result as $raovat) {
				array_push($data,array('id'=>$raovat['raovat']['id'],'tieude'=>$raovat['raovat']['tieude'],'alias'=>$raovat['raovat']['alias']));
			}
			$cache->set('raovats',$data);
			if($isAjax) {
				redirect(BASE_PATH.'/account/updateinfo');
			} else
				echo 'DONE';
		} catch (Exception $e) {
			if($isAjax)
				error('Xác nhận tài khoản không thành công!');
			echo 'ERROR_SYSTEM';
		}
	}
	function doSendActiveCode() {
		try {
			$this->updateStatistics();
			if(!isset($_SESSION['sendactivecode']))
				$_SESSION['sendactivecode'] = 0;
			if($_SESSION['sendactivecode']>=MAX_SENDACTIVECODE)
				die('ERROR_MANYTIMES');
			$this->checkLogin(true);
			$account_id = $_SESSION['account']['id'];
			$username = $_SESSION['account']['username'];
			$this->setModel('activecode');
			$this->activecode->where(" and account_id=$account_id");
			$data = $this->activecode->search('active_code');
			if(empty($data))
				die('ERROR_SYSTEM');
			$active_code = $data[0]['activecode']['active_code'];
			//Send mail
			$linkactive = BASE_PATH."/webmaster/doActive/true&account_id=$account_id&active_code=$active_code";
			global $cache;
			$content = $cache->get('mail_verify');
			$search  = array('#LINKACTIVE#', '#ACTIVECODE#', '#USERNAME#');
			$replace = array($linkactive, $active_code, $username);
			$content = str_replace($search, $replace, $content);
			$senders = $cache->get('senders');
			$sender = $senders['priSender'];
			include (ROOT.DS.'library'.DS.'sendmail.php');
			$mail = new sendmail();
			$mail->send($username,'JobBid.vn - Mail Xác Nhận Đăng Ký Tài Khoản!',$content,$sender);
			$_SESSION['sendactivecode'] = $_SESSION['sendactivecode'] + 1;
			echo 'DONE';
		} catch (Exception $e) {
			echo 'ERROR_SYSTEM';
		}
	}
	function changepass($account_id,$rs_verify) {
		if($account_id == null || $rs_verify == null)
			error('Lỗi! Liên kết không hợp lệ!');
		$this->updateStatistics();
		$this->setModel('resetpassword');
		$account_id = mysql_real_escape_string($account_id);
		$rs_verify = mysql_real_escape_string($rs_verify);
		$this->resetpassword->where(" and account_id=$account_id and verify='$rs_verify'");
		$data = $this->resetpassword->search('id,account_id');
		if(empty($data))
			error('Lỗi! Sai mã xác nhận hoặc mã xác nhận này đã được sử dụng!');
		$_SESSION['resetpassword'] = $data[0]['resetpassword'];
		$this->_template->render();  
	}
	function updateStatistics() {
		$this->setModel('ppl_online');
		$now = GetDateSQL();
		if (! isset($_SESSION['online'])) {
			$this->ppl_online->id = null;
			if(!isset($_SERVER['HTTP_REFERER']))
				$this->ppl_online->refurl = null;
			$this->ppl_online->activity = $now;
			$this->ppl_online->access_time = $now;
			$this->ppl_online->ip_address = $_SERVER['REMOTE_ADDR'];
			$this->ppl_online->account_id = null;
			$this->ppl_online->user_agent = $_SERVER['HTTP_USER_AGENT'];
			$id = $this->ppl_online->insert(true);
			$_SESSION['online'] = $id; // đăng ký một biến session
		} else {
			if (isset($_SESSION['account'])) {
				$this->ppl_online->id = $_SESSION['online'];
				$this->ppl_online->activity = $now;
				$this->ppl_online->account_id = $_SESSION['account']['id'];
				$this->ppl_online->update();
			}
		}
		if (isset($_SESSION['online'])) {  // nếu là registered.
			$this->ppl_online->id = $_SESSION['online'];
			$this->ppl_online->activity = $now;
			$this->ppl_online->update();
		}
		$limit_time = time() - 300;
		$data = $this->ppl_online->custom("SELECT count(*) as nOnline FROM ppl_onlines WHERE UNIX_TIMESTAMP(activity) >= $limit_time");
		global $cache;
		$statistics = $cache->get('statistics');
		$statistics['nOnlines'] = $data[0]['']['nOnline'];
		$cache->set('statistics',$statistics);
	}
	function showStatistic() {
		global $cache;
		$statistics = $cache->get('statistics');
		$tAccounts = isset($statistics['tAccounts'])?$statistics['tAccounts']:'-';
		$tProjects = isset($statistics['tProjects'])?$statistics['tProjects']:'-';
		$tFreelancers = isset($statistics['tFreelancers'])?$statistics['tFreelancers']:'-';
		$nOnlines = isset($statistics['nOnlines'])?$statistics['nOnlines']:'-';
		$this->set('tAccounts',$tAccounts);
		$this->set('tProjects',$tProjects);
		$this->set('tFreelancers',$tFreelancers);
		$this->set('nOnlines',$nOnlines);
		$this->_template->renderPage();  
	}
	function contact() {
		$this->updateStatistics();
		$this->set('title','Jobbid.vn - Thông tin liên hệ');
		$this->_template->render();  
	}
	function afterAction() {

	}

}