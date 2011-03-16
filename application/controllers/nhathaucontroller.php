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
		performAction('webmaster', 'updateStatistics');
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
		$strWhere = '';
		if(isset($_POST['keyword'])) {
			$keyword = $_POST['keyword'];
			if($keyword!=null)
				$strWhere.=" and displayname like '%$keyword%'";
		}
		$this->nhathau->where($strWhere);
		$lstNhathau = $this->nhathau->search("nhathau.id,account.id,displayname,gpkd_cmnd,username,diemdanhgia,nhanemail,type");
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
			$id = null;
			if(isset($_POST["nhathau_id"]))
				$id = $_POST["nhathau_id"];
			$account_id = null;
			if(isset($_POST["account_id"]))
				$account_id = $_POST["account_id"];
			$motachitiet = $_POST["nhathau_motachitiet"];
			$type = $_POST["nhathau_type"];
			$gpkd_cmnd = $_POST["nhathau_gpkd_cmnd"];
			$diemdanhgia = $_POST["nhathau_diemdanhgia"];
			$displayname = $_POST["nhathau_displayname"];
			$nhathau_alias = $_POST["nhathau_alias"];
			$password = $_POST['account_password'];
			if($id==null) {
				$this->setModel('account');
				$username = $_POST['account_username'];
				$this->account->where(" and username='$username'");
				$data = $this->account->search('id');
				if(empty($data)==false)
					die('ERROR_EXIST');
				$this->account->id = null;
				$this->account->username = $username;
				$this->account->password = md5($password);
				$this->account->sodienthoai = '0904653712';
				$this->account->timeonline = 0;
				$this->account->role = 2;
				$this->account->active = 1;
				$account_id = $this->account->insert(true);
				$this->setModel('nhathau');
				$this->nhathau->id = null;
				$this->nhathau->motachitiet = $motachitiet;
				$this->nhathau->type = $type;
				$this->nhathau->gpkd_cmnd = $gpkd_cmnd;
				$this->nhathau->diemdanhgia = $diemdanhgia;
				$this->nhathau->displayname = $displayname;
				$this->nhathau->nhathau_alias = $nhathau_alias;
				$this->nhathau->account_id = $account_id;
				$this->nhathau->status = 1;
				$id = $this->nhathau->insert(true);
			} else {
				if($password!=null) {
					$this->setModel('account');
					$this->account->id = $account_id;
					$this->account->password = md5($password);
					$this->account->update();
					$this->setModel('nhathau');
				}
				$this->nhathau->id = $id;
				$this->nhathau->motachitiet = $motachitiet;
				$this->nhathau->type = $type;
				$this->nhathau->gpkd_cmnd = $gpkd_cmnd;
				$this->nhathau->diemdanhgia = $diemdanhgia;
				$this->nhathau->displayname = $displayname;
				$this->nhathau->nhathau_alias = $nhathau_alias;
				$this->nhathau->status = 1;
				$this->nhathau->update();
			}
			$this->setModel("nhathaulinhvuc");
			if(isset($_POST["nhathau_linhvuc"])) {
				$this->nhathaulinhvuc->custom("delete from nhathaulinhvucs where nhathau_id='$id'");
				$lstLinhvuc = $_POST["nhathau_linhvuc"];
				foreach($lstLinhvuc as $linhvuc_id) {
					$this->nhathaulinhvuc->id=null;
					$this->nhathaulinhvuc->nhathau_id=$id;
					$this->nhathaulinhvuc->linhvuc_id=$linhvuc_id;
					$this->nhathaulinhvuc->save();
				}
			} else {
				$this->nhathaulinhvuc->id=null;
				$this->nhathaulinhvuc->nhathau_id=$id;
				$this->nhathaulinhvuc->linhvuc_id= 'khac';
				$this->nhathaulinhvuc->save();
			}
			echo "DONE";
		} catch (Exception $e) {
			echo 'ERROR_SYSTEM';
		}
	}    
	function exist($id=null){
		$this->checkAdmin(true);
		if($id==null)
			die("0");
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
	function getLinhvucByNhathau($nhathau_id) {
		//$this->checkLogin(true);
		if($nhathau_id==null)
			die("ERROR_SYSTEM");
		$this->setModel("nhathaulinhvuc");
		$data = $this->nhathaulinhvuc->custom("select linhvuc.id from nhathaulinhvucs as nhathaulinhvuc join linhvucs as linhvuc on nhathaulinhvuc.linhvuc_id = linhvuc.id where nhathau_id = '".mysql_real_escape_string($nhathau_id)."'");
		$jsonResult = "{";
		$i=0;
		$len = count($data);
		while($i<$len) {
			$linhvuc = $data[$i];
			$jsonResult = $jsonResult."$i:{'id':'".$linhvuc["linhvuc"]["id"]."'}";
			if($i < $len-1)
				$jsonResult = $jsonResult.",";
			$i++;
		}
		$jsonResult = $jsonResult."}";
		print($jsonResult);
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
		$this->set('title','Xem Thông Tin Hồ Sơ Cá Nhân');
		$this->_template->render();	
	}
	function add() {
		//$_SESSION['redirect_url'] = getUrl();
		$this->checkLogin();
		$this->checkActive(false,'Bạn cần xác nhận tài khoản mới có thể tạo hồ sơ thầu!');
		$this->checkLock();
		$this->setModel("linhvuc");
		$data = $this->linhvuc->search();
		$this->set("lstLinhvuc",$data);
		$this->set('title','Jobbid.vn - Tạo Hồ Sơ Nhà Thầu');
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
			$nhathau_alias = $_POST["nhathau_alias"];
			$gpkd_cmnd = $_POST["nhathau_gpkd_cmnd"];
			$birthyear = $_POST["nhathau_birthyear"];
			$diachilienhe = $_POST["nhathau_diachilienhe"];
			$type = $_POST["nhathau_type"];
			$nhanemail = isset($_POST["nhathau_nhanemail"])?1:0;
			$validate = new Validate();
			if($validate->check_null(array($sodienthoai,$displayname))==false)
				die('ERROR_SYSTEM');
			$account_id = $_SESSION["account"]["id"];
			$this->nhathau->where(" and account_id= $account_id ");
			$data = $this->nhathau->search("id");
			if(!empty($data))
				die("ERROR_SYSTEM");
			$file_id = null;
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
			$this->nhathau->nhathau_alias = $nhathau_alias;
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
			$this->setModel("nhathaulinhvuc");
			if(isset($_POST["nhathau_linhvuc"])) {
				$lstLinhvuc = $_POST["nhathau_linhvuc"];
				foreach($lstLinhvuc as $linhvuc_id) {
					$this->nhathaulinhvuc->id=null;
					$this->nhathaulinhvuc->nhathau_id=$nhathau_id;
					$this->nhathaulinhvuc->linhvuc_id=$linhvuc_id;
					$this->nhathaulinhvuc->save();
				}
			} else {
				$this->nhathaulinhvuc->id=null;
				$this->nhathaulinhvuc->nhathau_id=$nhathau_id;
				$this->nhathaulinhvuc->linhvuc_id= 'khac';
				$this->nhathaulinhvuc->save();
			}
			$this->setModel("nhathau");
			$this->nhathau->id = $nhathau_id;
			$nhathau = $this->nhathau->search("id,displayname,account_id,diemdanhgia,nhathau_alias");
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
			$this->set('title','Jobbid.vn - Chỉnh Sửa Hồ Sơ Nhà Thầu');
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
			$nhathau_alias = $_POST["nhathau_alias"];
			$birthyear = $_POST["nhathau_birthyear"];
			$diachilienhe = $_POST["nhathau_diachilienhe"];
			$gpkd_cmnd = $_POST["nhathau_gpkd_cmnd"];
			$type = $_POST["nhathau_type"];
			$nhanemail = isset($_POST["nhathau_nhanemail"])?1:0;
			if($validate->check_null(array($id,$sodienthoai,$displayname))==false)
				die('ERROR_SYSTEM');
			$account_id = $_SESSION["account"]["id"];
			$this->nhathau->id = $id;
			$data = $this->nhathau->search("account_id");
			if(empty($data))
				die("ERROR_SYSTEM");
			if($data["nhathau"]["account_id"] != $account_id)
				die("ERROR_SYSTEM");
			$file_id = null;
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
			$this->nhathau->nhathau_alias = $nhathau_alias;
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
			} else {
				$this->nhathaulinhvuc->id=null;
				$this->nhathaulinhvuc->nhathau_id=$id;
				$this->nhathaulinhvuc->linhvuc_id= 'khac';
				$this->nhathaulinhvuc->save();
			}
			$this->setModel("nhathau");
			$this->nhathau->id = $id;
			$nhathau = $this->nhathau->search("id,displayname,account_id,diemdanhgia,nhathau_alias");
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
		//$this->checkNhathau(true);
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
	function xem_ho_so($nhathau_id) {
		if($nhathau_id==null)
			error('Liên kết bị lỗi!');
		$_SESSION['redirect_url'] = getUrl();
		$this->nhathau->showHasOne(array('file'));
		$this->nhathau->id = $nhathau_id;
		$this->nhathau->where(' and nhathau.`status` = 1');
		$data = $this->nhathau->search('nhathau.id,motachitiet,displayname,diemdanhgia,nhanemail,nhathau.account_id,file.id,filename,gpkd_cmnd,type,birthyear,diachilienhe');
		if(empty($data))
			error('Không tìm thấy thông tin nhà thầu này!');
		$this->set('title','Thông tin nhà thầu : '.$data['nhathau']['displayname']);
		$this->set("nhathau",$data["nhathau"]);
		$this->set("file",$data["file"]);
		$this->setModel("nhathaulinhvuc");
		$data = $this->nhathaulinhvuc->custom("select tenlinhvuc from nhathaulinhvucs as nhathaulinhvuc join linhvucs as linhvuc on nhathaulinhvuc.linhvuc_id = linhvuc.id where nhathau_id = ".$data["nhathau"]["id"]);
		$this->set("lstLinhvucquantam",$data);
		//load du an da trung thau theo nha thau
		$nhathau_id = mysql_real_escape_string($nhathau_id);
		$this->setModel('duan');
		$this->duan->where(" and nhathau_id = $nhathau_id");
		$this->duan->orderBy("timeupdate","desc");
		$data = $this->duan->search("id,tenduan,alias");
		$this->set("lstDuanTrungThau",$data);
		$this->_template->render();
	}
	function doAddMoiThau($account_id=null,$duan_id=null) {
		if($duan_id == null || $account_id == null)
			die('ERROR_SYSTEM');
		try {
			$this->checkLogin(true);
			$this->checkActive(true);
			$this->checkLock(true);
			$this->setModel('moithau');
			$employer_id = $_SESSION['account']['id'];
			$account_id = mysql_real_escape_string($account_id);
			$duan_id = mysql_real_escape_string($duan_id);
			$this->nhathau->showHasOne(array('account'));
			$this->nhathau->where(" and `status`=1 and account_id=$account_id");
			$data = $this->nhathau->search('nhathau.id,username');
			if(empty($data))
				die('ERROR_SYSTEM');
			$email = $data[0]['account']['username'];
			$this->setModel('duan');
			$this->duan->showHasOne(array('linhvuc'));
			$this->duan->id = $duan_id;
			$this->duan->where(" and duan.active=1 and duan.nhathau_id is null and ngayketthuc>now() and account_id=$employer_id");
			$data = $this->duan->search('duan.id,tenduan,costmax,costmin,tenlinhvuc');
			if(empty($data))
				die('ERROR_SYSTEM');
			$chiphi = formatMoney($data["duan"]["costmin"]).' đến '.formatMoney($data["duan"]["costmax"]);
			$linkmoithau = BASE_PATH.'/moithau/viewMyLetters';
			$linkmoithau = "<a href='$linkmoithau'>$linkmoithau</a>";
			global $cache;
			$content = $cache->get('mail_moithau');
			$search  = array('#TENDUAN#', '#CHIPHI#', '#LINHVUC#', '#LINKMOITHAU#');
			$replace = array($data['duan']['tenduan'], $chiphi, $data['linhvuc']['tenlinhvuc'], $linkmoithau);
			$content = str_replace($search, $replace, $content);
			
			$this->setModel('moithau');
			$this->moithau->where(" and duan_id=$duan_id and account_id=$account_id");
			$data = $this->moithau->search('id');
			if(!empty($data))
				die('ERROR_INVITED');
			$this->moithau->id = null;
			$this->moithau->account_id = $account_id;
			$this->moithau->duan_id = $duan_id;
			$this->moithau->time = GetDateSQL();
			$this->moithau->hadread = 0;
			$this->moithau->insert();
			//Gui mail_moithau
			$senders = $cache->get('senders');
			$sender = $senders['priSender'];
			include (ROOT.DS.'library'.DS.'sendmail.php');
			$mail = new sendmail();
			$mail->send($email,'Bạn Được Mời Thầu 1 Dự Án Trên JobBid.vn!',$content,$sender);
			echo 'DONE';
		} catch (Exception $e) {
			echo 'ERROR_SYSTEM';
		}
	}
	function tim_nha_thau($pageindex=1) {
		$_SESSION['redirect_url'] = getUrl();
		$this->nhathau->showHasOne(array('account'));
		$this->nhathau->orderBy('diemdanhgia','desc');
		$this->nhathau->setPage($pageindex);
		$this->nhathau->setLimit(PAGINATE_LIMIT);
		$this->nhathau->where(' and nhathau.`status`=1 and account.active=1');
		$data = $this->nhathau->search('nhathau.id,displayname,diemdanhgia,nhathau_alias');
		$totalPages = $this->nhathau->totalPages();
		$ipagesbefore = $pageindex - INT_PAGE_SUPPORT;
		if ($ipagesbefore < 1)
			$ipagesbefore = 1;
		$ipagesnext = $pageindex + INT_PAGE_SUPPORT;
		if ($ipagesnext > $totalPages)
			$ipagesnext = $totalPages;
		//print_r($lstDuan);die();
		$this->set("lstNhathau",$data);
		$this->set('pagesindex',$pageindex);
		$this->set('pagesbefore',$ipagesbefore);
		$this->set('pagesnext',$ipagesnext);
		$this->set('pageend',$totalPages);
		$this->setModel("linhvuc");
		$data = $this->linhvuc->search();
		$this->set("lstLinhvuc",$data);
		$this->set('title','Jobbid.vn - Tìm Kiếm Nhà Thầu');
		$this->_template->render();
	}
	function lstNhathauBySearch() {
		$ipageindex = $_POST["pageindex"];
		if(!isset($ipageindex))
			$ipageindex = 1;
		$strWhere = " and nhathau.`status` = 1 and account.active=1";
		$this->nhathau->showHasOne(array('account'));
		if(isset($_POST["linhvuc_id"])) {
			$cond_linhvuc = $_POST["linhvuc_id"];
			if(!empty($cond_linhvuc)) {
				$this->nhathau->hasJoin(array("nhathaulinhvuc"),array("nhathau"));
				$cond_linhvuc = mysql_real_escape_string($cond_linhvuc);
				$strWhere.=" and linhvuc_id = '$cond_linhvuc'";
			}
		}
		$this->nhathau->where($strWhere);
		$this->nhathau->orderBy('diemdanhgia','desc');
		$this->nhathau->setPage($ipageindex);
		$this->nhathau->setLimit(PAGINATE_LIMIT);
		$data = $this->nhathau->search('nhathau.id,displayname,diemdanhgia,nhathau_alias');
		$totalPages = $this->nhathau->totalPages();
		$ipagesbefore = $ipageindex - INT_PAGE_SUPPORT;
		if ($ipagesbefore < 1)
			$ipagesbefore = 1;
		$ipagesnext = $ipageindex + INT_PAGE_SUPPORT;
		if ($ipagesnext > $totalPages)
			$ipagesnext = $totalPages;
		$this->set("lstNhathau",$data);
		$this->set('pagesindex',$ipageindex);
		$this->set('pagesbefore',$ipagesbefore);
		$this->set('pagesnext',$ipagesnext);
		$this->set('pageend',$totalPages);
		$this->_template->renderPage();
	}
	function afterAction() {

	}

}