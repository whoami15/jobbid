<?php

class AccountController extends VanillaController {
	function __construct($controller, $action) {		
		global $inflect;
		$this->_controller = ucfirst($controller);		
		$this->_action = $action;
		$model = "account";
		$this->$model =& new $model;
		$this->_template =& new Template($controller,$action);
	}
	function beforeAction () {

	}
	function checkAdmin($isAjax=false) {
		if($isAjax==false)
			$_SESSION['redirect_url'] = getUrl();
		if(!isset($_SESSION['account']) || $_SESSION["account"]["role"]>1) {
			if($isAjax == true) {
				die("ERROR_NOTLOGIN");
			} else {
				redirect(BASE_PATH.'/admin/login&reason=admin');
				die();
			}
		}
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
	function setModel($model) {
		 $this->$model =& new $model;
	}
	//Functions of Administrator
	function getAccountById($id=null) {	
		$this->checkAdmin(true);
		if($id != null && $id != 0) {
			$this->account->id=$id;
            return $this->account->search();
		}
		return null;
	}
    function listAccounts($ipageindex) {
		$this->checkAdmin();
		$this->account->orderBy('id','desc');
		$this->account->setPage($ipageindex);
		$this->account->setLimit(PAGINATE_LIMIT);
		$lstAccounts = $this->account->search();
		$totalPages = $this->account->totalPages();
		$ipagesbefore = $ipageindex - INT_PAGE_SUPPORT;
		if ($ipagesbefore < 1)
			$ipagesbefore = 1;
		$ipagesnext = $ipageindex + INT_PAGE_SUPPORT;
		if ($ipagesnext > $totalPages)
			$ipagesnext = $totalPages;
		$this->set("lstAccounts",$lstAccounts);
		$this->set('pagesindex',$ipageindex);
		$this->set('pagesbefore',$ipagesbefore);
		$this->set('pagesnext',$ipagesnext);
		$this->set('pageend',$totalPages);
		$this->_template->renderPage();
	}
	function saveAccount() {
		$this->checkAdmin(true);
		$id = $_POST["account_id"];
		$username = $_POST["account_username"];
		$password = $_POST["account_password"];
		$sodienthoai = $_POST["account_sodienthoai"];
		$role = $_POST["account_role"];
		$active = $_POST["account_active"];
		if(isEmpty($username))
			die("ERROR_SYSTEM");
		if($id==null) { //insert
			if($this->existUsername($username))
				die("ERROR_EXIST");
			if(isEmpty($password))
				die("ERROR_SYSTEM");
			$this->account->id = null;
			$this->account->username = $username;
			$this->account->password = md5($password);
			$this->account->sodienthoai = $sodienthoai;
			$this->account->timeonline = 0;
			$this->account->role = $role;
			$this->account->active = $active;
			$this->account->save();						
		} else { //update
			if(!$this->existUsername($username))
				die("ERROR_NOTEXIST");
			$this->account->id = $id;
			$this->account->username = $username;
			if(isEmpty($password)==false)
				$this->account->password = md5($password);
			$this->account->sodienthoai = $sodienthoai;
			$this->account->role = $role;
			$this->account->active = $active;
			$this->account->save();		
		}
		echo "DONE";
	}  
	
	//Functions of User
	function existUsername($username=null) {
		if($username!=null) {
			$strWhere = "AND username='".mysql_real_escape_string($username)."'";
			$this->account->where($strWhere);
			$account = $this->account->search("id");
			if(empty($account))
				return false;
			else
				return true;
		}
		return false;
	}
	function doLogin($type="admin") {
		$username = $_POST["username"];
		$password = $_POST["password"];
		$url = BASE_PATH;
		if(isset($_SESSION['redirect_url']))
			$url = $_SESSION['redirect_url'];
		if(isEmpty($username) || isEmpty($password)) {
			redirect(BASE_PATH."/$type/login");
			die();
		}
		$strWhere = "AND username='".mysql_real_escape_string($username)."' AND active>=0";
		$this->account->where($strWhere);
		$account = $this->account->search();
		if(empty($account)) {
			redirect(BASE_PATH."/$type/login&username=$username&reason=username");
		} else {
			if(strcmp(md5($password),$account[0]["account"]["password"])!=0) {
				redirect(BASE_PATH."/$type/login&username=$username&reason=password");
			} else { //Login thanh cong
				$_SESSION["account"] = $account[0]['account'];
				$this->account->id = $account[0]["account"]["id"];
				$this->account->lastlogin = GetDateSQL();
				$this->account->save();
				$this->setModel("nhathau");
				$this->nhathau->where(" and account_id=".$account[0]["account"]["id"]);
				$nhathau = $this->nhathau->search("id,displayname,account_id,diemdanhgia");
				if(!empty($nhathau))
					$_SESSION["nhathau"] = $nhathau[0]["nhathau"];
				redirect($url);
			}
		}
	}
	function doRegist() {
		try {
			if( $_SESSION['security_code'] == $_POST['security_code'] && !empty($_SESSION['security_code'] ) ) {
				unset($_SESSION['security_code']);
			} else {
				die("ERROR_SECURITY_CODE");
			}
			$validate = new Validate();
			if($validate->check_submit(1,array("account_username","account_password","account_sodienthoai"))==false)
				die('ERROR_SYSTEM');
			$username = $_POST["account_username"];
			$password = $_POST["account_password"];
			$sodienthoai = $_POST["account_sodienthoai"];
			if($validate->check_null(array($username,$password,$sodienthoai))==false)
				die('ERROR_SYSTEM');
			if(!$validate->check_email($username))
				die("ERROR_SYSTEM");
			if(!$validate->check_length($password,5))
				die("ERROR_SYSTEM");
			if($this->existUsername($username))
				die("ERROR_EXIST");
			$this->account->id = null;
			$this->account->username = $username;
			$this->account->password = md5($password);
			$this->account->sodienthoai = $sodienthoai;
			$this->account->timeonline = 0;
			$this->account->role = 2;
			$this->account->active = 0;
			$account_id = $this->account->insert(true);
			$this->setModel('activecode');
			$this->activecode->id = null;
			$this->activecode->account_id = $account_id;
			$this->activecode->active_code = genString();
			$this->activecode->insert();
			echo "DONE";
		} catch (Exception $e) {
			echo 'ERROR_SYSTEM';
		}
	}
	function doLogout($type="admin") {
		if(isset($_SESSION["account"]))
			$_SESSION["account"] = null;
		if(isset($_SESSION["nhathau"]))
			$_SESSION["nhathau"] = null;
		if(isset($_SESSION["redirect_url"]))
			$_SESSION["redirect_url"] = null;
		redirect(BASE_PATH."/$type/login");
	}
	function getSuggestionAccount() {
		$key = $_POST["keyword"];
		if(isset($key)) {
			$sql = "select username from `accounts` as `account` where active>=0 and username like '$key%' LIMIT 8 OFFSET 0";
			$data = $this->account->custom($sql);
			foreach($data as $account) {
				echo '<li onClick="fill(\''.$account["account"]["username"].'\');">'.$account["account"]["username"].'</li>';
			}
			
		}
	}	
	function register() {
		$this->_template->render();
	}
	function registsuccess() {
		$this->_template->render();
	}
	function login() {		
		$this->_template->render();  	  
	}
	function doUpdate() {
		try {
			$this->checkLogin(true);
			$account_id = $_SESSION["account"]["id"];
			$oldpassword = $_POST["account_oldpassword"];
			$sodienthoai = $_POST["account_sodienthoai"];
			$validate = new Validate();
			if($oldpassword != "") {
				if(md5($oldpassword) != $_SESSION["account"]["password"])
					die("ERROR_WRONGPASSWORD");
				$password = $_POST["account_password"];
				if(!$validate->check_length($password,5))
					die("ERROR_SYSTEM");
				$this->account->password = md5($password);
			}
			$this->account->id = $account_id;
			$this->account->sodienthoai = $sodienthoai;
			$this->account->update();
			$this->account->id = $account_id;
			$data = $this->account->search();
			$_SESSION["account"] = $data;
			echo "DONE";
		} catch (Exception $e) {
			echo 'ERROR_SYSTEM';
		}
	}
	function afterAction() {

	}

}