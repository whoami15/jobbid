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
		$cond_id = isset($_GET['cond_id'])?$_GET['cond_id']:null;
		$cond_account = isset($_GET['cond_account'])?$_GET['cond_account']:null;
		$strWhere = '';
		if(isset($cond_id) && $cond_id!='' ) {
			$cond_id = mysql_real_escape_string($cond_id);
			$cond_id = strtolower(remove_accents($cond_id));
			$strWhere.=" and raovat.id = $cond_id ";
		}
		if(isset($cond_account) && $cond_account!='' ) {
			$cond_account = mysql_real_escape_string($cond_account);
			$cond_account = strtolower(remove_accents($cond_account));
			$strWhere.=" and username like '%$cond_account%'";
		}
		$this->raovat->showHasOne(array('account'));
		$this->raovat->where($strWhere);
		$this->raovat->orderBy('raovat.id','desc');
		$this->raovat->setPage($ipageindex);
		$this->raovat->setLimit(PAGINATE_LIMIT);
		$lstRaovat = $this->raovat->search('raovat.id,tieude,alias,ngaypost,ngayupdate,views,username,status,raovat_email,raovat_sodienthoai,isvip,expirevip');
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
			$email = $_POST['raovat_email'];
			$sodienthoai = $_POST['raovat_sodienthoai'];
			$noidung = $_POST['raovat_noidung'];
			$isvip = $_POST['raovat_isvip'];
			$expirevip = $_POST['raovat_expirevip'];
			$expirevip = SQLDate($expirevip);
			if($id==null) { //insert
				die('ERROR_SYSTEM');
			} else { //update
				$this->raovat->id = $id;
				$this->raovat->tieude = $tieude;
				$this->raovat->alias = $alias;
				$this->raovat->raovat_email = $email;
				$this->raovat->raovat_sodienthoai = $sodienthoai;
				$this->raovat->noidung = $noidung;
				$this->raovat->isvip = $isvip;
				$this->raovat->expirevip = $expirevip;
			}
			$this->raovat->save();
			
			echo 'DONE';
		} catch (Exception $e) {
			echo 'ERROR_SYSTEM';
		}
	}   
	function refeshCache() {
		$this->checkAdmin(true);
		global $cache;
		$this->updatecache();
		$result = $this->raovat->custom("SELECT id,tieude,alias FROM `raovats` as `raovat` WHERE status=1 and isvip=1 and expirevip > now() order by ngayupdate desc LIMIT 7 OFFSET 0");
		$data = array();
		foreach($result as $raovat) {
			array_push($data,array('id'=>$raovat['raovat']['id'],'tieude'=>$raovat['raovat']['tieude'],'alias'=>$raovat['raovat']['alias']));
		}
		$cache->set('vips',$data);
		echo 'DONE';
	} 
	function duan2raovat($duan_id=null) {
		$this->checkAdmin(true);
		if($duan_id==null)
			die('ERROR_SYSTEM');
		try {
			$this->setModel('duan');
			$this->duan->id = $duan_id;
			$data = $this->duan->search('tenduan,alias,duan_email,duan_sodienthoai,thongtinchitiet,ngaypost,account_id,linhvuc_id,views');
			if(empty($data))
				die('ERROR_SYSTEM');
			$linhvuc_id = $data['duan']['linhvuc_id'];
			$this->duan->id = $duan_id;
			$this->duan->delete();
			$linhvuc_id = $data['duan']['linhvuc_id'];
			$this->duan->where(" and active = 1 and approve = 1 and nhathau_id is null and ngayketthuc > now() and linhvuc_id = '$linhvuc_id'");
			$data2 = $this->duan->search('count(*) as soduan');
			$this->setModel('linhvuc');
			$this->linhvuc->id = $linhvuc_id;
			$this->linhvuc->soduan = $data2[0]['']['soduan'];
			$this->linhvuc->update();
			$this->setModel('raovat');
			$this->raovat->id = null;
			$this->raovat->tieude = $data['duan']['tenduan'];
			$this->raovat->alias = $data['duan']['alias'];
			$this->raovat->raovat_email = $data['duan']['duan_email'];
			$this->raovat->raovat_sodienthoai = $data['duan']['duan_sodienthoai'];
			$this->raovat->noidung = $data['duan']['thongtinchitiet'];
			$this->raovat->ngaypost = $data['duan']['ngaypost'];
			$this->raovat->account_id = $data['duan']['account_id'];
			$this->raovat->views = $data['duan']['views'];
			$this->raovat->ngayupdate = GetDateSQL();
			$this->raovat->status = 1;
			$this->raovat->insert();
			$this->updatecache();
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
			$this->raovat->status = 1;
			$this->raovat->save();
			$this->updatecache();
			echo 'DONE';
		}
	}
	function delete() {
		$this->checkAdmin(true);
		$id = $_GET['raovat_id'];
		if(isset($id)) {
			$this->raovat->id = $id;
			$this->raovat->delete();
			$this->updatecache();
			echo 'DONE';
		} else {
			echo 'ERROR_SYSTEM';
		}
	}
	function unActiveRaovat($id=0) {
		$this->checkAdmin(true);
		if($id!=0) {
			$this->raovat->id = $id;
			$this->raovat->status = 0;
			$this->raovat->save();
			$this->updatecache();
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
			$max_raovat = isset($_SESSION['MAX_RAOVAT'])?$_SESSION['MAX_RAOVAT']:0;
			if($max_raovat >= MAX_RAOVAT) {
				die('MAX_RAOVAT');
			} 
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
			if($validate->check_length($tieude,101))
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
				$priSenders = $cache->get('priSenders');
				$sender = $priSenders[mt_rand(0, count($priSenders)-1)];
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
			$this->updatecache();
			$max_raovat++;
			$_SESSION['MAX_RAOVAT'] = $max_raovat;
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
				$status = 'Đang rao';
				if($data['raovat']['status']!=1)
					$status = 'Đã ngưng rao';
				$this->set('title','Jobbid.vn - '.$data['raovat']['tieude']);
				$this->set('dataRaovat',$data);
				$this->set('status',$status);
				$this->set('isEmployer',$isEmployer);
				$raovatcomment_ten = '';
				$raovatcomment_url = '';
				if(isset($_SESSION['nhathau'])) {
					$raovatcomment_ten = $_SESSION['nhathau']['displayname'];
					$raovatcomment_url = BASE_PATH.'/nhathau/xem_ho_so/'.$_SESSION['nhathau']['id'].'/'.$_SESSION['nhathau']['nhathau_alias'];
				}
				$this->set('title','Jobbid.vn - '.$data["raovat"]["tieude"]);
				$this->set('raovatcomment_ten',$raovatcomment_ten);
				$this->set('raovatcomment_url',$raovatcomment_url);
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
			if($validate->check_length($tieude,101))
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
			$this->updatecache();
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
				$this->updatecache();
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
			$this->updatecache();
			echo 'DONE';	
		} catch (Exception $e) {
			echo 'ERROR_SYSTEM';
		}
	}
	function active_account() {
		$this->set('title','Vui lòng kiểm tra email để xác nhận tài khoản của bạn');
		$this->_template->render();  
	}
	function upraovat($raovat_id=null){
		$this->checkLogin(true);
		$this->checkActive(true);
		$this->checkLock(true);
		if($raovat_id==null)
			die('ERROR_SYSTEM');
		$raovat_id = mysql_real_escape_string($raovat_id);
		$this->raovat->id = $raovat_id;
		$data = $this->raovat->search('account_id');
		if(empty($data))
			die('ERROR_SYSTEM');
		if($_SESSION['account']['id'] != $data['raovat']['account_id'])
			die('ERROR_DENIED');
		$this->raovat->id = $raovat_id;
		$this->raovat->ngayupdate = GetDateSQL();
		$this->raovat->update();
		$this->updatecache();
		echo 'DONE';
			
	}
	function updatecache() {
		$result = $this->raovat->custom("SELECT id,tieude,alias FROM `raovats` as `raovat` WHERE status=1 order by ngayupdate desc LIMIT 7 OFFSET 0");
		global $cache;
		$data = array();
		foreach($result as $raovat) {
			array_push($data,array('id'=>$raovat['raovat']['id'],'tieude'=>$raovat['raovat']['tieude'],'alias'=>$raovat['raovat']['alias']));
		}
		$cache->set('raovats',$data);
	}
	function danhsachraovat($pageindex=1) {
		$_SESSION['redirect_url'] = getUrl();
		$this->raovat->orderBy('ngayupdate','desc');
		$this->raovat->setPage($pageindex);
		$this->raovat->setLimit(PAGINATE_LIMIT);
		$this->raovat->where(' and `status`=1');
		$data = $this->raovat->search('id,alias,tieude,noidung');
		$totalPages = $this->raovat->totalPages();
		$ipagesbefore = $pageindex - INT_PAGE_SUPPORT;
		if ($ipagesbefore < 1)
			$ipagesbefore = 1;
		$ipagesnext = $pageindex + INT_PAGE_SUPPORT;
		if ($ipagesnext > $totalPages)
			$ipagesnext = $totalPages;
		$this->set("lstRaovat",$data);
		$this->set('pagesindex',$pageindex);
		$this->set('pagesbefore',$ipagesbefore);
		$this->set('pagesnext',$ipagesnext);
		$this->set('pageend',$totalPages);
		$this->set('title','Jobbid.vn - Danh sách tin rao vặt');
		$this->_template->render();
	}
	function getvips() {
		global $cache;
		$vips = $cache->get('vips');
		echo json_encode($vips);
	}
	function comments($raovat_id=null,$pageindex=1) {
		if($raovat_id==null)
			die();
		$this->setModel('raovatcomment');
		$raovat_id = mysql_real_escape_string($raovat_id);
		$this->raovatcomment->orderBy('ngaypost','desc');
		$this->raovatcomment->setPage($pageindex);
		$this->raovatcomment->setLimit(7);
		$this->raovatcomment->where(" and raovat_id=$raovat_id");
		$data = $this->raovatcomment->search('id,ten,url,noidung,UNIX_TIMESTAMP(now())-UNIX_TIMESTAMP(ngaypost) as timeofpost');
		$totalPages = $this->raovatcomment->totalPages();
		$ipagesbefore = $pageindex - INT_PAGE_SUPPORT;
		if ($ipagesbefore < 1)
			$ipagesbefore = 1;
		$ipagesnext = $pageindex + INT_PAGE_SUPPORT;
		if ($ipagesnext > $totalPages)
			$ipagesnext = $totalPages;
		//print_r($lstDuan);die();
		$this->set("lstComment",$data);
		$this->set('pagesindex',$pageindex);
		$this->set('pagesbefore',$ipagesbefore);
		$this->set('pagesnext',$ipagesnext);
		$this->set('pageend',$totalPages);
		$this->_template->renderPage();
	}
	function doSaveComment() {
		try {
			if( $_SESSION['security_code'] == $_POST['security_code'] && !empty($_SESSION['security_code'] ) ) {
				unset($_SESSION['security_code']);
			} else {
				die("ERROR_SECURITY_CODE");
			}
			$validate = new Validate();
			if($validate->check_submit(1,array("raovat_id","raovatcomment_ten","raovatcomment_url","raovatcomment_noidung"))==false)
				die('ERROR_SYSTEM');
			$raovat_id = $_POST["raovat_id"];
			$ten = $_POST["raovatcomment_ten"];
			$url = $_POST["raovatcomment_url"];
			if($url==null)
				$url = '#';
			$noidung = $_POST["raovatcomment_noidung"];
			if($validate->check_null(array($raovat_id,$ten,$noidung))==false)
				die('ERROR_SYSTEM');
			$this->raovat->id = $raovat_id;
			$data = $this->raovat->search('id');
			if(empty($data))
				die('ERROR_SYSTEM');
			$this->raovat->id = $raovat_id;
			$this->raovat->ngayupdate = GetDateSQL();
			$this->raovat->update();
			$this->updatecache();
			$this->setModel('raovatcomment');
			$this->raovatcomment->id = null;
			$this->raovatcomment->ten = $ten;
			$this->raovatcomment->url = $url;
			$this->raovatcomment->raovat_id = $raovat_id;
			$this->raovatcomment->noidung = $noidung;
			$this->raovatcomment->ngaypost = GetDateSQL();
			$this->raovatcomment->insert();
			echo 'DONE';
		} catch (Exception $e) {
			echo 'ERROR_SYSTEM';
		}
	}
	function doDeleteComment() {
		$this->checkAdmin(true);
		if(!isset($_GET["comment_id"]))
			die("ERROR_SYSTEM");
		$id = $_GET["comment_id"];
		$this->setModel('raovatcomment');
		$this->raovatcomment->id=$id;
		if($this->raovatcomment->delete()==-1) {
			echo "ERROR_SYSTEM";
		} else {
			echo "DONE";
		}
	}
	function afterAction() {

	}
	
}