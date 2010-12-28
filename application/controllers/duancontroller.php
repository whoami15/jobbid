<?php

class DuanController extends VanillaController {
	function __construct($controller, $action) {		
		global $inflect;
		$this->_controller = ucfirst($controller);		
		$this->_action = $action;
		$model = "duan";
		$this->$model =& new $model;
		$this->_template =& new Template($controller,$action);
	}
	function beforeAction () {
		performAction('webmaster', 'updateStatistics');
	}
	//Admin functions
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
	function checkActive($isAjax=false,$msg='Vui lòng kiểm tra email để xác nhận tài khoản!') {
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
		$this->setModel('duan');
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
	function setModel($model) {
		 $this->$model =& new $model;
	}
    function listDuans($ipageindex) {
		$this->checkAdmin(true);
		$cond_exprired = $_GET["cond_exprired"];
		$strWhere = "";
		if($cond_exprired!=null && $cond_exprired=="true" ) {
			$strWhere.=" and ngayketthuc < now()";
		}
		$this->duan->showHasOne(array("linhvuc","account","tinh"));
		$this->duan->where($strWhere);
		$this->duan->orderBy('duan.id','desc');
		$this->duan->setPage($ipageindex);
		$this->duan->setLimit(PAGINATE_LIMIT);
		$lstDuan = $this->duan->search("duan.id,tenduan,alias,linhvuc_id,duan.account_id,tinh_id,tentinh,costmin,costmax,ngaypost,prior,views,duan.active,tenlinhvuc,username,ngayketthuc,nhathau_id");
		$totalPages = $this->duan->totalPages();
		$ipagesbefore = $ipageindex - INT_PAGE_SUPPORT;
		if ($ipagesbefore < 1)
			$ipagesbefore = 1;
		$ipagesnext = $ipageindex + INT_PAGE_SUPPORT;
		if ($ipagesnext > $totalPages)
			$ipagesnext = $totalPages;
		//print_r($lstDuan);die();
		$this->set("lstDuan",$lstDuan);
		$this->set('pagesindex',$ipageindex);
		$this->set('pagesbefore',$ipagesbefore);
		$this->set('pagesnext',$ipagesnext);
		$this->set('pageend',$totalPages);
		$this->_template->renderPage();
	}
	function saveDuan() {
		$this->checkAdmin(true);
		try {
			$id = $_POST["duan_id"];
			$tenduan = $_POST["duan_tenduan"];
			$alias = $_POST["duan_alias"];
			$linhvuc_id = $_POST["duan_linhvuc_id"];
			$tinh_id = $_POST["duan_tinh_id"];
			$ngayketthuc = $_POST["duan_ngayketthuc"];
			$prior = $_POST["duan_prior"];
			$costmin = $_POST["duan_costmin"];
			$costmax = $_POST["duan_costmax"];
			$thongtinchitiet = $_POST["duan_thongtinchitiet"];
			$data_content = $_POST["duan_data"];
			$validate = new Validate();
			if($validate->check_date($ngayketthuc)==false)
				die('ERROR_SYSTEM');
			$ngayketthuc = SQLDate($ngayketthuc);
			if($id==null) { //insert
				die('ERROR_SYSTEM');
			} else { //update
				//die($thongtinchitiet);
				$this->duan->id = $id;
				$data = $this->duan->search("data_id");
				if(empty($data))
					die("ERROR_SYSTEM");
				$data_id = $data["duan"]["data_id"];
				$this->setModel("data");
				if($data_id != null) {
					$this->data->id = $data_id;
					$this->data->delete();
				}
				$sIndex = "$tenduan ".strip_tags($data_content);
				$sIndex = strtolower(remove_accents($sIndex));
				$this->data->id = null;
				$this->data->data = $sIndex;
				$data_id = $this->data->insert(true);
				$this->setModel("duan");
				$this->duan->id = $id;
				$data = $this->duan->search("ngaypost");
				if(empty($data))
					die('ERROR_SYSTEM');
				$ngaypost = $data["duan"]["ngaypost"];
				$this->duan->id = $id;
				$this->duan->tenduan = $tenduan;
				$this->duan->alias = $alias;
				$this->duan->linhvuc_id = $linhvuc_id;
				$this->duan->tinh_id = $tinh_id;
				$this->duan->prior = $prior;
				if($costmin!=0 && $costmax!=0) {
					$this->duan->costmin = $costmin;
					$this->duan->costmax = $costmax;
				}
				$this->duan->thongtinchitiet = $thongtinchitiet;
				$currentDate = GetDateSQL();
				$this->duan->timeupdate = $currentDate;
				$this->duan->ngayketthuc = $ngayketthuc;
				$this->duan->data_id = $data_id;
			}
			$this->duan->save();
			$this->duan->where(" and active = 1 and nhathau_id is null and ngayketthuc > now() and linhvuc_id = '$linhvuc_id'");
			$data = $this->duan->search("count(*) as soduan");
			$this->setModel("linhvuc");
			$this->linhvuc->id = $linhvuc_id;
			$this->linhvuc->soduan = $data[0][""]["soduan"];
			$this->linhvuc->update();
			echo "DONE";
		} catch (Exception $e) {
			echo 'ERROR_SYSTEM';
		}
	}   
	function exist($id=null){
		$this->checkAdmin(true);
		if($id==null)
			die("ERROR_SYSTEM");
		$this->duan->id = $id;
		$data = $this->duan->search();
		if(empty($data)) {
			echo "0";
		} else {
			echo "1";
		}
	}
	function getThongtinchitietById($id=null) {	
		if($id != null) {
			$id = mysql_real_escape_string($id);
			$this->duan->id=$id;
            $data=$this->duan->search();
			print_r($data['duan']['thongtinchitiet']);
		}
	}
	function activeDuan($id=0) {
		$this->checkAdmin(true);
		if($id!=0) {
			$this->duan->id = $id;
			$data = $this->duan->search("linhvuc_id");
			if(empty($data))
				die("ERROR_SYSTEM");
			$this->duan->id = $id;
			$this->duan->active = 1;
			$this->duan->save();
			$linhvuc_id = $data["duan"]["linhvuc_id"];
			$this->duan->where(" and active = 1 and nhathau_id is null and ngayketthuc > now() and linhvuc_id = '$linhvuc_id'");
			$data = $this->duan->search("count(*) as soduan");
			$this->setModel("linhvuc");
			$this->linhvuc->id = $linhvuc_id;
			$this->linhvuc->soduan = $data[0][""]["soduan"];
			$this->linhvuc->update();
			echo "DONE";
		}
	}
	function delete() {
		$this->checkAdmin(true);
		$id = $_GET["duan_id"];
		if(isset($id)) {
			$this->duan->id = $id;
			$data = $this->duan->search("linhvuc_id");
			if(empty($data))
				die("ERROR_SYSTEM");
			$this->duan->id = $id;
			$this->duan->delete();
			$linhvuc_id = $data["duan"]["linhvuc_id"];
			$this->duan->where(" and active = 1 and nhathau_id is null and ngayketthuc > now() and linhvuc_id = '$linhvuc_id'");
			$data = $this->duan->search("count(*) as soduan");
			$this->setModel("linhvuc");
			$this->linhvuc->id = $linhvuc_id;
			$this->linhvuc->soduan = $data[0][""]["soduan"];
			$this->linhvuc->update();
			echo "DONE";
		} else {
			echo "ERROR_SYSTEM";
		}
	}
	function unActiveDuan($id=0) {
		$this->checkAdmin(true);
		if($id!=0) {
			$this->duan->id = $id;
			$data = $this->duan->search("linhvuc_id");
			if(empty($data))
				die("ERROR_SYSTEM");
			$this->duan->id = $id;
			$this->duan->active = 0;
			$this->duan->save();
			$linhvuc_id = $data["duan"]["linhvuc_id"];
			$this->duan->where(" and active = 1 and nhathau_id is null and ngayketthuc > now() and linhvuc_id = '$linhvuc_id'");
			$data = $this->duan->search("count(*) as soduan");
			$this->setModel("linhvuc");
			$this->linhvuc->id = $linhvuc_id;
			$this->linhvuc->soduan = $data[0][""]["soduan"];
			$this->linhvuc->update();
			echo "DONE";
		}
	}
	//User functions
	function add() {
		$_SESSION['redirect_url'] = getUrl();
		$this->checkLogin();
		$this->checkActive(false,'Bạn cần xác nhận tài khoản để có thể tạo dự án cho bạn.');
		$this->checkLock();
		$this->setModel("linhvuc");
		$data = $this->linhvuc->search();
		$this->set("lstLinhvuc",$data);
		$this->setModel("tinh");
		$data = $this->tinh->search();
		$this->set("lstTinh",$data);
		$this->_template->render();	
	}
	function doAdd() {
		try {
			$this->checkLogin(true);
			$this->checkActive(true,' ');
			$this->checkLock(true);
			$id = $_SESSION["account"]["id"];
			$tenduan = $_POST["duan_tenduan"];
			$alias = $_POST["duan_alias"];
			$linhvuc_id = $_POST["duan_linhvuc_id"];
			$tinh_id = $_POST["duan_tinh_id"];
			$ngayketthuc = $_POST["duan_ngayketthuc"];
			$costmin = $_POST["duan_costmin"];
			$costmax = $_POST["duan_costmax"];
			$thongtinchitiet = $_POST["duan_thongtinchitiet"];
			if(isset($_POST["duan_skills"])) {
				if(isset($_POST["duan_skills"][MAX_SKILL]))
					die('ERROR_MAXSKILL');
			}
			$validate = new Validate();
			if($validate->check_null(array($tenduan,$alias,$linhvuc_id,$tinh_id,$ngayketthuc,$costmin,$costmax,$thongtinchitiet))==false)
				die('ERROR_SYSTEM');
			if($validate->check_date($ngayketthuc)==false)
				die('ERROR_SYSTEM');
			$ngayketthuc = SQLDate($ngayketthuc);
			$file_id = null;
			//Get upload attach file_id
			global $cache;
			$ma=time();
			if($_FILES['duan_filedinhkem']['name']!=NULL) {
				$str=$_FILES['duan_filedinhkem']['tmp_name'];
				$size= $_FILES['duan_filedinhkem']['size'];
				if($size==0) {
					echo 'ERROR_FILESIZE';
				}
				else {
					$dir = ROOT . DS . 'public'. DS . 'upload' . DS . 'files' . DS;
					$filename = preg_replace("/[&' +-]/","_",$_FILES['duan_filedinhkem']['name']);				
					move_uploaded_file($_FILES['duan_filedinhkem']['tmp_name'],$dir . $filename);
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
						$this->file->status = 1;
						$file_id = $this->file->insert(true);
					}
				}
			}
			//End
			$this->setModel("data");
			$sIndex = "$tenduan ".strip_tags($thongtinchitiet);
			$sIndex = strtolower(remove_accents($sIndex));
			$this->data->id = null;
			$this->data->data = $sIndex;
			$data_id = $this->data->insert(true);
			$this->setModel("duan");
			$this->duan->id = null;
			$this->duan->tenduan = $tenduan;
			$this->duan->alias = $alias;
			$this->duan->linhvuc_id = $linhvuc_id;
			$this->duan->tinh_id = $tinh_id;
			$this->duan->costmin = $costmin;
			$this->duan->costmax = $costmax;
			$this->duan->prior = 0;
			$this->duan->file_id = $file_id;
			$this->duan->thongtinchitiet = $thongtinchitiet;
			$currentDate = GetDateSQL();
			$this->duan->ngaypost = $currentDate;
			$this->duan->timeupdate = $currentDate;
			$this->duan->ngayketthuc = $ngayketthuc;
			$this->duan->account_id = $id;
			$this->duan->views = 0;
			$this->duan->bidcount = 0;
			$this->duan->averagecost = 0;
			$this->duan->active = 1;
			$this->duan->isnew = 1;
			$this->duan->data_id = $data_id;
			$duan_id = $this->duan->insert(true);
			$this->duan->where(" and active = 1 and nhathau_id is null and ngayketthuc > now() and linhvuc_id = '$linhvuc_id'");
			$data = $this->duan->search("count(*) as soduan");
			$this->setModel("linhvuc");
			$this->linhvuc->id = $linhvuc_id;
			$this->linhvuc->soduan = $data[0][""]["soduan"];
			$this->linhvuc->update();
			if(isset($_POST["duan_skills"])) {
				$lstSkill= $_POST["duan_skills"];
				$this->setModel("duanskill");
				foreach($lstSkill as $skill_id) {
					$this->duanskill->id=null;
					$this->duanskill->duan_id=$duan_id;
					$this->duanskill->skill_id=$skill_id;
					$this->duanskill->insert();
				}
			}
			
			echo "DONE";
		} catch (Exception $e) {
			echo 'ERROR_SYSTEM';
		}
	}
	function search() {
		$_SESSION['redirect_url'] = getUrl();
		$this->setModel("linhvuc");
		$data = $this->linhvuc->search();
		$this->set("lstLinhvuc",$data);
		$this->setModel("tinh");
		$data = $this->tinh->search();
		$this->set("lstTinh",$data);
		$this->setModel("duanskill");
		$this->duanskill->showHasOne();
		$this->duanskill->hasJoin(array('skill'),array('linhvuc'));
		$this->duanskill->groupBy('tenlinhvuc,skillname');
		$this->duanskill->where(' and duan.active=1 and duan.nhathau_id is null and ngayketthuc>now()');
		$data = $this->duanskill->search('linhvuc.id,tenlinhvuc,skill.id,skillname,count(*) as soduan');
		$this->set("lstData2",$data);
		$this->_template->render();
	}
	function view($id=null) {
		if($id != null && $id != 0) {
			$id = mysql_real_escape_string($id);
			$_SESSION['redirect_url'] = getUrl();
			$this->duan->showHasOne(array("linhvuc","tinh","file","nhathau",));
			$this->duan->id=$id;
            $data=$this->duan->search("duan.id,tenduan,linhvuc_id,tenlinhvuc,tentinh,costmin,costmax,thongtinchitiet,filename,file.id,ngaypost,duan.account_id,views,bidcount,averagecost,ngayketthuc,UNIX_TIMESTAMP(ngayketthuc)-UNIX_TIMESTAMP(now()) as timeleft,duan.active,nhathau.id,displayname,hosothau_id");
			if(isset($data)) {
				$viewcount = $data["duan"]["views"];
				$this->duan->id=$id;
				$this->duan->views=$viewcount+1;
				$this->duan->save();
				if($data["duan"]["active"] != 1 || isset($data["nhathau"]["id"]) || $data[""]["timeleft"]<0) {
					$this->set("status","Đã đóng");
					$data[""]["lefttime"] = -1;
				} else 
					$this->set("status","Đang mở");
				$this->set("dataDuan",$data);
				$this->setModel("duanskill");
				$this->duanskill->showHasOne(array('skill'));
				$this->duanskill->where(" and duan_id=$id ");
				$data = $this->duanskill->search("skillname");
				$this->set("lstSkill",$data);
				$this->_template->render();
			}
		}
	}
	function doMarkDuan() {
		try {
			$this->checkLogin(true);
			$duan_id = $_GET["duan_id"];
			$duan_id = mysql_real_escape_string($duan_id);
			if($duan_id == null)
				die("ERROR_SYSTEM");
			$this->setModel("duanmark");
			$account_id = $_SESSION["account"]["id"];
			$data = $this->duanmark->custom("select id from duanmarks as duanmark where account_id=$account_id and duan_id=".mysql_real_escape_string($duan_id));
			if(!empty($data))
				die("ERROR_EXIST");
			$this->duanmark->id = null;
			$this->duanmark->account_id = $account_id;
			$this->duanmark->duan_id = $duan_id;
			$this->duanmark->insert();
			echo "DONE";
		} catch (Exception $e) {
			echo 'ERROR_SYSTEM';
		}
	}
	function viewmarks() {
		$_SESSION['redirect_url'] = getUrl();
		$this->checkLogin();
		$account_id = $_SESSION["account"]["id"];
		$this->setModel('duanmark');
		$this->duanmark->showHasOne(array('duan'));
		$this->duanmark->hasJoin(array('duan'),array('linhvuc'));
		$this->duanmark->orderBy('duanmark.id','desc');
		$this->duanmark->setPage(1);
		$this->duanmark->setLimit(PAGINATE_LIMIT);
		$this->duanmark->where(" and duanmark.account_id = $account_id");
		$data = $this->duanmark->search('duan.id,tenduan,alias,linhvuc_id,tenlinhvuc,averagecost,ngaypost,prior,views,bidcount,UNIX_TIMESTAMP(ngayketthuc)-UNIX_TIMESTAMP(now()) as timeleft,duan.active,nhathau_id');
		$totalPages = $this->duanmark->totalPages();
		$ipagesbefore = 1 - INT_PAGE_SUPPORT;
		if ($ipagesbefore < 1)
			$ipagesbefore = 1;
		$ipagesnext = 1 + INT_PAGE_SUPPORT;
		if ($ipagesnext > $totalPages)
			$ipagesnext = $totalPages;
		//print_r($lstDuan);die();
		$this->set("lstDuan",$data);
		$this->set('pagesindex',1);
		$this->set('pagesbefore',$ipagesbefore);
		$this->set('pagesnext',$ipagesnext);
		$this->set('pageend',$totalPages);
		$this->_template->render();
	}
	function lstDuanMark($ipageindex) {
		$this->checkLogin();
		$ipageindex = mysql_real_escape_string($ipageindex);
		$account_id = $_SESSION["account"]["id"];
		$this->setModel('duanmark');
		$this->duanmark->showHasOne(array('duan'));
		$this->duanmark->hasJoin(array('duan'),array('linhvuc'));
		$this->duanmark->orderBy('duanmark.id','desc');
		$this->duanmark->setPage($ipageindex);
		$this->duanmark->setLimit(PAGINATE_LIMIT);
		$this->duanmark->where(" and duanmark.account_id = $account_id");
		$data = $this->duanmark->search('duan.id,tenduan,alias,linhvuc_id,tenlinhvuc,averagecost,ngaypost,prior,views,bidcount,UNIX_TIMESTAMP(ngayketthuc)-UNIX_TIMESTAMP(now()) as timeleft,duan.active,nhathau_id');
		$totalPages = $this->duanmark->totalPages();
		$ipagesbefore = $ipageindex - INT_PAGE_SUPPORT;
		if ($ipagesbefore < 1)
			$ipagesbefore = 1;
		$ipagesnext = $ipageindex + INT_PAGE_SUPPORT;
		if ($ipagesnext > $totalPages)
			$ipagesnext = $totalPages;
		//print_r($lstDuan);die();
		$this->set("lstDuan",$data);
		$this->set('pagesindex',$ipageindex);
		$this->set('pagesbefore',$ipagesbefore);
		$this->set('pagesnext',$ipagesnext);
		$this->set('pageend',$totalPages);
		$this->_template->renderPage();
	}
	function deleteDuanmark() {
		$duan_id = $_GET["duan_id"];
		if(isset($duan_id)) {
			$this->checkLogin(true);
			$account_id = $_SESSION["account"]["id"];
			$this->setModel("duanmark");
			$this->duanmark->custom("delete from duanmarks where account_id=$account_id and duan_id=".mysql_real_escape_string($duan_id));
			echo "DONE";
		} else {
			echo "ERROR_SYSTEM";
		}
		
	}
	function viewMyprojects() {
		$_SESSION['redirect_url'] = getUrl();
		$this->checkLogin();
		$account_id = $_SESSION["account"]["id"];
		$this->duan->showHasOne(array('linhvuc'));
		$this->duan->orderBy('duan.id','desc');
		$this->duan->setPage(1);
		$this->duan->setLimit(PAGINATE_LIMIT);
		$this->duan->where(" and duan.account_id = $account_id");
		$data = $this->duan->search("duan.id,tenduan,alias,linhvuc_id,tenlinhvuc,averagecost,ngaypost,prior,views,bidcount,UNIX_TIMESTAMP(ngayketthuc)-UNIX_TIMESTAMP(now()) as timeleft,duan.active,nhathau_id");
		$totalPages = $this->duan->totalPages();
		$ipagesbefore = 1 - INT_PAGE_SUPPORT;
		if ($ipagesbefore < 1)
			$ipagesbefore = 1;
		$ipagesnext = 1 + INT_PAGE_SUPPORT;
		if ($ipagesnext > $totalPages)
			$ipagesnext = $totalPages;
		//print_r($lstDuan);die();
		$this->set("lstDuan",$data);
		$this->set('pagesindex',1);
		$this->set('pagesbefore',$ipagesbefore);
		$this->set('pagesnext',$ipagesnext);
		$this->set('pageend',$totalPages);
		$this->_template->render();
	}
	function lstMyProjects($ipageindex) {
		$this->checkLogin();
		$ipageindex = mysql_real_escape_string($ipageindex);
		$account_id = $_SESSION["account"]["id"];
		$this->duan->showHasOne(array('linhvuc'));
		$this->duan->orderBy('duan.id','desc');
		$this->duan->setPage($ipageindex);
		$this->duan->setLimit(PAGINATE_LIMIT);
		$this->duan->where(" and duan.account_id = $account_id");
		$data = $this->duan->search("duan.id,tenduan,alias,linhvuc_id,tenlinhvuc,averagecost,ngaypost,prior,views,bidcount,UNIX_TIMESTAMP(ngayketthuc)-UNIX_TIMESTAMP(now()) as timeleft,duan.active,nhathau_id");
		$totalPages = $this->duan->totalPages();
		$ipagesbefore = $ipageindex - INT_PAGE_SUPPORT;
		if ($ipagesbefore < 1)
			$ipagesbefore = 1;
		$ipagesnext = $ipageindex + INT_PAGE_SUPPORT;
		if ($ipagesnext > $totalPages)
			$ipagesnext = $totalPages;
		//print_r($lstDuan);die();
		$this->set("lstDuan",$data);
		$this->set('pagesindex',$ipageindex);
		$this->set('pagesbefore',$ipagesbefore);
		$this->set('pagesnext',$ipagesnext);
		$this->set('pageend',$totalPages);
		$this->_template->renderPage();
	}
	function edit() {
		$_SESSION['redirect_url'] = getUrl();
		$this->checkLogin();
		$this->checkActive();
		$this->checkLock();
		$duan_id = $_GET["duan_id"];
		$duan_id = mysql_real_escape_string($duan_id);
		$account_id = $_SESSION["account"]["id"];
		if(isset($duan_id)) {
			$this->duan->showHasOne(array('file'));
			$this->duan->id = $duan_id;
			$data = $this->duan->search("duan.id,tenduan,linhvuc_id,tinh_id,costmax,costmin,thongtinchitiet,file.id,filename,duan.account_id,active,ngayketthuc,nhathau_id,UNIX_TIMESTAMP(ngayketthuc)-UNIX_TIMESTAMP(now()) as lefttime");
			if(empty($data))
				error("Server too busy!");
			if($data["duan"]["account_id"]!=$account_id)
				error("Bạn không thể chỉnh sửa thông tin dự án của người khác!");
			$this->set("dataDuan",$data["duan"]);
			$this->set("lefttime",$data[""]["lefttime"]);
			if($data["file"]["filename"]!="")
				$this->set("dataFile",$data["file"]);
			
			$this->setModel("skill");
			$this->skill->where(" and linhvuc_id = '".$data["duan"]["linhvuc_id"]."'");
			$data = $this->skill->search("id,skillname");
			$this->set("lstSkillByLinhvuc",$data);
				
			$this->setModel("duanskill");
			$this->duanskill->showHasOne(array("skill"));
			$this->duanskill->where(" and duan_id = $duan_id");
			$data = $this->duanskill->search("skill.id,skillname");
			$this->set("lstSkill",$data);
			
			$this->setModel("linhvuc");
			$data = $this->linhvuc->search();
			$this->set("lstLinhvuc",$data);
			
			$this->setModel("tinh");
			$data = $this->tinh->search();
			$this->set("lstTinh",$data);
			
			$this->_template->render();	
		}
	}
	function doEdit() {
		try {
			$this->checkLogin(true);
			$this->checkActive(true);
			$this->checkLock(true);
			$account_id = $_SESSION["account"]["id"];
			$duan_id = mysql_real_escape_string($_POST["duan_id"]);
			$tenduan = $_POST["duan_tenduan"];
			$alias = $_POST["duan_alias"];
			$linhvuc_id = $_POST["duan_linhvuc_id"];
			$tinh_id = $_POST["duan_tinh_id"];
			$ngayketthuc = $_POST["duan_ngayketthuc"];
			$costmin = $_POST["duan_costmin"];
			$costmax = $_POST["duan_costmax"];
			$thongtinchitiet = $_POST["duan_thongtinchitiet"];
			//Validate
			if(isset($_POST["duan_skills"])) {
				if(isset($_POST["duan_skills"][MAX_SKILL]))
					die('ERROR_MAXSKILL');
			}
			$validate = new Validate();
			if($validate->check_null(array($duan_id,$tenduan,$alias,$linhvuc_id,$tinh_id,$ngayketthuc,$costmin,$costmax,$thongtinchitiet))==false)
				die('ERROR_SYSTEM');
			if($validate->check_date($ngayketthuc)==false)
				die('ERROR_SYSTEM');
			$ngayketthuc = SQLDate($ngayketthuc);
			//End validate
			$this->duan->id = $duan_id;
			$this->duan->where(" and id = $duan_id and account_id = $account_id");
			$data = $this->duan->search("id,ngaypost,ngayketthuc,data_id");
			if(empty($data))
				die("ERROR_SYSTEM");
			$ngaypost = $data["duan"]["ngaypost"];
			$data_id = $data["duan"]["data_id"];
			$file_id = null;
			//Get upload attach file_id
			global $cache;
			$ma=time();
			if($_FILES['duan_filedinhkem']['name']!=NULL) {
				$str=$_FILES['duan_filedinhkem']['tmp_name'];
				$size= $_FILES['duan_filedinhkem']['size'];
				if($size==0) {
					echo 'ERROR_FILESIZE';
				}
				else {
					$dir = ROOT . DS . 'public'. DS . 'upload' . DS . 'files' . DS;
					$filename = preg_replace("/[&' +-]/","_",$_FILES['duan_filedinhkem']['name']);				
					move_uploaded_file($_FILES['duan_filedinhkem']['tmp_name'],$dir . $filename);
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
						$this->file->status = 1;
						$file_id = $this->file->insert(true);
					}
				}
			}
			//End
			$this->setModel("data");
			$sIndex = "$tenduan ".strip_tags($thongtinchitiet);
			$sIndex = strtolower(remove_accents($sIndex));
			$this->data->id = $data_id;
			$this->data->data = $sIndex;
			$this->data->update();
			$this->setModel("duan");
			$this->duan->id = $duan_id;
			$this->duan->tenduan = $tenduan;
			$this->duan->alias = $alias;
			$this->duan->linhvuc_id = $linhvuc_id;
			$this->duan->tinh_id = $tinh_id;
			$this->duan->costmin = $costmin;
			$this->duan->costmax = $costmax;
			if($file_id!=0)
				$this->duan->file_id = $file_id;
			$this->duan->thongtinchitiet = $thongtinchitiet;
			$currentDate = GetDateSQL();
			$this->duan->timeupdate = $currentDate;
			$this->duan->ngayketthuc = $ngayketthuc;
			if($data["duan"]["ngayketthuc"] > $currentDate)
				$this->duan->nhathau_id = "";
			$this->duan->update();
			$this->setModel("duanskill");
			$this->duanskill->custom("delete from duanskills where duan_id = $duan_id");
			if(isset($_POST["duan_skills"])) {
				$lstSkill= $_POST["duan_skills"];
				foreach($lstSkill as $skill_id) {
					$this->duanskill->id=null;
					$this->duanskill->duan_id=$duan_id;
					$this->duanskill->skill_id=$skill_id;
					$this->duanskill->insert();
				}
			}
			echo "DONE";
		} catch (Exception $e) {
			echo 'ERROR_SYSTEM';
		}
	}
	function changeStatusProject($active=null) {
		if($active == null || ($active!=0 && $active!=1))
			die("ERROR_SYSTEM");
		try {
			$this->checkLogin(true);
			$this->checkActive(true);
			$this->checkLock(true);
			$account_id = $_SESSION["account"]["id"];
			$duan_id = mysql_real_escape_string($_GET["duan_id"]);
			$this->duan->id = $duan_id;
			$data = $this->duan->search("linhvuc_id");
			if(empty($data))
				die("ERROR_SYSTEM");
			$this->duan->active = $active;
			if($active == 1)
				$this->duan->nhathau_id = "";
			$this->duan->update(" id = $duan_id and account_id = $account_id");
			$linhvuc_id = $data["duan"]["linhvuc_id"];
			$this->duan->where(" and active = 1 and nhathau_id is null and ngayketthuc > now() and linhvuc_id = '$linhvuc_id'");
			$data = $this->duan->search("count(*) as soduan");
			$this->setModel("linhvuc");
			$this->linhvuc->id = $linhvuc_id;
			$this->linhvuc->soduan = $data[0][""]["soduan"];
			$this->linhvuc->update();
			
			echo "DONE";	
		} catch (Exception $e) {
			echo 'ERROR_SYSTEM';
		}
	}
	function lstDuanByNhaThau() {
		$nhathau_id = $_GET["nhathau_id"];
		if($nhathau_id == null)
			die("ERROR_SYSTEM");
		$nhathau_id = mysql_real_escape_string($nhathau_id);
		$this->duan->where(" and nhathau_id = $nhathau_id");
		$this->duan->orderBy("timeupdate","desc");
		$data = $this->duan->search("id,tenduan,alias");
		$jsonResult = "{";
		$i=0;
		$len = count($data);
		while($i<$len) {
			$duan = $data[$i];
			$jsonResult = $jsonResult."$i:{'id':".$duan["duan"]["id"].",'tenduan':'".$duan["duan"]["tenduan"]."','alias':'".$duan["duan"]["alias"]."'}";
			if($i < $len-1)
				$jsonResult = $jsonResult.",";
			$i++;
		}
		$jsonResult = $jsonResult."}";
		print($jsonResult);
	}
	function lstDuanBySearch() {
		$cond_keyword = $_POST["duan_keyword"];
		$cond_linhvuc = $_POST["linhvuc_id"];
		$cond_tinh = $_POST["tinh_id"];
		$ipageindex = $_POST["pageindex"];
		if(!isset($ipageindex))
			$ipageindex = 1;
		$strWhere = " and active = 1";
		if(isset($cond_keyword) && $cond_keyword!="" ) {
			$cond_keyword = mysql_real_escape_string($cond_keyword);
			$cond_keyword = strtolower(remove_accents($cond_keyword));
			$strWhere.=" and data like '%$cond_keyword%'";
		}
		if(isset($cond_linhvuc) && empty($cond_linhvuc)==false ) {
			$cond_linhvuc = mysql_real_escape_string($cond_linhvuc);
			$strWhere.=" and linhvuc_id = '$cond_linhvuc'";
		}
		if(isset($cond_tinh) && empty($cond_tinh)==false ) {
			$cond_tinh = mysql_real_escape_string($cond_tinh);
			$strWhere.=" and tinh_id = $cond_tinh";
		}
		$this->duan->showHasOne(array("linhvuc","data"));
		$this->duan->where($strWhere);
		$this->duan->orderBy('duan.id','desc');
		$this->duan->setPage($ipageindex);
		$this->duan->setLimit(PAGINATE_LIMIT);
		$lstDuan = $this->duan->search("duan.id,tenduan,alias,linhvuc_id,tenlinhvuc,averagecost,ngaypost,prior,views,bidcount,UNIX_TIMESTAMP(ngayketthuc)-UNIX_TIMESTAMP(now()) as timeleft,duan.active,nhathau_id");
		$totalPages = $this->duan->totalPages();
		$ipagesbefore = $ipageindex - INT_PAGE_SUPPORT;
		if ($ipagesbefore < 1)
			$ipagesbefore = 1;
		$ipagesnext = $ipageindex + INT_PAGE_SUPPORT;
		if ($ipagesnext > $totalPages)
			$ipagesnext = $totalPages;
		//print_r($lstDuan);die();
		$this->set("lstDuan",$lstDuan);
		$this->set('pagesindex',$ipageindex);
		$this->set('pagesbefore',$ipagesbefore);
		$this->set('pagesnext',$ipagesnext);
		$this->set('pageend',$totalPages);
		$this->_template->renderPage();
	}
	function afterAction() {

	}

}