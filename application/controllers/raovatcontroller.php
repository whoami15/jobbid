<?php

class RaovatController extends VanillaController {
	function __construct($controller, $action) {		
		global $inflect;
		$this->_controller = ucfirst($controller);		
		$this->_action = $action;
		$model = 'raovat';
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
				die('ERROR_NOTLOGIN');
			} else {
				redirect(BASE_PATH.'/account/login');
				die();
			}
		}
	}
	function checkActive($isAjax=false,$msg='Vui lòng kiểm tra email để xác nhận tài khoản!') {
		if($_SESSION['account']['active']==0) {
			if($isAjax == true) {
				die('ERROR_NOTACTIVE');
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
				die('ERROR_LOCKED');
			} else {
				error('Tài khoản này đã bị khóa, vui lòng liên hệ admin@jobbid.vn để mở lại!');
			}
		}
		$this->setModel('raovat');
	}
	function checkAdmin($isAjax=false) {
		if($isAjax==false)
			$_SESSION['redirect_url'] = getUrl();
		if(!isset($_SESSION['account']) || $_SESSION['account']['role']>1) {
			if($isAjax == true) {
				die('ERROR_NOTLOGIN');
			} else {
				redirect(BASE_PATH.'/admin/login&reason=admin');
				die();
			}
		}
	}
	function setModel($model) {
		 $this->$model =& new $model;
	}
    function listRaovat($ipageindex) {
		$this->checkAdmin(true);
		$this->raovat->showHasOne(array('account'));
		$this->raovat->where($strWhere);
		$this->raovat->orderBy('raovat.id','desc');
		$this->raovat->setPage($ipageindex);
		$this->raovat->setLimit(PAGINATE_LIMIT);
		$lstRaovat = $this->raovat->search('raovat.id,tieude,ngaypost,ngayupdate,views,username,status');
		$totalPages = $this->raovat->totalPages();
		$ipagesbefore = $ipageindex - INT_PAGE_SUPPORT;
		if ($ipagesbefore < 1)
			$ipagesbefore = 1;
		$ipagesnext = $ipageindex + INT_PAGE_SUPPORT;
		if ($ipagesnext > $totalPages)
			$ipagesnext = $totalPages;
		//print_r($lstRaovat);die();
		$this->set('lstRaovat',$lstRaovat);
		$this->set('pagesindex',$ipageindex);
		$this->set('pagesbefore',$ipagesbefore);
		$this->set('pagesnext',$ipagesnext);
		$this->set('pageend',$totalPages);
		$this->_template->renderPage();
	}
	function saveRaovat() {
		$this->checkAdmin(true);
		try {
			$id = $_POST['raovat_id'];
			$tieude = $_POST['raovat_tieude'];
			$alias = $_POST['raovat_alias'];
			$noidung = $_POST['raovat_noidung'];
			if($id==null) { //insert
				die('ERROR_SYSTEM');
			} else { //update
				$this->raovat->id = $id;
				$this->raovat->tieude = $tieude;
				$this->raovat->alias = $alias;
				$this->raovat->noidung = $noidung;
			}
			$this->raovat->save();
			echo 'DONE';
		} catch (Exception $e) {
			echo 'ERROR_SYSTEM';
		}
	}   
	function getnoidungById($id=null) {	
		if($id != null) {
			$id = mysql_real_escape_string($id);
			$this->raovat->id=$id;
            $data=$this->raovat->search();
			print_r($data['raovat']['noidung']);
		}
	}
	function activeRaovat($id=0) {
		$this->checkAdmin(true);
		if($id!=0) {
			$this->raovat->id = $id;
			$this->raovat->active = 1;
			$this->raovat->save();
			echo 'DONE';
		}
	}
	function delete() {
		$this->checkAdmin(true);
		$id = $_GET['raovat_id'];
		if(isset($id)) {
			$this->raovat->id = $id;
			$this->raovat->delete();
			echo 'DONE';
		} else {
			echo 'ERROR_SYSTEM';
		}
	}
	function unActiveRaovat($id=0) {
		$this->checkAdmin(true);
		if($id!=0) {
			$this->raovat->id = $id;
			$this->raovat->active = 0;
			$this->raovat->save();
			echo 'DONE';
		}
	}
	//User functions
	function dang_tin_rao_vat() {
		$email = '';
		$sodienthoai = '';
		if(isset($_SESSION['account'])) {
			$email = $_SESSION['account']['username'];
			$sodienthoai = $_SESSION['account']['sodienthoai'];
		}
		$this->set('email',$email);
		$this->set('sodienthoai',$sodienthoai);
		$this->set('title','Jobbid.vn - Đăng tin rao vặt');
		$this->_template->render();	
	}
	function submit_dang_tin_rao_vat() {
		try {
			$tieude = $_POST['raovat_tieude'];
			$alias = $_POST['raovat_alias'];
			$email = $_POST['raovat_email'];
			$sodienthoai = $_POST['raovat_sodienthoai'];
			$noidung = $_POST['raovat_noidung'];
			$validate = new Validate();
			if($validate->check_submit(1,array('raovat_email','raovat_sodienthoai','raovat_tieude','raovat_alias','raovat_noidung'))==false)
				die('ERROR_SYSTEM');
			if($validate->check_null(array($email,$sodienthoai,$tieude,$noidung))==false)
				die('ERROR_SYSTEM');
			if(!$validate->check_email($email))
				die('ERROR_SYSTEM');
			$account_id = null;
			global $cache;
			$status = 0;
			if(isset($_SESSION['account'])) {
				$account_id = $_SESSION['account']['id'];
				$status = 1;
			} else {
				$this->setModel('account');
				$strWhere = "AND username='".mysql_real_escape_string($email)."'";
				$this->account->where($strWhere);
				$data2 = $this->account->search('id');
				if(!empty($data2))
					die('ERROR_EXIST');
				$this->account->id = null;
				$this->account->username = $email;
				$this->account->timeonline = 0;
				$this->account->role = 2;
				$this->account->active = 0;
				$account_id = $this->account->insert(true);
				$this->account->id = $account_id;
				$data2 = $this->account->search();
				$_SESSION['account']=$data2['account'];
				$active_code = genString();
				$this->setModel('activecode');
				$this->activecode->id = null;
				$this->activecode->account_id = $account_id;
				$this->activecode->active_code = $active_code;
				$this->activecode->insert();
				//Send active code
				$linkactive = BASE_PATH."/webmaster/doActive/true&account_id=$account_id&active_code=$active_code";
				$linkactive = "<a href='$linkactive'>$linkactive</a>";
				$content = $cache->get('mail_verify');
				$search  = array('#LINKACTIVE#', '#ACTIVECODE#', '#USERNAME#');
				$replace = array($linkactive, $active_code, $email);
				$content = str_replace($search, $replace, $content);
				$senders = $cache->get('senders');
				$sender = $senders['priSender'];
				include (ROOT.DS.'library'.DS.'sendmail.php');
				$mail = new sendmail();
				$mail->send($email,'JobBid.vn - Mail Xác Nhận Đăng Ký Tài Khoản!',$content,$sender);
			}
			$this->setModel('raovat');
			$this->raovat->id = null;
			$this->raovat->raovat_email = $email;
			$this->raovat->raovat_sodienthoai = $sodienthoai;
			$this->raovat->noidung = $noidung;
			$this->raovat->tieude = $tieude;
			$this->raovat->alias = $alias;
			$currentDate = GetDateSQL();
			$this->raovat->ngaypost = $currentDate;
			$this->raovat->ngayupdate = $currentDate;
			$this->raovat->views = 0;
			$this->raovat->account_id = $account_id;
			$this->raovat->status = $status;
			$this->raovat->insert();
			if(isset($_SESSION['account'])) {
				if($_SESSION['account']['active']==1)
					echo 'OK';
				else
					echo 'NOT_ACTIVE';
			} else {
				echo 'NOT_ACTIVE';
			}
		} catch (Exception $e) {
			echo 'ERROR_SYSTEM';
		}
	}
	function view($id=null) {
		if($id != null && $id != 0) {
			$id = mysql_real_escape_string($id);
			$_SESSION['redirect_url'] = getUrl();
			$this->raovat->id=$id;
            $data=$this->raovat->search('raovat.id,tieude,noidung,ngaypost,ngayupdate,views,status,account_id,raovat_email,raovat_sodienthoai');
			//print_r($data);
			if(empty($data)==false) {
				$isEmployer = false;
				if(isset($_SESSION['account'])) {
					if($_SESSION['account']['id'] == $data['raovat']['account_id'])
						$isEmployer = true;
				}
				$viewcount = $data['raovat']['views'];
				$this->raovat->id=$id;
				$this->raovat->views=$viewcount+1;
				$this->raovat->save();
				$this->set('title','Jobbid.vn - '.$data['raovat']['tieude']);
				$this->set('dataRaovat',$data);
				$this->set('isEmployer',$isEmployer);
				$this->_template->render();
			} else
				error('Liên kết không tồn tại!');
		}
	}
	function quan_ly_tin_rao_vat() {
		$_SESSION['redirect_url'] = getUrl();
		$this->checkLogin();
		$account_id = $_SESSION['account']['id'];
		$this->raovat->orderBy('raovat.ngayupdate','desc');
		$this->raovat->setPage(1);
		$this->raovat->setLimit(PAGINATE_LIMIT);
		$this->raovat->where(" and raovat.account_id = $account_id");
		$data = $this->raovat->search('raovat.id,tieude,alias,ngaypost,ngayupdate,views,raovat_email,raovat.status');
		$totalPages = $this->raovat->totalPages();
		$ipagesbefore = 1 - INT_PAGE_SUPPORT;
		if ($ipagesbefore < 1)
			$ipagesbefore = 1;
		$ipagesnext = 1 + INT_PAGE_SUPPORT;
		if ($ipagesnext > $totalPages)
			$ipagesnext = $totalPages;
		//print_r($lstRaovat);die();
		$this->set('lstRaovat',$data);
		$this->set('pagesindex',1);
		$this->set('pagesbefore',$ipagesbefore);
		$this->set('pagesnext',$ipagesnext);
		$this->set('pageend',$totalPages);
		$this->set('title','Jobbid.vn - Trang Quản Lý Tin Rao Vặt Của Bạn');
		$this->_template->render();
	}
	function lstTinraocuatoi($ipageindex) {
		$this->checkLogin();
		$ipageindex = mysql_real_escape_string($ipageindex);
		$account_id = $_SESSION['account']['id'];
		$this->raovat->orderBy('raovat.ngayupdate','desc');
		$this->raovat->setPage($ipageindex);
		$this->raovat->setLimit(PAGINATE_LIMIT);
		$this->raovat->where(" and raovat.account_id = $account_id");
		$data = $this->raovat->search('raovat.id,tieude,alias,ngaypost,ngayupdate,views,raovat_email,raovat.status');
		$totalPages = $this->raovat->totalPages();
		$ipagesbefore = $ipageindex - INT_PAGE_SUPPORT;
		if ($ipagesbefore < 1)
			$ipagesbefore = 1;
		$ipagesnext = $ipageindex + INT_PAGE_SUPPORT;
		if ($ipagesnext > $totalPages)
			$ipagesnext = $totalPages;
		//print_r($lstRaovat);die();
		$this->set('lstRaovat',$data);
		$this->set('pagesindex',$ipageindex);
		$this->set('pagesbefore',$ipagesbefore);
		$this->set('pagesnext',$ipagesnext);
		$this->set('pageend',$totalPages);
		$this->_template->renderPage();
	}
	function edit($raovat_id=null) {
		$this->checkLogin();
		$this->checkActive();
		$this->checkLock();
		if($raovat_id==null)
			error('Liên kết không hợp lệ!');
		$_SESSION['redirect_url'] = getUrl();
		$raovat_id = mysql_real_escape_string($raovat_id);
		$this->raovat->id = $raovat_id;
		$data = $this->raovat->search('raovat.id,tieude,noidung,raovat.account_id,status,raovat_email,raovat_sodienthoai');
		if(empty($data))
			error('Liên kết không hợp lệ!');
		if($_SESSION['account']['id'] != $data['raovat']['account_id'])
			error('Bạn không thể chỉnh sửa tin rao của người khác!');
			
		$this->set('dataRaovat',$data['raovat']);
		$this->set('title','Jobbid.vn - Chỉnh Sửa Tin Rao');
		$this->_template->render();	
	}
	function doEdit() {
		$this->checkLogin(true);
		$this->checkActive(true);
		$this->checkLock(true);
		try {
			$raovat_id = mysql_real_escape_string($_POST['raovat_id']);
			if($raovat_id==null)
				die('ERROR_SYSTEM');
			$this->raovat->id = $raovat_id;
			$data = $this->raovat->search('account_id');
			if(empty($data))
				die('ERROR_SYSTEM');
			if($_SESSION['account']['id'] != $data['raovat']['account_id'])
				die('ERROR_SYSTEM');
			$tieude = $_POST['raovat_tieude'];
			$alias = $_POST['raovat_alias'];
			$email = $_POST['raovat_email'];
			$sodienthoai = $_POST['raovat_sodienthoai'];
			$noidung = $_POST['raovat_noidung'];
			//Validate
			$validate = new Validate();
			if($validate->check_submit(1,array('raovat_email','raovat_sodienthoai','raovat_tieude','raovat_alias','raovat_noidung'))==false)
				die('ERROR_SYSTEM');
			if($validate->check_null(array($email,$sodienthoai,$tieude,$noidung))==false)
				die('ERROR_SYSTEM');
			if(!$validate->check_email($email))
				die('ERROR_SYSTEM');
			//End validate
			global $cache;
			$this->raovat->id = $raovat_id;
			$this->raovat->raovat_email = $email;
			$this->raovat->raovat_sodienthoai = $sodienthoai;
			$this->raovat->noidung = $noidung;
			$this->raovat->tieude = $tieude;
			$this->raovat->alias = $alias;
			$this->raovat->ngayupdate = GetDateSQL();
			$this->raovat->update();
			echo 'DONE';
		} catch (Exception $e) {
			echo 'ERROR_SYSTEM';
		}
	}
	function doRemove($raovat_id=null) {
		$this->checkLogin(true);
		if($raovat_id == null)
			error('Liên kết không hợp lệ!');
		$account_id = $_SESSION['account']['id'];
		$this->raovat->id = $raovat_id;
		$this->raovat->where(" and account_id = $account_id");
		$data = $this->raovat->search('id');
		if(empty($data))
			error('Bạn không thể xóa tin rao của người khác!');
		else {
			$this->raovat->id = $raovat_id;
			if($this->raovat->delete()==-1) {
				error('Thao tác bị lỗi, vui lòng thử lại sau!');
			} else {
				success('Xóa tin rao của bạn thành công!');
			}
		}
	}
	function changeStatus($active=null) {
		if($active == null || ($active!=0 && $active!=1))
			die('ERROR_SYSTEM');
		try {
			$this->checkLogin(true);
			$this->checkActive(true);
			$this->checkLock(true);
			$account_id = $_SESSION['account']['id'];
			$raovat_id = mysql_real_escape_string($_GET['raovat_id']);
			$this->raovat->status = $active;
			$this->raovat->ngayupdate = GetDateSQL();
			$this->raovat->update(" id = $raovat_id and account_id = $account_id");
			echo 'DONE';	
		} catch (Exception $e) {
			echo 'ERROR_SYSTEM';
		}
	}
	function active_account() {
		$this->set('title','Vui lòng kiểm tra email để xác nhận tài khoản của bạn');
		$this->_template->render();  
	}
	function afterAction() {

	}

}