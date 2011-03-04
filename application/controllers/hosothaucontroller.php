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
		performAction('webmaster', 'updateStatistics');
	}
	function setModel($model) {
		 $this->$model =& new $model;
	}
	//Admin functions
	
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
	function checkNhathau($isAjax=false) {
		//die(getUrl());
		if(!isset($_SESSION['nhathau'])) {
			if($isAjax == true) {
				die("ERROR_MAKEPROFILE");
			} else {
				redirect(BASE_PATH.'/nhathau/add');
				die();
			}
		}
	}
	function checkActive($isAjax=false) {
		if($_SESSION['account']['active']==0) {
			if($isAjax == true) {
				die("ERROR_NOTACTIVE");
			} else {
				error("Vui lòng kiểm tra email để xác nhận tài khoản!");
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
		$this->setModel('hosothau');
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
	function listHosothau($ipageindex) {
		//die("ERROR_NOTLOGIN");
		$this->checkAdmin();
		$this->hosothau->showHasOne(array("duan",'nhathau'));
		$this->hosothau->hasJoin(array("nhathau"),array('account'));
		$this->hosothau->orderBy('hosothau.id','desc');
		$this->hosothau->setPage($ipageindex);
		$this->hosothau->setLimit(PAGINATE_LIMIT);
		$lstHosothau = $this->hosothau->search('hosothau.id,username,giathau,milestone,thoigian,content,ngaygui,tenduan,duan.id,hosothau.trangthai,nhathau.id');
		$totalPages = $this->hosothau->totalPages();
		$ipagesbefore = $ipageindex - INT_PAGE_SUPPORT;
		if ($ipagesbefore < 1)
			$ipagesbefore = 1;
		$ipagesnext = $ipageindex + INT_PAGE_SUPPORT;
		if ($ipagesnext > $totalPages)
			$ipagesnext = $totalPages;
		//print_r($lstNhathau);die();
		$this->set("lstHosothau",$lstHosothau);
		$this->set('pagesindex',$ipageindex);
		$this->set('pagesbefore',$ipagesbefore);
		$this->set('pagesnext',$ipagesnext);
		$this->set('pageend',$totalPages);
		$this->_template->renderPage();
	}
	
	function saveHosothau() {
		try {
			$this->checkAdmin(true);
			$id = $_POST["hosothau_id"];
			$giathau = $_POST["hosothau_giathau"];
			$thoigian = $_POST["hosothau_thoigian"];
			$milestone = $_POST["hosothau_milestone"];
			$content = $_POST["hosothau_content"];
			$trangthai = $_POST["hosothau_trangthai"];
			$duan_id = $_POST["duan_id"];
			$nhathau_id = $_POST["nhathau_id"];
			if($id==null) { //insert
				die("ERROR_SYSTEM");						
			} 
			$this->hosothau->id = $id;
			$this->hosothau->giathau = $giathau;
			$this->hosothau->thoigian = $thoigian;
			$this->hosothau->milestone = $milestone;
			$this->hosothau->content = $content;
			$this->hosothau->trangthai = $trangthai;
			$this->hosothau->update();
			//Update bidcount va averagecost cho du an
			$data = $this->hosothau->custom("select count(*) as bidcount,sum(giathau) as total from hosothaus as hosothau where trangthai>=0 and duan_id=$duan_id");
			$this->setModel("duan");
			$this->duan->id = $duan_id;
			$duan = $this->duan->search('lastbid_nhathau,hosothau_id,nhathau_id');
			if(empty($duan))
				die("ERROR_SYSTEM");
			$this->duan->id = $duan_id;
			$this->duan->bidcount = $data[0][""]["bidcount"];
			if($data[0][""]["bidcount"]==0) {
				$this->duan->averagecost = 0;
			} else {
				$this->duan->averagecost = round($data[0][""]["total"] / $data[0][""]["bidcount"]);
			}
			
			if($trangthai==-1) {
				if($nhathau_id == $duan['duan']['lastbid_nhathau'])
					$this->duan->lastbid_nhathau = '';
				if($id == $duan['duan']['hosothau_id']) {
					$this->duan->hosothau_id = '';
					if($nhathau_id == $duan['duan']['nhathau_id'])
						$this->duan->nhathau_id = '';
				}
			} else if($trangthai == 1) {
				if($id == $duan['duan']['hosothau_id']) {
					$this->duan->hosothau_id = '';
					if($nhathau_id == $duan['duan']['nhathau_id'])
						$this->duan->nhathau_id = '';
				}
			} else {
				$this->duan->hosothau_id = $id;
				$this->duan->nhathau_id = $nhathau_id;
			}
			$this->duan->update();
			echo "DONE";
		} catch (Exception $e) {
			echo 'ERROR_SYSTEM';
		}
	}
	
	function index() {
		$_SESSION['redirect_url'] = getUrl();
		$this->checkLogin();
		$this->checkNhathau();
		$this->checkActive();
		$this->checkLock();
		$duan_id = $_GET["duan_id"];
		if(!isEmpty($duan_id)) {
			$duan_id = mysql_real_escape_string($duan_id);
			$this->setModel("duan");
			$this->duan->id = $duan_id;
			$data = $this->duan->search("id,tenduan,alias");
			if(!empty($data)) {
				$this->set("dataDuan",$data);
				$this->set("username",$_SESSION['account']['username']);
				$this->set("sodienthoai",$_SESSION['account']['sodienthoai']);
				$this->set('title','Jobbid.vn - Gửi hồ sơ thầu');
				$this->_template->render();
			}
		}
	}
	function doPost() {
		try {
			$this->checkLogin(true);
			$this->checkNhathau(true);
			$this->checkActive(true);
			$this->checkLock(true);
			$duan_id = $_POST["hosothau_duan_id"];
			$giathau = $_POST["hosothau_giathau"];
			$thoigian = $_POST["hosothau_thoigian"];
			$milestone = $_POST["hosothau_milestone"];
			$content = $_POST["hosothau_content"];
			$hosothau_email = $_POST["hosothau_email"];
			$hosothau_sodienthoai = $_POST["hosothau_sodienthoai"];
			$nhathau = $_SESSION["nhathau"];
			$account_id = $_SESSION["account"]["id"];
			$nhathau_id = $nhathau["id"];
			if(isset($content[1000]))
				die('ERROR_MAXLENGTH');
			$validate = new Validate();
			if($validate->check_null(array($duan_id,$giathau,$thoigian,$hosothau_email,$hosothau_sodienthoai))==false)
				die('ERROR_SYSTEM');
			if($validate->check_number($giathau) == false)
				die('ERROR_SYSTEM');
			if($validate->check_number($thoigian) == false)
				die('ERROR_SYSTEM');
			$duan_id = mysql_real_escape_string($duan_id);
			$this->setModel("duan");
			$this->duan->showHasOne(array('account'));
			$this->duan->id = $duan_id;
			$this->duan->where(" and duan.active=1 and nhathau_id is null");
			$data = $this->duan->search('duan.id,tenduan,alias,account_id,duan_email,UNIX_TIMESTAMP(ngayketthuc)-UNIX_TIMESTAMP(now()) as lefttime,lastbid_nhathau');
			if(empty($data))
				die("ERROR_SYSTEM");
			if($data[""]["lefttime"] <= 0)
				die("ERROR_EXPIRED");
			$employerId = $data["duan"]["account_id"];
			if($employerId == $account_id)
				die("ERROR_SELFBID");
			if($data["duan"]["lastbid_nhathau"] == $nhathau_id)
				die("ERROR_DUPLICATE");
			$employerMail =  $data["duan"]["duan_email"];
			//Insert ho so thau
			$this->setModel("hosothau");
			$this->hosothau->id = null;
			$this->hosothau->account_id = $account_id;
			$this->hosothau->giathau = $giathau;
			$this->hosothau->thoigian = $thoigian;
			if($milestone!=null)
				$this->hosothau->milestone = $milestone;
			$this->hosothau->content = $content;
			$this->hosothau->duan_id = $duan_id;
			$this->hosothau->nhathau_id = $nhathau_id;
			$this->hosothau->ngaygui = GetDateSQL();
			$this->hosothau->trangthai = 1;
			$this->hosothau->hosothau_email = $hosothau_email;
			$this->hosothau->hosothau_sodienthoai = $hosothau_sodienthoai;
			$hosothau_id = $this->hosothau->insert(true);
			//Send mail cho chu du an
			$linkduan = BASE_PATH.'/duan/view/'.$data["duan"]["id"].'/'.$data["duan"]["alias"];
			$tenduan = $data["duan"]["tenduan"];
			$linkduan = "<a href='$linkduan'>$tenduan</a>";
			$linknhathau = BASE_PATH."/hosothau/xem_ho_so/$hosothau_id/$duan_id";
			$linknhathau = "<a href='$linknhathau'>$linknhathau</a>";
			global $cache;
			$content = $cache->get('mail_newbid');
			$search  = array('#LINKTENDUAN#', '#TENNHATHAU#', '#GIATHAU#', '#THOIGIAN#', '#MILESTONE#', '#LINK#');
			$replace = array($linkduan,$nhathau["displayname"],$giathau,$thoigian,$milestone,$linknhathau);
			$content = str_replace($search, $replace, $content);
			$this->setModel('sendmail');
			$this->sendmail->id = null;
			$this->sendmail->to = $employerMail;
			$this->sendmail->subject = 'JobBid.vn - Dự Án Của Bạn Vừa Có Người Đặt Thầu!';
			$this->sendmail->content = $content;
			$this->sendmail->isprior = 1;
			$this->sendmail->insert();
			//Update bidcount cua du an
			$data = $this->hosothau->custom("select count(*) as bidcount,sum(giathau) as total from hosothaus as hosothau where trangthai>=0 and duan_id=$duan_id");
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
			$duan_id = mysql_real_escape_string($duan_id);
			$this->hosothau->showHasOne(array('nhathau'));
			$this->hosothau->where("and nhathau.status>=0 and trangthai>=1 and duan_id=$duan_id");
			$this->hosothau->orderBy('hosothau.id','desc');
			$this->hosothau->setPage($ipageindex);
			$this->hosothau->setLimit(PAGINATE_LIMIT);
			$lstHosthau = $this->hosothau->search('hosothau.id,giathau,milestone,UNIX_TIMESTAMP(now())-UNIX_TIMESTAMP(ngaygui) as timeofbid,thoigian,nhathau.id,displayname,trangthai,diemdanhgia,content,nhathau.id,nhathau_alias');
			$totalPages = $this->hosothau->totalPages();
			$ipagesbefore = $ipageindex - INT_PAGE_SUPPORT;
			if ($ipagesbefore < 1)
				$ipagesbefore = 1;
			$ipagesnext = $ipageindex + INT_PAGE_SUPPORT;
			if ($ipagesnext > $totalPages)
				$ipagesnext = $totalPages;
			//print_r($lstDuan);die();
			$this->set('lstHosthau',$lstHosthau);
			$this->set('pagesindex',$ipageindex);
			$this->set('pagesbefore',$ipagesbefore);
			$this->set('pagesnext',$ipagesnext);
			$this->set('pageend',$totalPages);
			$this->set('duan_id',$duan_id);
			$this->_template->renderPage();
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
		$data = $this->hosothau->search("hosothau.id,duan.id,alias,tenduan,giathau,ngaygui,duan.nhathau_id,hosothau.nhathau_id,UNIX_TIMESTAMP(ngayketthuc)-UNIX_TIMESTAMP(now()) as lefttime,duan.active,trangthai");
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
		$this->set('title','Jobbid.vn - Danh Sách Hồ Sơ Thầu Đã Gửi');
		$this->_template->render();
	}
	function lstHosothauByNhathau($ipageindex) {
		$this->checkLogin(true);
		$this->checkNhathau(true);
		$nhathau_id = $_SESSION["nhathau"]["id"];
		$this->hosothau->showHasOne(array("duan"));
		$this->hosothau->where(" and trangthai>=1 and hosothau.nhathau_id = $nhathau_id");
		$this->hosothau->orderBy("hosothau.id","desc");
		$this->hosothau->setPage($ipageindex);
		$this->hosothau->setLimit(PAGINATE_LIMIT);
		$data = $this->hosothau->search("hosothau.id,duan.id,alias,tenduan,giathau,ngaygui,duan.nhathau_id,hosothau.nhathau_id,UNIX_TIMESTAMP(ngayketthuc)-UNIX_TIMESTAMP(now()) as lefttime,duan.active,trangthai");
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
			$this->checkLogin();
			$account_id = $_SESSION['account']['id'];
			$nhathau_id = isset($_SESSION['nhathau'])?$_SESSION['nhathau']['id']:-1;
			$hosothau_id = mysql_real_escape_string($hosothau_id);
			$duan_id = mysql_real_escape_string($duan_id);
			$this->setModel('duan');
			$this->duan->id = $duan_id;
			$this->duan->where(' and active=1');
			$data = $this->duan->search('account_id,hosothau_id');
			if(empty($data))
				error('Server đang quá tải, vui lòng thử lại sau!');
			$employerId = $data['duan']['account_id'];
			$hosotrungthau = $data['duan']['hosothau_id'];
			$this->setModel('hosothau');
			$this->hosothau->showHasOne(array('nhathau'));
			$this->hosothau->id = $hosothau_id;
			$this->hosothau->where(" and trangthai>=1");
			$data = $this->hosothau->search('hosothau.id,giathau,milestone,thoigian,hosothau_email,content,hosothau_sodienthoai,ngaygui,nhathau.id,nhathau.displayname,nhathau_alias');
			if(empty($data))
				error("Server đang quá tải, vui lòng thử lại sau!");
			if($account_id != $employerId && $nhathau_id != $data['nhathau']['id'])
				error('Chỉ có chủ dự án mới xem được hồ sơ thầu này!');
			$flag = true;
			if(($hosotrungthau ==null || $hosotrungthau !=$hosothau_id) && $nhathau_id != $data['nhathau']['id']) {
				$data['hosothau']['hosothau_email'] = '(Chỉ hiển thị khi bạn chọn hồ sơ này)';
				$data['hosothau']['hosothau_sodienthoai'] = '(Chỉ hiển thị khi bạn chọn hồ sơ này)';
				$flag = false;
			}
			$this->set('flag',$flag);
			$this->set('data',$data);
			$this->set('duan_id',$duan_id);
			$this->set('title','Thông tin hồ sơ thầu - Nhà thầu : '.$data['nhathau']["displayname"]);
			$this->_template->render();	
		}
	}
	function chonhoso() {
		try {
			$this->checkLogin(true);
			$this->checkActive(true);
			$this->checkLock(true);
			$account_id = $_SESSION["account"]["id"];
			$duan_id = $_GET["duan_id"];
			$hosothau_id = $_GET["hosothau_id"];
			if(isset($duan_id) && isset($hosothau_id)) {
				$hosothau_id = mysql_real_escape_string($hosothau_id);
				$duan_id = mysql_real_escape_string($duan_id);
				$this->hosothau->id = $hosothau_id;
				$data = $this->hosothau->search("nhathau_id,hosothau_email");
				if(empty($data))
					die("ERROR_SYSTEM");
				$nhathau_id = $data["hosothau"]["nhathau_id"];
				$freelancerMail = $data["hosothau"]["hosothau_email"];
				$this->hosothau->id = $hosothau_id;
				$this->hosothau->trangthai = 2;
				$this->hosothau->update();
				$this->setModel("duan");
				$this->duan->id = $duan_id;
				$this->duan->where(" and duan.account_id = $account_id");
				$data = $this->duan->search("id,tenduan,alias,linhvuc_id,duan_email,duan_sodienthoai");
				if(empty($data))
					die("ERROR_SYSTEM");
				$this->duan->id = $duan_id;
				$this->duan->nhathau_id = $nhathau_id;
				$this->duan->hosothau_id = $hosothau_id;
				$this->duan->timeupdate = GetDateSQL();
				$this->duan->update();
				//Send mail cho nha thau trung thau
				$linkduan = BASE_PATH.'/duan/view/'.$data["duan"]["id"].'/'.$data["duan"]["alias"];
				$tenduan = $data["duan"]["tenduan"];
				$linktenduan = "<a href='$linkduan'>$tenduan</a>";
				$linkduan = "<a href='$linkduan'>$linkduan</a>";
				global $cache;
				$content = $cache->get('mail_win');
				$search  = array('#LINKTENDUAN#', '#EMAIL#', '#SODIENTHOAI#', '#LINKDUAN#');
				$replace = array($linktenduan,$data['duan']['duan_email'],$data['duan']['duan_sodienthoai'],$linkduan);
				$content = str_replace($search, $replace, $content);
				$this->setModel('sendmail');
				$this->sendmail->id = null;
				$this->sendmail->to = $freelancerMail;
				$this->sendmail->subject = 'JobBid.vn - Chúc Mừng Bạn Đã Thắng Thầu!!!';
				$this->sendmail->content = $content;
				$this->sendmail->isprior = 1;
				$this->sendmail->insert();
				//Cap nhat so du an cua linh vuc
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