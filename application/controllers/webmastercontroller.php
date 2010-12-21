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
		$this->_template->render();  	  
	}
	function success() {	
		$msg = $_SESSION["msg"];
		$_SESSION["msg"] = null;
		$this->set("msg",$msg);
		$this->_template->render();  	  
	}
	function help() {	
		$this->_template->render();  	  
	}
	function active($account_id) {
		if($account_id==null)
			error("Lỗi! Đường link truy cập không hợp lệ");
		$url = BASE_PATH;
		if(isset($_SESSION['redirect_url']))
			$url = $_SESSION['redirect_url'];
		$this->set('redirect_url',$url);
		$this->set('account_id',$account_id);
		$this->_template->render();  	  
	}
	function resetpass() {
		$this->_template->render();  	  
	}
	function doActive($isAjax=false) {
		try {
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
			if(isset($_SESSION['account'])) {
				if($_SESSION['account']['id'] == $account_id)
					$_SESSION['account']['active'] = 1;
			}
			if($isAjax)
				success('Xác nhận tài khoản thành công!');
			echo 'DONE';
		} catch (Exception $e) {
			if($isAjax)
				error('Xác nhận tài khoản không thành công!');
			echo 'ERROR_SYSTEM';
		}
	}
	function doSendActiveCode() {
		try {
			if(!isset($_SESSION['sendactivecode']))
				$_SESSION['sendactivecode'] = 0;
			if($_SESSION['sendactivecode']>=MAX_SENDACTIVECODE)
				die('ERROR_MANYTIMES');
			$this->checkLogin(true);
			$account_id = $_SESSION['account']['id'];
			$this->setModel('activecode');
			$this->activecode->where(" and account_id=$account_id");
			$data = $this->activecode->search('active_code');
			if(empty($data))
				die('ERROR_SYSTEM');
			$active_code = $data[0]['activecode']['active_code'];
			//Send mail
			$_SESSION['sendactivecode'] = $_SESSION['sendactivecode'] + 1;
			echo 'DONE';
		} catch (Exception $e) {
			echo 'ERROR_SYSTEM';
		}
	}
	function afterAction() {

	}

}