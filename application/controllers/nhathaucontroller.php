<?php

class NhathauController extends VanillaController {
	function __construct($controller, $action) {		
		global $inflect;
		$this->_controller = ucfirst($controller);		
		$this->_action = $action;
		$model = "nhathau";
		$this->$model =& new $model;
		$this->_template =& new Template($controller,$action);
	}
	function beforeAction () {

	}
	//Admin functions
	function setModel($model) {
		 $this->$model =& new $model;
	}
    function listNhathaus($ipageindex) {
		//die("ERROR_NOTLOGIN");
		$this->checkAdmin();
		$this->nhathau->showHasOne(array("account"));
		$this->nhathau->orderBy('nhathau.id','desc');
		$this->nhathau->setPage($ipageindex);
		$this->nhathau->setLimit(PAGINATE_LIMIT);
		$lstNhathau = $this->nhathau->search("nhathau.id,displayname,gpkd_cmnd,username,diemdanhgia,nhanemail,type");
		$totalPages = $this->nhathau->totalPages();
		$ipagesbefore = $ipageindex - INT_PAGE_SUPPORT;
		if ($ipagesbefore < 1)
			$ipagesbefore = 1;
		$ipagesnext = $ipageindex + INT_PAGE_SUPPORT;
		if ($ipagesnext > $totalPages)
			$ipagesnext = $totalPages;
		//print_r($lstNhathau);die();
		$this->set("lstNhathau",$lstNhathau);
		$this->set('pagesindex',$ipageindex);
		$this->set('pagesbefore',$ipagesbefore);
		$this->set('pagesnext',$ipagesnext);
		$this->set('pageend',$totalPages);
		$this->_template->renderPage();
	}
	
