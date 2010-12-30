<?php

class FileController extends VanillaController {
	function __construct($controller, $action) {		
		global $inflect;
		$this->_controller = ucfirst($controller);
		$this->_action = $action;
		$model = "file";
		$this->$model =& new $model;
		$this->_template =& new Template($controller,$action);

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
	function beforeAction () {
		performAction('webmaster', 'updateStatistics');
	}
	function setModel($model) {
		 $this->$model =& new $model;
	}
	function download($id) {
		$this->checkLogin();
		if(!empty($id)) {
			if(!isset($_SESSION['filedownloads']))
				$_SESSION['filedownloads'] = 0;
			if($_SESSION['filedownloads']>=MAX_FILEDOWNLOADS) {
				$cache_expire = session_cache_expire();
				error("Bạn đã download quá nhiều file. Vui lòng đợi $cache_expire phút để download file tiếp theo!");
			}
			$this->file->id = $id;
			$data = $this->file->search();
			if(empty($data)) 
				error("File download không tồn tại!");
			$data = $data["file"];
			if($data["account_share"]!=null) {
				$account_id = $_SESSION["account"]["id"];
				if($account_id != $data["account_share"] && $account_id != $data["account_id"])
					error("Bạn không được phép download file này!");
			}
			$_SESSION['filedownloads'] = $_SESSION['filedownloads'] + 1;
			redirect($data["fileurl"]);
		}
	}
	
	function afterAction() {

	}

}