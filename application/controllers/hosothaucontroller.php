<?php

class HosothauController extends VanillaController {
	function __construct($controller, $action) {		
		global $inflect;
		$this->_controller = ucfirst($controller);		
		$this->_action = $action;
		$model = "hosothau";
		$this->$model =& new $model;
		$this->_template =& new Template($controller,$action);
	}
	function beforeAction () {

	}
	function setModel($model) {
		 $this->$model =& new $model;
	}
	//Admin functions
	
	//User functions
	function checkLogin($isAjax=false) {
		if(!isset($_SESSION['user'])) {
			if($isAjax == true) {
				die("ERROR_NOTLOGIN");
			} else {
				redirect(BASE_PATH.'/account/login');
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
	function checkAdmin($isAjax=false) {
		if($isAjax==false)
			$_SESSION['redirect_url'] = getUrl();
		if(!isset($_SESSION['user']) || $_SESSION["user"]["account"]["role"]>1) {
			if($isAjax == true) {
				die("ERROR_NOTLOGIN");
			} else {
				redirect(BASE_PATH.'/admin/login&reason=admin');
				die();
			}
		}
	}
	function index() {
		$_SESSION['redirect_url'] = getUrl();
		$this->checkLogin();
		$this->checkNhathau();
		$duan_id = $_GET["duan_id"];
		if(!isEmpty($duan_id)) {
			$this->setModel("duan");
			$this->duan->id = $duan_id;
			$data = $this->duan->search("id,tenduan,alias");
			if(!empty($data)) {
				$this->set("dataDuan",$data);
				$this->_template->render();
			}
		}
	}
	function doPost() {
		try {
			$this->checkLogin(true);
			$this->checkNhathau(true);
			if($_FILES['hosothau_filedinhkem']['name']!=NULL) {
				$size= $_FILES['hosothau_filedinhkem']['size'];
				if($size==0) {
					echo 'ERROR_FILESIZE';
				}
			}
			$duan_id = $_POST["hosothau_duan_id"];
			$giathau = $_POST["hosothau_giathau"];
			$thoigian = $_POST["hosothau_thoigian"];
			$milestone = $_POST["hosothau_milestone"];
			$content = $_POST["hosothau_content"];
			$nhathau = $_SESSION["nhathau"];
			$account_id = $_SESSION["user"]["account"]["id"];
			$nhathau_id = $nhathau["id"];
			$validate = new Validate();
			if($validate->check_null(array($duan_id,$giathau,$thoigian))==false)
				die('ERROR_SYSTEM');
			if($validate->check_number($giathau) == false)
				die('ERROR_SYSTEM');
			if($validate->check_number($thoigian) == false)
				die('ERROR_SYSTEM');
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
			/* $this->setModel("hosothau");
			$this->hosothau->where(" and duan_id=$duan_id and nhathau_id=$nhathau_id");
			$data = $this->hosothau->search("id");
			if(empty($data)==false)
				die("ERROR_DUPLICATE"); */
			$file_id = 0;
			//Get upload attach file_id
			global $cache;
			$ma=time();
			if($_FILES['hosothau_filedinhkem']['name']!=NULL) {
				$str=$_FILES['hosothau_filedinhkem']['tmp_name'];
				$size= $_FILES['hosothau_filedinhkem']['size'];
				if($size==0) {
					echo 'ERROR_FILESIZE';
				}
				else {
					$dir = ROOT . DS . 'public'. DS . 'upload' . DS . 'files' . DS;
					$filename = preg_replace("/[&' +-]/","_",$_FILES['hosothau_filedinhkem']['name']);				
					move_uploaded_file($_FILES['hosothau_filedinhkem']['tmp_name'],$dir . $filename);
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
						$this->file->account_id = $_SESSION["user"]["account"]["id"];
						$this->file->account_share = $employerId;
						$this->file->status = 1;
						$file_id = $this->file->insert(true);
					}
				}
			}
			//End
			$this->setModel("hosothau");
			$this->hosothau->id = null;
			$this->hosothau->account_id = $account_id;
			$this->hosothau->giathau = $giathau;
			$this->hosothau->thoigian = $thoigian;
			$this->hosothau->milestone = $milestone;
			$this->hosothau->content = $content;
			$this->hosothau->duan_id = $duan_id;
			$this->hosothau->nhathau_id = $nhathau_id;
			$this->hosothau->file_id= $file_id;
			$this->hosothau->ngaygui = GetDateSQL();
			$this->hosothau->trangthai = 1;
			$this->hosothau->insert();
			$data = $this->hosothau->custom("select count(*) as bidcount,sum(giathau) as total from hosothaus as hosothau where duan_id=$duan_id");
			//print_r($data);die();
			//Update bidcount cua du an
			$this->setModel("duan");
			$this->duan->id = $duan_id;
			$this->duan->bidcount = $data[0][""]["bidcount"];
			$this->duan->averagecost = round($data[0][""]["total"] / $data[0][""]["bidcount"]);
			$this->duan->lastbid_nhathau = $nhathau_id;
			$this->duan->update();
			echo "DONE";
		} catch (Exception $e) {
			echo 'ERROR_SYSTEM';
		}
	}
	function lstHosothauByDuan($ipageindex) {
		//$this->checkLogin(true);
		$duan_id = $_GET["duan_id"];
		if($duan_id!=null) {
			$this->hosothau->showHasOne(array("file","nhathau"));
			$this->hosothau->where(" and trangthai>=1 and duan_id=$duan_id");
			$this->hosothau->orderBy('hosothau.id','desc');
			$this->hosothau->setPage($ipageindex);
			$this->hosothau->setLimit(PAGINATE_LIMIT);
			$lstHosthau = $this->hosothau->search("hosothau.id,giathau,milestone,UNIX_TIMESTAMP(now())-UNIX_TIMESTAMP(ngaygui) as timeofbid,thoigian,filename,file.id,nhathau.id,displayname,trangthai,diemdanhgia");
			$totalPages = $this->hosothau->totalPages();
			$ipagesbefore = $ipageindex - INT_PAGE_SUPPORT;
			if ($ipagesbefore < 1)
				$ipagesbefore = 1;
			$ipagesnext = $ipageindex + INT_PAGE_SUPPORT;
			if ($ipagesnext > $totalPages)
				$ipagesnext = $totalPages;
			//print_r($lstDuan);die();
			$this->set("lstHosthau",$lstHosthau);
			$this->set('pagesindex',$ipageindex);
			$this->set('pagesbefore',$ipagesbefore);
			$this->set('pagesnext',$ipagesnext);
			$this->set('pageend',$totalPages);
			$this->set('duan_id',$duan_id);
			$this->_template->renderPage();
		}
	}
	function getContent(){
		$id = $_GET["id"];
		if($id!=null) {
			$this->hosothau->id = $id;
			$data = $this->hosothau->search("content");
			print_r($data["hosothau"]["content"]);
		}
	}
	function ds_ho_so_thau() {
		$_SESSION['redirect_url'] = getUrl();
		$this->checkLogin();
		$this->checkNhathau();
		$nhathau_id = $_SESSION["nhathau"]["id"];
		$this->hosothau->showHasOne(array("duan"));
		$this->hosothau->where(" and trangthai>=1 and hosothau.nhathau_id = $nhathau_id");
		$this->hosothau->orderBy("hosothau.id","desc");
		$this->hosothau->setPage(1);
		$this->hosothau->setLimit(PAGINATE_LIMIT);
		$data = $this->hosothau->search("duan.id,alias,tenduan,giathau,ngaygui,duan.nhathau_id,hosothau.nhathau_id,UNIX_TIMESTAMP(ngayketthuc)-UNIX_TIMESTAMP(now()) as lefttime,duan.active,trangthai");
		$totalPages = $this->hosothau->totalPages();
		$ipagesbefore = 1 - INT_PAGE_SUPPORT;
		if ($ipagesbefore < 1)
			$ipagesbefore = 1;
		$ipagesnext = 1 + INT_PAGE_SUPPORT;
		if ($ipagesnext > $totalPages)
			$ipagesnext = $totalPages;
		//print_r($lstDuan);die();
		$this->set("lstHosthau",$data);
		$this->set('pagesindex',1);
		$this->set('pagesbefore',$ipagesbefore);
		$this->set('pagesnext',$ipagesnext);
		$this->set('pageend',$totalPages);
		$this->_template->render();
	}
	function lstHosothauByNhathau($ipageindex) {
		$this->checkLogin();
		$this->checkNhathau();
		$nhathau_id = $_SESSION["nhathau"]["id"];
		$this->hosothau->showHasOne(array("duan"));
		$this->hosothau->where(" and trangthai>=1 and hosothau.nhathau_id = $nhathau_id");
		$this->hosothau->orderBy("hosothau.id","desc");
		$this->hosothau->setPage($ipageindex);
		$this->hosothau->setLimit(PAGINATE_LIMIT);
		$data = $this->hosothau->search("duan.id,alias,tenduan,giathau,ngaygui");
		$totalPages = $this->hosothau->totalPages();
		$ipagesbefore = $ipageindex - INT_PAGE_SUPPORT;
		if ($ipagesbefore < 1)
			$ipagesbefore = 1;
		$ipagesnext = $ipageindex + INT_PAGE_SUPPORT;
		if ($ipagesnext > $totalPages)
			$ipagesnext = $totalPages;
		//print_r($lstDuan);die();
		$this->set("lstHosthau",$data);
		$this->set('pagesindex',$ipageindex);
		$this->set('pagesbefore',$ipagesbefore);
		$this->set('pagesnext',$ipagesnext);
		$this->set('pageend',$totalPages);
		$this->_template->renderPage();
	}
	function xem_ho_so($hosothau_id,$duan_id) {
		if(isset($hosothau_id) && isset($duan_id)) {
			$_SESSION['redirect_url'] = getUrl();
			//$this->checkLogin();
			$hosothau_id = mysql_real_escape_string($hosothau_id);
			$duan_id = mysql_real_escape_string($duan_id);
			$this->hosothau->id = $hosothau_id;
			$this->hosothau->where(" and trangthai>=1");
			$data = $this->hosothau->search("nhathau_id");
			if(empty($data))
				error("Server đang quá tải, vui lòng thử lại!");
			$nhathau_id = $data["hosothau"]["nhathau_id"];
			$this->setModel("nhathau");
			$this->nhathau->showHasOne();
			$this->nhathau->id = $nhathau_id;
			$data = $this->nhathau->search("nhathau.id,motachitiet,displayname,diemdanhgia,nhanemail,filename,file.id,nhathau.account_id,username,hoten,diachi,email,ngaysinh,sodienthoai,type,gpkd_cmnd");
			if(empty($data)==false) {
				$this->setModel("duan");
				$this->duan->id = $duan_id;
				$duan = $this->duan->search("id,account_id,nhathau_id");
				if(empty($duan))
					error("Server đang quá tải, vui lòng thử lại!");
				$this->set("flag",0);
				if(isset($_SESSION["user"])) {
					$account_id = $_SESSION["user"]["account"]["id"];
					if($duan["duan"]["account_id"] == $account_id) { //la chu du an
						$this->set("flag",1);
						if($duan["duan"]["nhathau_id"]!=$nhathau_id) { // nha thau nay da duoc chon
							$data["account"]["sodienthoai"] = "(Chỉ hiển thị khi nhà thầu này được chọn)";
							$data["account"]["email"] = "(Chỉ hiển thị khi nhà thầu này được chọn)";
							//print_r($duan["duan"]["account_id"]);die();
							$this->set("flag",2);
						} 
					}
				}
				
				$this->set("nhathau",$data["nhathau"]);
				$this->set("account",$data["account"]);
				$this->set("file",$data["file"]);
				$this->set("duan",$duan["duan"]);
				$this->set("hosothau_id",$hosothau_id);
				$this->setModel("nhathaulinhvuc");
				$data = $this->nhathaulinhvuc->custom("select tenlinhvuc from nhathaulinhvucs as nhathaulinhvuc join linhvucs as linhvuc on nhathaulinhvuc.linhvuc_id = linhvuc.id where nhathau_id = ".$data["nhathau"]["id"]);
				$this->set("lstLinhvucquantam",$data);
			}
			$this->_template->render();	
		}
	}
	function chonhoso() {
		try {
			$this->checkLogin(true);
			$account_id = $_SESSION["user"]["account"]["id"];
			$duan_id = $_GET["duan_id"];
			$hosothau_id = $_GET["hosothau_id"];
			if(isset($duan_id) && isset($hosothau_id)) {
				$hosothau_id = mysql_real_escape_string($hosothau_id);
				$duan_id = mysql_real_escape_string($duan_id);
				$this->hosothau->id = $hosothau_id;
				$data = $this->hosothau->search("nhathau_id");
				if(empty($data))
					error("Server đang quá tải, vui lòng thử lại!");
				$nhathau_id = $data["hosothau"]["nhathau_id"];
				$this->hosothau->id = $hosothau_id;
				$this->hosothau->trangthai = 2;
				$this->hosothau->update();
				$this->setModel("duan");
				$this->duan->id = $duan_id;
				$this->duan->where(" and duan.account_id = $account_id");
				$data = $this->duan->search("linhvuc_id");
				if(empty($data))
					die("ERROR_SYSTEM");
				$this->duan->id = $duan_id;
				$this->duan->nhathau_id = $nhathau_id;
				$this->duan->hosothau_id = $hosothau_id;
				$this->duan->timeupdate = GetDateSQL();
				$this->duan->update();
				
				$linhvuc_id = $data["duan"]["linhvuc_id"];
				$this->duan->where(" and active = 1 and nhathau_id is null and ngayketthuc > now() and linhvuc_id = '$linhvuc_id'");
				$data = $this->duan->search("count(*) as soduan");
				$this->setModel("linhvuc");
				$this->linhvuc->id = $linhvuc_id;
				$this->linhvuc->soduan = $data[0][""]["soduan"];
				$this->linhvuc->update();
				echo "DONE";
			} else {
				die("ERROR_SYSTEM");
			}
		} catch (Exception $e) {
			echo 'ERROR_SYSTEM';
		}
	}
	function afterAction() {

	}

}