	function saveNhathau() {
		try {
			$this->checkAdmin(true);
			$id = $_POST["nhathau_id"];
			$motachitiet = $_POST["nhathau_motachitiet"];
			$type = $_POST["nhathau_type"];
			$gpkd_cmnd = $_POST["nhathau_gpkd_cmnd"];
			$diemdanhgia = $_POST["nhathau_diemdanhgia"];
			$displayname = $_POST["nhathau_displayname"];
			if($id==null) { //insert
				die("ERROR_SYSTEM");						
			} 
			$this->setModel("nhathau");
			$this->nhathau->id = $id;
			$this->nhathau->motachitiet = $motachitiet;
			$this->nhathau->type = $type;
			$this->nhathau->gpkd_cmnd = $gpkd_cmnd;
			$this->nhathau->diemdanhgia = $diemdanhgia;
			$this->nhathau->displayname = $displayname;
			$this->nhathau->status = 1;
			$this->nhathau->update();
			echo "DONE";
		} catch (Exception $e) {
			echo 'ERROR_SYSTEM';
		}
	}    
	function exist($id=null){
		$this->checkAdmin(true);
		if($id==null)
			die("ERROR_SYSTEM");
		$this->nhathau->id = $id;
		$data = $this->nhathau->search();
		if(empty($data)) {
			echo "0";
		} else {
			echo "1";
		}
	}
	function linhvucquantam() {
		$this->checkAdmin(true);
		$nhathau_id = $_GET["nhathau_id"];
		if(isset($nhathau_id)) {
			$this->setModel("nhathaulinhvuc");
			$data = $this->nhathaulinhvuc->custom("select tenlinhvuc from nhathaulinhvucs as nhathaulinhvuc join linhvucs as linhvuc on nhathaulinhvuc.linhvuc_id = linhvuc.id where nhathau_id = '".mysql_real_escape_string($nhathau_id)."'");
			//print_r($data);
			$this->set("lstLinhvucquantam",$data);
			$this->_template->renderPage();	
		}
	}
	//User functions
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
	function checkActive($isAjax=false,$msg = 'Vui lòng kiểm tra email để xác nhận tài khoản!') {
		if($_SESSION['account']['active']==0) {
			if($isAjax == true) {
				die("ERROR_NOTACTIVE");
			} else {
				error($msg);
			}
		}
	}
	function checkLock($isAjax=false) {
		$this->setModel('account');
		$this->account->id = $_SESSION['account']['id'];
		$data = $this->account->search('active');
		if(empty($data) || $data['account']['active']==-1) {
			if($isAjax == true) {
				die("ERROR_LOCKED");
			} else {
				error('Tài khoản này đã bị khóa, vui lòng liên hệ admin@jobbid.vn để mở lại!');
			}
		}
		$this->setModel('nhathau');
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
	function checkNhathau($isAjax=false) {
		//die(getUrl());
		if(!isset($_SESSION['nhathau'])) {
			if($isAjax == true) {
				die("ERROR_MAKEPROFILE");
			} else {
				redirect(BASE_PATH.'/nhathau/view');
				die();
			}
		}
	}
	function getMotachitietById($id=null) {	
		if($id != null) {
			$id = mysql_real_escape_string($id);
			$this->nhathau->id=$id;
			$this->nhathau->where(' and nhathau.`status`>=0');
            $data=$this->nhathau->search();
			print_r($data['nhathau']['motachitiet']);
		}
	}
	function view() {
		$_SESSION['redirect_url'] = getUrl();
		$this->checkLogin();
		$this->nhathau->showHasOne(array("file"));
		$this->nhathau->where(" and nhathau.`status`>=0 and nhathau.account_id = ".$_SESSION["account"]["id"]);
		$data = $this->nhathau->search("nhathau.id,motachitiet,displayname,diemdanhgia,nhanemail,filename,file.id,nhathau.account_id,gpkd_cmnd,type,birthyear,diachilienhe");
		if(empty($data)==false) {
			$this->set("nhathau",$data[0]);
			$this->setModel("nhathaulinhvuc");
			$data = $this->nhathaulinhvuc->custom("select tenlinhvuc from nhathaulinhvucs as nhathaulinhvuc join linhvucs as linhvuc on nhathaulinhvuc.linhvuc_id = linhvuc.id where nhathau_id = ".$data[0]["nhathau"]["id"]);
			$this->set("lstLinhvucquantam",$data);
		}
		$this->set("dataAccount",$_SESSION["account"]);
		$this->_template->render();	
	}
	function add() {
		$_SESSION['redirect_url'] = getUrl();
		$this->checkLogin();
		$this->checkActive(false,'Bạn cần xác nhận tài khoản mới có thể tạo hồ sơ thầu!');
		$this->checkLock();
		$this->setModel("linhvuc");
		$data = $this->linhvuc->search();
		$this->set("lstLinhvuc",$data);
		$this->_template->render();	
	}	
	function doAdd() {
		try {
			$this->checkLogin(true);
			$this->checkActive(true,'Bạn cần xác nhận tài khoản mới có thể tạo hồ sơ thầu!');
			$this->checkLock(true);
			$validate = new Validate();
			if($validate->check_submit(1,array("nhathau_birthyear","nhathau_diachilienhe","account_sodienthoai","nhathau_motachitiet","nhathau_displayname","nhathau_gpkd_cmnd","nhathau_type"))==false)
				die('ERROR_SYSTEM');
			$sodienthoai = $_POST["account_sodienthoai"];
			$motachitiet = $_POST["nhathau_motachitiet"];
			$displayname = $_POST["nhathau_displayname"];
			$gpkd_cmnd = $_POST["nhathau_gpkd_cmnd"];
			$birthyear = $_POST["nhathau_birthyear"];
			$diachilienhe = $_POST["nhathau_diachilienhe"];
			$type = $_POST["nhathau_type"];
			$nhanemail = isset($_POST["nhathau_nhanemail"])?1:0;
			$validate = new Validate();
			if($validate->check_null(array($sodienthoai,$displayname,$gpkd_cmnd))==false)
				die('ERROR_SYSTEM');
			$account_id = $_SESSION["account"]["id"];
			$this->nhathau->where(" and account_id= $account_id ");
			$data = $this->nhathau->search("id");
			if(!empty($data))
				die("ERROR_SYSTEM");
			$file_id = 0;
			//Get upload attach file_id
			global $cache;
			$ma=time();
			if($_FILES['nhathau_file']['name']!=NULL) {
				$str=$_FILES['nhathau_file']['tmp_name'];
				$size= $_FILES['nhathau_file']['size'];
				if($size==0) {
					echo 'ERROR_FILESIZE';
				}
				else {
					$dir = ROOT . DS . 'public'. DS . 'upload' . DS . 'files' . DS;
					$filename = preg_replace("/[&' +-]/","_",$_FILES['nhathau_file']['name']);				
					move_uploaded_file($_FILES['nhathau_file']['tmp_name'],$dir . $filename);
					//die($filename);
					$sFileType="";
					$i = strlen($filename)-1;
					while($i>=0) {
						if($filename[$i]=='.')
							break;
						$sFileType=$filename[$i].$sFileType;
						$i--;
					}
					$str=$dir . $filename;
					$fname=$ma.'_'.$filename;
					$arrType = $cache->get("fileTypes");
					if(!in_array(strtolower($sFileType),$arrType)) {
						unlink($str);
						die("ERROR_WRONGFORMAT");
					}
					else {
						$str2= $dir . $fname;
						rename($str,$str2);
						$this->setModel("file");
						$this->file->id = null;
						$this->file->filename = $filename;
						$this->file->fileurl = BASE_PATH."/upload/files/".$fname;
						$this->file->account_id = $_SESSION["account"]["id"];
						$this->file->status = 1;
						$file_id = $this->file->insert(true);
					}
				}
			}
			//End
			$this->nhathau->id = null;
			$this->nhathau->motachitiet = $motachitiet;
			$this->nhathau->displayname = $displayname;
			$this->nhathau->gpkd_cmnd = $gpkd_cmnd;
			$this->nhathau->birthyear = $birthyear;
			$this->nhathau->diachilienhe = $diachilienhe;
			$this->nhathau->type = $type;
			$this->nhathau->file_id = $file_id;
			$this->nhathau->account_id = $account_id;
			$this->nhathau->nhanemail = $nhanemail;
			$this->nhathau->diemdanhgia = 0;
			$this->nhathau->status = 1;
			$nhathau_id = $this->nhathau->insert(true);
			if($sodienthoai != $_SESSION["account"]["sodienthoai"]) {
				$this->setModel("account");
				$this->account->id = $account_id;
				$this->account->sodienthoai = $sodienthoai;
				$this->account->update();
				$_SESSION["account"]["sodienthoai"] = $sodienthoai;
			}
			if(isset($_POST["nhathau_linhvuc"])) {
				$lstLinhvuc = $_POST["nhathau_linhvuc"];
				$this->setModel("nhathaulinhvuc");
				foreach($lstLinhvuc as $linhvuc_id) {
					$this->nhathaulinhvuc->id=null;
					$this->nhathaulinhvuc->nhathau_id=$nhathau_id;
					$this->nhathaulinhvuc->linhvuc_id=$linhvuc_id;
					$this->nhathaulinhvuc->save();
				}
			}
			$this->setModel("nhathau");
			$this->nhathau->id = $nhathau_id;
			$nhathau = $this->nhathau->search("id,displayname,account_id,diemdanhgia");
			if(!empty($nhathau))
				$_SESSION["nhathau"] = $nhathau["nhathau"];
			echo "DONE";
		} catch (Exception $e) {
			echo 'ERROR_SYSTEM';
		}
	}
	function edit() {
		$_SESSION['redirect_url'] = getUrl();
		$this->checkLogin();
		$this->checkActive();
		$this->checkNhathau();
		$this->checkLock();
		//print_r($_SESSION["nhathau"]["nhathau"]["id"]);die();
		$this->nhathau->showHasOne();
		$this->nhathau->id = $_SESSION["nhathau"]["id"];
		$this->nhathau->where(' and nhathau.`status`>=0');
		$data = $this->nhathau->search('nhathau.id,motachitiet,displayname,diemdanhgia,nhanemail,filename,file.id,nhathau.account_id,username,sodienthoai,gpkd_cmnd,type,birthyear,diachilienhe');
		if(!empty($data)) {
			$this->set("nhathau",$data["nhathau"]);
			$this->set("account",$data["account"]);
			$this->set("file",$data["file"]);
			$this->setModel("nhathaulinhvuc");
			$data = $this->nhathaulinhvuc->custom("select linhvuc.id from nhathaulinhvucs as nhathaulinhvuc join linhvucs as linhvuc on nhathaulinhvuc.linhvuc_id = linhvuc.id where nhathau_id = ".$data["nhathau"]["id"]);
			$this->set("lstLinhvucquantam",$data);
			$this->setModel("linhvuc");
			$data = $this->linhvuc->search();
			$this->set("lstLinhvuc",$data);
			$this->_template->render();
		}
	}	
	function doEdit() {
		try {
			$this->checkLogin(true);
			$this->checkActive(true,'Bạn cần phải xác nhận tài khoản mới có thể tạo hồ sơ thầu!');
			$this->checkNhathau(true);
			$this->checkLock(true);
			$validate = new Validate();
			if($validate->check_submit(1,array("nhathau_id","nhathau_birthyear","nhathau_diachilienhe","account_sodienthoai","nhathau_motachitiet","nhathau_displayname","nhathau_gpkd_cmnd","nhathau_type"))==false)
				die('ERROR_SYSTEM');
			$id = $_POST["nhathau_id"];
			$sodienthoai = $_POST["account_sodienthoai"];
			$motachitiet = $_POST["nhathau_motachitiet"];
			$displayname = $_POST["nhathau_displayname"];
			$birthyear = $_POST["nhathau_birthyear"];
			$diachilienhe = $_POST["nhathau_diachilienhe"];
			$gpkd_cmnd = $_POST["nhathau_gpkd_cmnd"];
			$type = $_POST["nhathau_type"];
			$nhanemail = isset($_POST["nhathau_nhanemail"])?1:0;
			if($validate->check_null(array($id,$sodienthoai,$displayname,$gpkd_cmnd))==false)
				die('ERROR_SYSTEM');
			$account_id = $_SESSION["account"]["id"];
			$this->nhathau->id = $id;
			$data = $this->nhathau->search("account_id");
			if(empty($data))
				die("ERROR_SYSTEM");
			if($data["nhathau"]["account_id"] != $account_id)
				die("ERROR_SYSTEM");
			$file_id = 0;
			//Get upload attach file_id
			global $cache;
			$ma=time();
			if($_FILES['nhathau_file']['name']!=NULL) {
				$str=$_FILES['nhathau_file']['tmp_name'];
				$size= $_FILES['nhathau_file']['size'];
				if($size==0) {
					echo 'ERROR_FILESIZE';
				}
				else {
					$dir = ROOT . DS . 'public'. DS . 'upload' . DS . 'files' . DS;
					$filename = preg_replace("/[&' +-]/","_",$_FILES['nhathau_file']['name']);				
					move_uploaded_file($_FILES['nhathau_file']['tmp_name'],$dir . $filename);
					//die($filename);
					$sFileType="";
					$i = strlen($filename)-1;
					while($i>=0) {
						if($filename[$i]=='.')
							break;
						$sFileType=$filename[$i].$sFileType;
						$i--;
					}
					$str=$dir . $filename;
					$fname=$ma.'_'.$filename;
					$arrType = $cache->get("fileTypes");
					if(!in_array(strtolower($sFileType),$arrType)) {
						unlink($str);
						die("ERROR_WRONGFORMAT");
					}
					else {
						$str2= $dir . $fname;
						rename($str,$str2);
						$this->setModel("file");
						$this->file->id = null;
						$this->file->filename = $filename;
						$this->file->fileurl = BASE_PATH."/upload/files/".$fname;
						$this->file->account_id = $_SESSION["account"]["id"];
						$this->file->status = 1;
						$file_id = $this->file->insert(true);
					}
				}
			}
			//End
			$this->nhathau->id = $id;
			$this->nhathau->motachitiet = $motachitiet;
			$this->nhathau->displayname = $displayname;
			if($file_id!=0)
				$this->nhathau->file_id = $file_id;
			$this->nhathau->nhanemail = $nhanemail;
			$this->nhathau->gpkd_cmnd = $gpkd_cmnd;
			$this->nhathau->birthyear = $birthyear;
			$this->nhathau->diachilienhe = $diachilienhe;
			$this->nhathau->type = $type;
			$this->nhathau->update();
			
			if($sodienthoai != $_SESSION["account"]["sodienthoai"]) {
				$this->setModel("account");
				$this->account->id = $account_id;
				$this->account->sodienthoai = $sodienthoai;
				$this->account->update();
				$_SESSION["account"]["sodienthoai"] = $sodienthoai;
			}
			$this->setModel("nhathaulinhvuc");
			$this->nhathaulinhvuc->custom("delete from nhathaulinhvucs where nhathau_id='$id'");
			if(isset($_POST["nhathau_linhvuc"])) {
				$lstLinhvuc = $_POST["nhathau_linhvuc"];
				foreach($lstLinhvuc as $linhvuc_id) {
					$this->nhathaulinhvuc->id=null;
					$this->nhathaulinhvuc->nhathau_id=$id;
					$this->nhathaulinhvuc->linhvuc_id=$linhvuc_id;
					$this->nhathaulinhvuc->save();
				}
			}
			$this->setModel("nhathau");
			$this->nhathau->id = $id;
			$nhathau = $this->nhathau->search("id,displayname,account_id,diemdanhgia");
			if(!empty($nhathau))
				$_SESSION["nhathau"] = $nhathau["nhathau"];
			echo "DONE";
		} catch (Exception $e) {
			echo 'ERROR_SYSTEM';
		}
	}
	
	function doChecknhathau() {
		$this->checkLogin(true);
		$this->checkActive(true);
		$this->checkNhathau(true);
		$this->checkLock(true);
		$duan_id = $_GET['duan_id'];
		if($duan_id == null)
			die('ERROR_SYSTEM');
		$account_id = $_SESSION['account']['id'];
		$nhathau_id = $_SESSION['nhathau']['id'];
		$duan_id = mysql_real_escape_string($duan_id);
		$this->setModel("duan");
		$this->duan->id = $duan_id;
		$this->duan->where(" and active=1 and nhathau_id is null");
		$data = $this->duan->search("id,account_id,UNIX_TIMESTAMP(ngayketthuc)-UNIX_TIMESTAMP(now()) as lefttime,lastbid_nhathau");
		if(empty($data))
			die("ERROR_SYSTEM");
		if($data[""]["lefttime"] <= 0)
			die("ERROR_EXPIRED");
		$employerId = $data["duan"]["account_id"];
		if($employerId == $account_id)
			die("ERROR_SELFBID");
		if($data["duan"]["lastbid_nhathau"] == $nhathau_id)
			die("ERROR_DUPLICATE");
		echo 'DONE';
	}
	function afterAction() {

	}

}