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
	function upload() {
		try {
			$file_id = null;
			//Get upload attach file_id
			global $cache;
			$ma=time();
			if($_FILES['fileupload']['name']==NULL)
				die('ERROR_SYSTEM');
			$str=$_FILES['fileupload']['tmp_name'];
			$size= $_FILES['fileupload']['size'];
			if($size==0) {
				die('ERROR_FILESIZE');
			} else {
				$dir = ROOT . DS . 'public'. DS . 'upload' . DS . 'files' . DS;
				$filename = preg_replace("/[&' +-]/","_",$_FILES['fileupload']['name']);				
				move_uploaded_file($_FILES['fileupload']['tmp_name'],$dir . $filename);
				//die($filename);
				$sFileType='';
				$i = strlen($filename)-1;
				while($i>=0) {
					if($filename[$i]=='.')
						break;
					$sFileType=$filename[$i].$sFileType;
					$i--;
				}
				$str=$dir . $filename;
				$fname=$ma.'_'.$filename;
				$arrType = $cache->get('fileTypes');
				if(!in_array(strtolower($sFileType),$arrType)) {
					unlink($str);
					die('ERROR_WRONGFORMAT');
				}
				else {
					$str2= $dir . $fname;
					rename($str,$str2);
					$this->setModel('file');
					$this->file->id = null;
					$this->file->filename = $filename;
					$this->file->fileurl = BASE_PATH.'/upload/files/'.$fname;
					$this->file->status = 1;
					$file_id = $this->file->insert(true);
				}
			}
			echo $file_id;
		} catch (Exception $e) {
			echo 'ERROR_SYSTEM';
		}
	}
	function afterAction() {

	}

}