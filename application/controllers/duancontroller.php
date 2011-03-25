<?php

class DuanController extends VanillaController {
	function __construct($controller, $action) {		
		global $inflect;
		$this->_controller = ucfirst($controller);		
		$this->_action = $action;
		$model = 'duan';
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
		$this->setModel('duan');
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
    function listDuans($ipageindex) {
		$this->checkAdmin(true);
		$cond_exprired = $_GET['cond_exprired'];
		$strWhere = '';
		if($cond_exprired!=null && $cond_exprired=='true' ) {
			$strWhere.=' and ngayketthuc < now()';
		}
		$this->duan->showHasOne(array('linhvuc','account','tinh'));
		$this->duan->where($strWhere);
		$this->duan->orderBy('duan.id','desc');
		$this->duan->setPage($ipageindex);
		$this->duan->setLimit(PAGINATE_LIMIT);
		$lstDuan = $this->duan->search('duan.id,tenduan,alias,linhvuc_id,duan.account_id,tinh_id,tentinh,costmin,costmax,ngaypost,prior,views,duan.active,tenlinhvuc,username,ngayketthuc,nhathau_id,isbid,duan_email');
		$totalPages = $this->duan->totalPages();
		$ipagesbefore = $ipageindex - INT_PAGE_SUPPORT;
		if ($ipagesbefore < 1)
			$ipagesbefore = 1;
		$ipagesnext = $ipageindex + INT_PAGE_SUPPORT;
		if ($ipagesnext > $totalPages)
			$ipagesnext = $totalPages;
		//print_r($lstDuan);die();
		$this->set('lstDuan',$lstDuan);
		$this->set('pagesindex',$ipageindex);
		$this->set('pagesbefore',$ipagesbefore);
		$this->set('pagesnext',$ipagesnext);
		$this->set('pageend',$totalPages);
		$this->_template->renderPage();
	}
	function saveDuan() {
		$this->checkAdmin(true);
		try {
			$id = $_POST['duan_id'];
			$tenduan = $_POST['duan_tenduan'];
			$alias = $_POST['duan_alias'];
			$linhvuc_id = $_POST['duan_linhvuc_id'];
			$linhvuc_id = mysql_real_escape_string($linhvuc_id);
			$tinh_id = $_POST['duan_tinh_id'];
			$ngayketthuc = $_POST['duan_ngayketthuc'];
			$prior = $_POST['duan_prior'];
			$isbid = $_POST['duan_isbid'];
			$costmin = $_POST['duan_costmin'];
			$costmax = $_POST['duan_costmax'];
			$thongtinchitiet = $_POST['duan_thongtinchitiet'];
			$data_content = $_POST['duan_data'];
			$validate = new Validate();
			if($validate->check_date($ngayketthuc)==false)
				die('ERROR_SYSTEM');
			$ngayketthuc = SQLDate($ngayketthuc);
			if($id==null) { //insert
				die('ERROR_SYSTEM');
			} else { //update
				//die($thongtinchitiet);
				$this->duan->id = $id;
				$data = $this->duan->search('data_id');
				if(empty($data))
					die('ERROR_SYSTEM');
				$data_id = $data['duan']['data_id'];
				$this->setModel('data');
				if($data_id != null) {
					$this->data->id = $data_id;
					$this->data->delete();
				}
				$sIndex = "$tenduan ".strip_tags($data_content);
				$sIndex = strtolower(remove_accents($sIndex));
				$this->data->id = null;
				$this->data->data = $sIndex;
				$data_id = $this->data->insert(true);
				$this->setModel('duan');
				$this->duan->id = $id;
				$data = $this->duan->search('ngaypost');
				if(empty($data))
					die('ERROR_SYSTEM');
				$ngaypost = $data['duan']['ngaypost'];
				$this->duan->id = $id;
				$this->duan->tenduan = $tenduan;
				$this->duan->alias = $alias;
				$this->duan->linhvuc_id = $linhvuc_id;
				$this->duan->tinh_id = $tinh_id;
				$this->duan->prior = $prior;
				$this->duan->isbid = $isbid;
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
			$data = $this->duan->search('count(*) as soduan');
			$this->setModel('linhvuc');
			$this->linhvuc->id = $linhvuc_id;
			$this->linhvuc->soduan = $data[0]['']['soduan'];
			$this->linhvuc->update();
			echo 'DONE';
		} catch (Exception $e) {
			echo 'ERROR_SYSTEM';
		}
	}   
	function exist($id=null){
		$this->checkAdmin(true);
		if($id==null)
			die('ERROR_SYSTEM');
		$this->duan->id = $id;
		$data = $this->duan->search();
		if(empty($data)) {
			echo '0';
		} else {
			echo '1';
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
			$data = $this->duan->search('linhvuc_id');
			if(empty($data))
				die('ERROR_SYSTEM');
			$this->duan->id = $id;
			$this->duan->active = 1;
			$this->duan->save();
			$linhvuc_id = $data['duan']['linhvuc_id'];
			$this->duan->where(" and active = 1 and nhathau_id is null and ngayketthuc > now() and linhvuc_id = '$linhvuc_id'");
			$data = $this->duan->search('count(*) as soduan');
			$this->setModel('linhvuc');
			$this->linhvuc->id = $linhvuc_id;
			$this->linhvuc->soduan = $data[0]['']['soduan'];
			$this->linhvuc->update();
			echo 'DONE';
		}
	}
	function delete() {
		$this->checkAdmin(true);
		$id = $_GET['duan_id'];
		if(isset($id)) {
			$this->duan->id = $id;
			$data = $this->duan->search('linhvuc_id');
			if(empty($data))
				die('ERROR_SYSTEM');
			$this->duan->id = $id;
			$this->duan->delete();
			$linhvuc_id = $data['duan']['linhvuc_id'];
			$this->duan->where(" and active = 1 and nhathau_id is null and ngayketthuc > now() and linhvuc_id = '$linhvuc_id'");
			$data = $this->duan->search('count(*) as soduan');
			$this->setModel('linhvuc');
			$this->linhvuc->id = $linhvuc_id;
			$this->linhvuc->soduan = $data[0]['']['soduan'];
			$this->linhvuc->update();
			echo 'DONE';
		} else {
			echo 'ERROR_SYSTEM';
		}
	}
	function unActiveDuan($id=0) {
		$this->checkAdmin(true);
		if($id!=0) {
			$this->duan->id = $id;
			$data = $this->duan->search('linhvuc_id');
			if(empty($data))
				die('ERROR_SYSTEM');
			$this->duan->id = $id;
			$this->duan->active = 0;
			$this->duan->save();
			$linhvuc_id = $data['duan']['linhvuc_id'];
			$this->duan->where(" and active = 1 and nhathau_id is null and ngayketthuc > now() and linhvuc_id = '$linhvuc_id'");
			$data = $this->duan->search('count(*) as soduan');
			$this->setModel('linhvuc');
			$this->linhvuc->id = $linhvuc_id;
			$this->linhvuc->soduan = $data[0]['']['soduan'];
			$this->linhvuc->update();
			echo 'DONE';
		}
	}
	//User functions
	
	function tao_du_an_buoc_1($duan_id=null) {
		$isbid = 1;
		if($duan_id != null) {
			$this->duan->id = $duan_id;
			$this->duan->where(' and active=-1');
			$data = $this->duan->search('isbid');
			if(empty($data)==false)
				$isbid = $data['duan']['isbid'];
		}
		$this->set('duan_id',$duan_id);
		$this->set('isbid',$isbid);
		$this->set('title','Jobbid.vn - Tạo Dự Án');
		$this->_template->render();	
	}
	function tao_du_an_buoc_2($duan_id=null) {
		$isbid = null;
		if(isset($_POST['duan_isbid']))
			$isbid = $_POST['duan_isbid'];
		$tenduan = '';
		$alias = '';
		$linhvuc_id = '';
		$tinh_id = null;
		$ngayketthuc = null;
		$costmin = 0;
		$costmax = 0;
		if($duan_id != null) {
			$this->duan->id = $duan_id;
			$this->duan->where(' and active=-1');
			$data = $this->duan->search('id,tenduan,alias,linhvuc_id,tinh_id,ngayketthuc,costmin,costmax');
			if(empty($data))
				error('Lỗi! Vui lòng thử lại.');
			$tenduan = $data['duan']['tenduan'];
			$alias = $data['duan']['alias'];
			$linhvuc_id = $data['duan']['linhvuc_id'];
			$tinh_id = $data['duan']['tinh_id'];
			$ngayketthuc = $data['duan']['ngayketthuc'];
			$costmin = isset($data['duan']['costmin'])?$data['duan']['costmin']:0;
			$costmax = isset($data['duan']['costmax'])?$data['duan']['costmax']:0;
			if(isset($isbid)) {
				$this->duan->id = $duan_id;
				$this->duan->isbid = $isbid;
				$this->duan->update();
			}
			$this->setModel('duanskill');
			$duan_id = mysql_real_escape_string($duan_id);
			$this->duanskill->showHasOne(array('skill'));
			$this->duanskill->where(" and duan_id = $duan_id");
			$data = $this->duanskill->search('skill.id,skillname');
			$this->set('lstSkill',$data);
		} else {
			if(isset($isbid)) {
				$this->duan->id = null;
				$this->duan->isbid = $isbid;
				$currentDate = GetDateSQL();
				$this->duan->ngaypost = $currentDate;
				$this->duan->active = -1;
				$duan_id = $this->duan->insert(true);
			}
		}
		$this->set('duan_id',$duan_id);
		$this->set('tenduan',$tenduan);
		$this->set('alias',$alias);
		$this->set('linhvuc_id',$linhvuc_id);
		$this->set('tinh_id',$tinh_id);
		$this->set('ngayketthuc',$ngayketthuc);
		$this->set('costmin',$costmin);
		$this->set('costmax',$costmax);
		$this->setModel('linhvuc');
		$data = $this->linhvuc->search();
		$this->set('lstLinhvuc',$data);
		$this->setModel('tinh');
		$data = $this->tinh->search();
		$this->set('lstTinh',$data);
		$this->set('title','Jobbid.vn - Tạo Dự Án');
		$this->_template->render();	
	}
	function submit_tao_du_an_buoc_2() {
		try {
			if(isset($_POST['duan_id'])==false)
				die('ERROR_SYSTEM');
			$duan_id = $_POST['duan_id'];
			$this->duan->id = $duan_id;
			$this->duan->where(' and active=-1');
			$data = $this->duan->search('id');
			if(empty($data))
				die('ERROR_SYSTEM');
			$tenduan = $_POST['duan_tenduan'];
			$alias = $_POST['duan_alias'];
			$linhvuc_id = $_POST['duan_linhvuc_id'];
			$tinh_id = $_POST['duan_tinh_id'];
			$ngayketthuc = $_POST['duan_ngayketthuc'];
			$costmin = $_POST['duan_costmin'];
			$costmax = $_POST['duan_costmax'];
			if(isset($_POST['duan_skills'])) {
				if(isset($_POST['duan_skills'][MAX_SKILL]))
					die('ERROR_MAXSKILL');
			}
			$validate = new Validate();
			if($validate->check_null(array($tenduan,$alias,$linhvuc_id,$tinh_id,$ngayketthuc,$costmin,$costmax))==false)
				die('ERROR_SYSTEM');
			if($validate->check_date($ngayketthuc)==false)
				die('ERROR_SYSTEM');
			$ngayketthuc = SQLDate($ngayketthuc);
			$this->duan->id = $duan_id;
			$this->duan->tenduan = $tenduan;
			$this->duan->alias = $alias;
			$this->duan->linhvuc_id = $linhvuc_id;
			$this->duan->tinh_id = $tinh_id;
			$this->duan->costmin = $costmin;
			$this->duan->costmax = $costmax;
			$this->duan->ngayketthuc = $ngayketthuc;
			$this->duan->update();
			$this->setModel('duanskill');
			$duan_id = mysql_real_escape_string($duan_id);
			$this->duanskill->custom("delete from duanskills where duan_id = $duan_id");
			if(isset($_POST['duan_skills'])) {
				$lstSkill= $_POST['duan_skills'];
				foreach($lstSkill as $skill_id) {
					$this->duanskill->id=null;
					$this->duanskill->duan_id=$duan_id;
					$this->duanskill->skill_id=$skill_id;
					$this->duanskill->insert();
				}
			}
			echo 'DONE';
		} catch (Exception $e) {
			echo 'ERROR_SYSTEM';
		}
	}
	function tao_du_an_buoc_3($duan_id=null) {
		if($duan_id==null)
			error('Liên kết không hợp lệ!');
		$email = '';
		$sodienthoai = '';
		if(isset($_SESSION['account'])) {
			$email = $_SESSION['account']['username'];
			$sodienthoai = $_SESSION['account']['sodienthoai'];
		}
		$this->set('duan_id',$duan_id);
		$this->set('email',$email);
		$this->set('sodienthoai',$sodienthoai);
		$this->set('title','Jobbid.vn - Tạo Dự Án');
		$this->_template->render();	
	}
	function submit_tao_du_an_buoc_3() {
		try {
			if(isset($_POST['duan_id'])==false)
				die('ERROR_SYSTEM');
			$duan_id = $_POST['duan_id'];
			$this->duan->id = $duan_id;
			$this->duan->where(' and active=-1');
			$data = $this->duan->search('id,tenduan,alias');
			if(empty($data))
				die('ERROR_SYSTEM');
			$tenduan = $data['duan']['tenduan'];
			$alias = $data['duan']['alias'];
			$email = $_POST['duan_email'];
			$sodienthoai = $_POST['duan_sodienthoai'];
			$thongtinchitiet = $_POST['duan_thongtinchitiet'];
			$file_id = $_POST['duan_filedinhkem'];
			$validate = new Validate();
			if($validate->check_submit(1,array('duan_email','duan_sodienthoai'))==false)
				die('ERROR_SYSTEM');
			if($validate->check_null(array($email,$sodienthoai))==false)
				die('ERROR_SYSTEM');
			if(!$validate->check_email($email))
				die('ERROR_SYSTEM');
			$account_id = null;
			$flagSendmail = 1;
			global $cache;
			if(isset($_SESSION['account'])) {
				$account_id = $_SESSION['account']['id'];
				if($email != $_SESSION['account']['username']) //Post du an dum nguoi khac
					$flagSendmail = 2;
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
			$this->setModel('data');
			$sIndex = "$tenduan ".strip_tags($thongtinchitiet);
			$sIndex = strtolower(remove_accents($sIndex));
			$this->data->id = null;
			$this->data->data = $sIndex;
			$data_id = $this->data->insert(true);
			$this->setModel('duan');
			$this->duan->id = $duan_id;
			$this->duan->duan_email = $email;
			$this->duan->duan_sodienthoai = $sodienthoai;
			$this->duan->thongtinchitiet = $thongtinchitiet;
			if($file_id!=0)
				$this->duan->file_id = $file_id;
			$this->duan->account_id = $account_id;
			$this->duan->prior = '0';
			$currentDate = GetDateSQL();
			$this->duan->timeupdate = $currentDate;
			$this->duan->views = '0';
			$this->duan->bidcount = '0';
			$this->duan->averagecost = '0';
			$this->duan->isnew = 1;
			$this->duan->data_id = $data_id;
			$editcode = genString(20);
			$this->duan->editcode = $editcode;
			if(isset($_SESSION['account']) && $_SESSION['account']['active']==1) {
				if($flagSendmail==1)
					$this->duan->active = 1;
				else
					$this->duan->active = 0;
			}
			//die($email);
			$this->duan->update();
			$content = '';
			$subject = '';
			if($flagSendmail==1) {
				$linkview = BASE_PATH."/duan/view/$duan_id/$alias&editcode=$editcode";
				$linkview = "<a href='$linkview'>$tenduan</a>";
				$content = $cache->get('mail_postproject');
				$search  = array('#LINKVIEW#');
				$replace = array($linkview);
				$content = str_replace($search, $replace, $content);
				$subject = "Đã đăng dự án [$tenduan] lên JobBid.vn!!!";
			} else {
				$linkxacnhan = BASE_PATH."/duan/permission/$duan_id/$editcode";
				$linkxacnhan = "<a href='$linkxacnhan'>$linkxacnhan</a>";
				$content = $cache->get('mail_permission');
				$search  = array('#TENDUAN#','#LINKXACNHAN#');
				$replace = array($tenduan, $linkxacnhan);
				$content = str_replace($search, $replace, $content);
				$subject = "[EMAIL XIN PHÉP] Đăng dự án [$tenduan] lên JobBid.vn!!!";
				
			}
			$myprojects = array();
			if(isset($_SESSION['myprojects']))
				$myprojects = $_SESSION['myprojects'];
			array_push($myprojects,$duan_id);
			$_SESSION['myprojects'] = $myprojects;
			$this->setModel('sendmail');
			$this->sendmail->id = null;
			$this->sendmail->to = $email;
			$this->sendmail->subject = $subject;;
			$this->sendmail->content = $content;
			$this->sendmail->isprior = 1;
			$this->sendmail->insert();
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
	function permission($id=null,$editcode=null) {
		if($id==null || $editcode==null)
			error('Liên kết không hợp lệ!');
		$editcode = mysql_real_escape_string($editcode);
		$this->duan->id = $id;
		$this->duan->where(" and editcode='$editcode'");
		$data = $this->duan->search('id,tenduan,alias,duan_email,active');
		if(empty($data))
			error('Mã xác nhận không đúng!');
		if($data['duan']['active']==1)
			error('Dự án này đã được xác nhận rồi!');
		$email = $data['duan']['duan_email'];
		$tenduan = $data['duan']['tenduan'];
		$alias = $data['duan']['alias'];
		$this->duan->id = $id;
		$currentDate = GetDateSQL();
		$this->duan->timeupdate = $currentDate;
		$this->duan->active = 1;
		$this->duan->update();
		$myprojects = array();
		if(isset($_SESSION['myprojects']))
			$myprojects = $_SESSION['myprojects'];
		if(in_array($id,$myprojects)==false) {
			array_push($myprojects,$id);
			$_SESSION['myprojects'] = $myprojects;
		}
		global $cache;
		$linkview = BASE_PATH."/duan/view/$id/$alias&editcode=$editcode";
		$linkview = "<a href='$linkview'>$tenduan</a>";
		$content = $cache->get('mail_postproject');
		$search  = array('#LINKVIEW#');
		$replace = array($linkview);
		$content = str_replace($search, $replace, $content);
		$this->setModel('sendmail');
		$this->sendmail->id = null;
		$this->sendmail->to = $email;
		$this->sendmail->subject = "Đã đăng dự án [$tenduan] lên JobBid.vn!!!";
		$this->sendmail->content = $content;
		$this->sendmail->isprior = 1;
		$this->sendmail->insert();
		$linkview = BASE_PATH."/duan/view/$id/$alias";
		$this->set('linkview',$linkview);
		$this->set('title',"Bạn đã xác nhận đồng ý đăng dự án lên JobBid.vn!");
		$this->_template->render();
	}
	function search() {
		$_SESSION['redirect_url'] = getUrl();
		$this->setModel('linhvuc');
		$data = $this->linhvuc->search();
		$this->set('lstLinhvuc',$data);
		$this->setModel('tinh');
		$data = $this->tinh->search();
		$this->set('lstTinh',$data);
		$this->setModel('duanskill');
		$this->duanskill->showHasOne();
		$this->duanskill->hasJoin(array('skill'),array('linhvuc'));
		$this->duanskill->groupBy('tenlinhvuc,skillname');
		$this->duanskill->where(' and duan.active=1 and duan.nhathau_id is null and ngayketthuc>now()');
		$data = $this->duanskill->search('linhvuc.id,tenlinhvuc,skill.id,skillname,count(*) as soduan');
		$this->set('lstData2',$data);
		$keyword = isset($_POST['keyword'])?' - Từ khóa : '.$_POST['keyword']:'';
		$this->set('title',"Tìm Dự Án$keyword");
		$this->_template->render();
	}
	function view($id=null) {
		if($id != null && $id != 0) {
			$id = mysql_real_escape_string($id);
			$_SESSION['redirect_url'] = getUrl();
			$this->duan->showHasOne(array('linhvuc','tinh','file','nhathau'));
			$this->duan->id=$id;
            $data=$this->duan->search('duan.id,tenduan,linhvuc_id,tenlinhvuc,tentinh,costmin,costmax,thongtinchitiet,filename,file.id,ngaypost,duan.account_id,views,bidcount,averagecost,ngayketthuc,UNIX_TIMESTAMP(ngayketthuc)-UNIX_TIMESTAMP(now()) as timeleft,duan.active,nhathau.id,displayname,hosothau_id,isbid,duan_email,duan_sodienthoai,editcode');
			//print_r($data);
			if(empty($data)==false) {
				$myprojects = array();
				if(isset($_SESSION['myprojects']))
					$myprojects = $_SESSION['myprojects'];
				$isEmployer = false;
				if(in_array($id,$myprojects)==false) {
					$editcode= '';
					if(isset($_GET['editcode']))
						$editcode = $_GET['editcode'];
					if($editcode!=null && $editcode == $data['duan']['editcode']) {
						array_push($myprojects,$id);
						$_SESSION['myprojects'] = $myprojects;
						$isEmployer = true;
					}
				} else 
					$isEmployer = true;
				$viewcount = $data['duan']['views'];
				$this->duan->id=$id;
				$this->duan->views=$viewcount+1;
				$this->duan->save();
				if($data['duan']['active'] != 1 || isset($data['nhathau']['id']) || $data['']['timeleft']<0) {
					$this->set('status','Đã đóng');
					$data['']['lefttime'] = -1;
				} else 
					$this->set('status','Đang mở');
				$this->set('title','Jobbid.vn - '.$data['duan']['tenduan']);
				$this->set('dataDuan',$data);
				$this->setModel('duanskill');
				$this->duanskill->showHasOne(array('skill'));
				$this->duanskill->where(" and duan_id=$id ");
				$data = $this->duanskill->search('skillname,skill_id');
				$this->set('lstSkill',$data);
				$strWhere = '';
				foreach($data as $skill) {
					$strWhere.=' skill_id='.$skill['duanskill']['skill_id'].' or';
				}
				if(isset($strWhere[2])) {
					$strWhere = substr($strWhere,0,-2);
					$this->duanskill->showHasOne(array('duan'));
					$this->duanskill->orderBy('n','desc');
					$this->duanskill->groupBy('duan_id');
					$this->duanskill->setPage(1);
					$this->duanskill->setLimit(5);
					$this->duanskill->where(" and ($strWhere) and duan_id<>$id and duan.active=1 and duan.nhathau_id is null and ngayketthuc>now()");
					$data = $this->duanskill->search('duan.id,alias,tenduan,count(*) n');
					$this->set('relatedProjects',$data);
				}
				$this->set('isEmployer',$isEmployer);
				$this->_template->render();
			} else
				error('Liên kết không tồn tại!');
		}
	}
	function doMarkDuan() {
		try {
			$this->checkLogin(true);
			$duan_id = $_GET['duan_id'];
			$duan_id = mysql_real_escape_string($duan_id);
			if($duan_id == null)
				die('ERROR_SYSTEM');
			$this->setModel('duanmark');
			$account_id = $_SESSION['account']['id'];
			$data = $this->duanmark->custom("select id from duanmarks as duanmark where account_id=$account_id and duan_id=$duan_id");
			if(!empty($data))
				die('ERROR_EXIST');
			$this->duanmark->id = null;
			$this->duanmark->account_id = $account_id;
			$this->duanmark->duan_id = $duan_id;
			$this->duanmark->insert();
			echo 'DONE';
		} catch (Exception $e) {
			echo 'ERROR_SYSTEM';
		}
	}
	function viewmarks() {
		$_SESSION['redirect_url'] = getUrl();
		$this->checkLogin();
		$account_id = $_SESSION['account']['id'];
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
		$this->set('lstDuan',$data);
		$this->set('pagesindex',1);
		$this->set('pagesbefore',$ipagesbefore);
		$this->set('pagesnext',$ipagesnext);
		$this->set('pageend',$totalPages);
		$this->set('title','Jobbid.vn - Danh Sách Dự Án Bạn Quan Tâm');
		$this->_template->render();
	}
	function lstDuanMark($ipageindex) {
		$this->checkLogin();
		$ipageindex = mysql_real_escape_string($ipageindex);
		$account_id = $_SESSION['account']['id'];
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
		$this->set('lstDuan',$data);
		$this->set('pagesindex',$ipageindex);
		$this->set('pagesbefore',$ipagesbefore);
		$this->set('pagesnext',$ipagesnext);
		$this->set('pageend',$totalPages);
		$this->_template->renderPage();
	}
	function deleteDuanmark() {
		$duan_id = $_GET['duan_id'];
		if(isset($duan_id)) {
			$this->checkLogin(true);
			$account_id = $_SESSION['account']['id'];
			$this->setModel('duanmark');
			$this->duanmark->custom("delete from duanmarks where account_id=$account_id and duan_id=".mysql_real_escape_string($duan_id));
			echo 'DONE';
		} else {
			echo 'ERROR_SYSTEM';
		}
		
	}
	function viewMyprojects() {
		$_SESSION['redirect_url'] = getUrl();
		$this->checkLogin();
		$account_id = $_SESSION['account']['id'];
		$this->duan->showHasOne(array('linhvuc'));
		$this->duan->orderBy('duan.id','desc');
		$this->duan->setPage(1);
		$this->duan->setLimit(PAGINATE_LIMIT);
		$this->duan->where(" and duan.account_id = $account_id");
		$data = $this->duan->search('duan.id,tenduan,alias,linhvuc_id,tenlinhvuc,averagecost,ngaypost,prior,views,bidcount,UNIX_TIMESTAMP(ngayketthuc)-UNIX_TIMESTAMP(now()) as timeleft,duan.active,nhathau_id');
		$totalPages = $this->duan->totalPages();
		$ipagesbefore = 1 - INT_PAGE_SUPPORT;
		if ($ipagesbefore < 1)
			$ipagesbefore = 1;
		$ipagesnext = 1 + INT_PAGE_SUPPORT;
		if ($ipagesnext > $totalPages)
			$ipagesnext = $totalPages;
		//print_r($lstDuan);die();
		$this->set('lstDuan',$data);
		$this->set('pagesindex',1);
		$this->set('pagesbefore',$ipagesbefore);
		$this->set('pagesnext',$ipagesnext);
		$this->set('pageend',$totalPages);
		$this->set('title','Jobbid.vn - Danh Sách Dự Án Của Bạn');
		$this->_template->render();
	}
	function lstMyProjects($ipageindex) {
		$this->checkLogin();
		$ipageindex = mysql_real_escape_string($ipageindex);
		$account_id = $_SESSION['account']['id'];
		$this->duan->showHasOne(array('linhvuc'));
		$this->duan->orderBy('duan.id','desc');
		$this->duan->setPage($ipageindex);
		$this->duan->setLimit(PAGINATE_LIMIT);
		$this->duan->where(" and duan.account_id = $account_id");
		$data = $this->duan->search('duan.id,tenduan,alias,linhvuc_id,tenlinhvuc,averagecost,ngaypost,prior,views,bidcount,UNIX_TIMESTAMP(ngayketthuc)-UNIX_TIMESTAMP(now()) as timeleft,duan.active,nhathau_id');
		$totalPages = $this->duan->totalPages();
		$ipagesbefore = $ipageindex - INT_PAGE_SUPPORT;
		if ($ipagesbefore < 1)
			$ipagesbefore = 1;
		$ipagesnext = $ipageindex + INT_PAGE_SUPPORT;
		if ($ipagesnext > $totalPages)
			$ipagesnext = $totalPages;
		//print_r($lstDuan);die();
		$this->set('lstDuan',$data);
		$this->set('pagesindex',$ipageindex);
		$this->set('pagesbefore',$ipagesbefore);
		$this->set('pagesnext',$ipagesnext);
		$this->set('pageend',$totalPages);
		$this->_template->renderPage();
	}
	function edit($duan_id=null) {
		if($duan_id==null)
			error('Liên kết không hợp lệ!');
		$_SESSION['redirect_url'] = getUrl();
		$duan_id = mysql_real_escape_string($duan_id);
		$this->duan->showHasOne(array('file'));
		$this->duan->id = $duan_id;
		$data = $this->duan->search('duan.id,tenduan,linhvuc_id,tinh_id,costmax,costmin,thongtinchitiet,file.id,filename,duan.account_id,active,ngayketthuc,nhathau_id,UNIX_TIMESTAMP(ngayketthuc)-UNIX_TIMESTAMP(now()) as lefttime,isbid,duan_email,duan_sodienthoai,editcode');
		if(empty($data))
			error('Liên kết không hợp lệ!');
		$myprojects = array();
		if(isset($_SESSION['myprojects']))
			$myprojects = $_SESSION['myprojects'];
		if(in_array($duan_id,$myprojects)==false) {
			$editcode= '';
			$isEmployer = false;
			if(isset($_GET['editcode']))
				$editcode = $_GET['editcode'];
			if($editcode!=null && $editcode == $data['duan']['editcode']) {
				$isEmployer = true;
			} else {
				$this->checkLogin();
				$this->checkActive();
				$this->checkLock();
				$account_id = $_SESSION['account']['id'];
				if($data['duan']['account_id']==$account_id)
					$isEmployer = true;
			}
			if($isEmployer == true) {
				array_push($myprojects,$duan_id);
				$_SESSION['myprojects'] = $myprojects;
			} else 
				error('Bạn không thể chỉnh sửa thông tin dự án của người khác!');
			
		}
		
		$this->set('dataDuan',$data['duan']);
		$this->set('lefttime',$data['']['lefttime']);
		if($data['file']['filename']!='')
			$this->set('dataFile',$data['file']);
			
		$this->setModel('skill');
		$this->skill->where(" and linhvuc_id = '".$data['duan']['linhvuc_id']."'");
		$data = $this->skill->search('id,skillname');
		$this->set('lstSkillByLinhvuc',$data);
			
		$this->setModel('duanskill');
		$this->duanskill->showHasOne(array('skill'));
		$this->duanskill->where(" and duan_id = $duan_id");
		$data = $this->duanskill->search('skill.id,skillname');
		$this->set('lstSkill',$data);
		
		$this->setModel('linhvuc');
		$data = $this->linhvuc->search();
		$this->set('lstLinhvuc',$data);
		
		$this->setModel('tinh');
		$data = $this->tinh->search();
		$this->set('lstTinh',$data);
		$this->set('title','Jobbid.vn - Chỉnh Sửa Dự Án');
		$this->_template->render();	
	}
	function doEdit() {
		try {
			$duan_id = mysql_real_escape_string($_POST['duan_id']);
			if($duan_id==null)
				die('ERROR_SYSTEM');
			$myprojects = array();
			if(isset($_SESSION['myprojects']))
				$myprojects = $_SESSION['myprojects'];
			if(in_array($duan_id,$myprojects)==false) {
				$this->checkLogin(true);
				$this->checkActive(true);
				$this->checkLock(true);
				die('ERROR_SYSTEM');
			}
			$tenduan = $_POST['duan_tenduan'];
			$alias = $_POST['duan_alias'];
			$linhvuc_id = $_POST['duan_linhvuc_id'];
			$tinh_id = $_POST['duan_tinh_id'];
			$ngayketthuc = $_POST['duan_ngayketthuc'];
			$costmin = $_POST['duan_costmin'];
			$costmax = $_POST['duan_costmax'];
			$thongtinchitiet = $_POST['duan_thongtinchitiet'];
			$duan_email = $_POST['duan_email'];
			$duan_sodienthoai = $_POST['duan_sodienthoai'];
			$isbid = $_POST['duan_isbid'];
			//Validate
			if(isset($_POST['duan_skills'])) {
				if(isset($_POST['duan_skills'][MAX_SKILL]))
					die('ERROR_MAXSKILL');
			}
			$validate = new Validate();
			if($validate->check_null(array($duan_id,$tenduan,$alias,$linhvuc_id,$tinh_id,$ngayketthuc,$costmin,$costmax,$thongtinchitiet,$isbid,$duan_email,$duan_sodienthoai))==false)
				die('ERROR_SYSTEM');
			if($validate->check_date($ngayketthuc)==false)
				die('ERROR_SYSTEM');
			$ngayketthuc = SQLDate($ngayketthuc);
			//End validate
			$this->duan->id = $duan_id;
			$data = $this->duan->search('id,ngaypost,ngayketthuc,data_id');
			if(empty($data))
				die('ERROR_SYSTEM');
			$ngaypost = $data['duan']['ngaypost'];
			$data_id = $data['duan']['data_id'];
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
			}
			//End
			$this->setModel('data');
			$sIndex = "$tenduan ".strip_tags($thongtinchitiet);
			$sIndex = strtolower(remove_accents($sIndex));
			$this->data->id = $data_id;
			$this->data->data = $sIndex;
			$this->data->update();
			$this->setModel('duan');
			$this->duan->id = $duan_id;
			$this->duan->tenduan = $tenduan;
			$this->duan->alias = $alias;
			$this->duan->linhvuc_id = $linhvuc_id;
			$this->duan->tinh_id = $tinh_id;
			$this->duan->costmin = $costmin;
			$this->duan->costmax = $costmax;
			$this->duan->isbid = $isbid;
			if($file_id!=0)
				$this->duan->file_id = $file_id;
			$this->duan->thongtinchitiet = $thongtinchitiet;
			$currentDate = GetDateSQL();
			$this->duan->timeupdate = $currentDate;
			$this->duan->ngayketthuc = $ngayketthuc;
			$this->duan->duan_email = $duan_email;
			$this->duan->duan_sodienthoai = $duan_sodienthoai;
			if($data['duan']['ngayketthuc'] > $currentDate)
				$this->duan->nhathau_id = '';
			$this->duan->update();
			$this->setModel('duanskill');
			$this->duanskill->custom("delete from duanskills where duan_id = $duan_id");
			if(isset($_POST['duan_skills'])) {
				$lstSkill= $_POST['duan_skills'];
				foreach($lstSkill as $skill_id) {
					$this->duanskill->id=null;
					$this->duanskill->duan_id=$duan_id;
					$this->duanskill->skill_id=$skill_id;
					$this->duanskill->insert();
				}
			}
			echo 'DONE';
		} catch (Exception $e) {
			echo 'ERROR_SYSTEM';
		}
	}
	function doRemove($duan_id=null,$editcode=null) {
		if($duan_id == null || $editcode==null)
			error('Liên kết không hợp lệ!');
		$editcode = mysql_real_escape_string($editcode);
		$this->duan->id = $duan_id;
		$this->duan->where(" and editcode = '$editcode'");
		$data = $this->duan->search('id');
		if(empty($data))
			error('Liên kết không hợp lệ!');
		else {
			$this->duan->id = $duan_id;
			if($this->duan->delete()==-1) {
				error('Thao tác bị lỗi, vui lòng thử lại sau!');
			} else {
				success('Xóa dự án của bạn thành công!');
			}
		}
	}
	function changeStatusProject($active=null) {
		if($active == null || ($active!=0 && $active!=1))
			die('ERROR_SYSTEM');
		try {
			$this->checkLogin(true);
			$this->checkActive(true);
			$this->checkLock(true);
			$account_id = $_SESSION['account']['id'];
			$duan_id = mysql_real_escape_string($_GET['duan_id']);
			$this->duan->id = $duan_id;
			$data = $this->duan->search('linhvuc_id');
			if(empty($data))
				die('ERROR_SYSTEM');
			$this->duan->active = $active;
			if($active == 1)
				$this->duan->nhathau_id = '';
			$this->duan->update(" id = $duan_id and account_id = $account_id");
			$linhvuc_id = $data['duan']['linhvuc_id'];
			$this->duan->where(" and active = 1 and nhathau_id is null and ngayketthuc > now() and linhvuc_id = '$linhvuc_id'");
			$data = $this->duan->search('count(*) as soduan');
			$this->setModel('linhvuc');
			$this->linhvuc->id = $linhvuc_id;
			$this->linhvuc->soduan = $data[0]['']['soduan'];
			$this->linhvuc->update();
			
			echo 'DONE';	
		} catch (Exception $e) {
			echo 'ERROR_SYSTEM';
		}
	}
	function lstDuanBySearch() {
		$cond_keyword = $_POST['duan_keyword'];
		$cond_linhvuc = $_POST['linhvuc_id'];
		$cond_tinh = $_POST['tinh_id'];
		$ipageindex = $_POST['pageindex'];
		if(!isset($ipageindex))
			$ipageindex = 1;
		$strWhere = ' and active = 1';
		if(isset($cond_keyword) && $cond_keyword!='' ) {
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
		$this->duan->showHasOne(array('linhvuc','data'));
		$this->duan->where($strWhere);
		$this->duan->orderBy('duan.id','desc');
		$this->duan->setPage($ipageindex);
		$this->duan->setLimit(PAGINATE_LIMIT);
		$lstDuan = $this->duan->search('duan.id,tenduan,alias,linhvuc_id,tenlinhvuc,averagecost,ngaypost,prior,views,bidcount,UNIX_TIMESTAMP(ngayketthuc)-UNIX_TIMESTAMP(now()) as timeleft,duan.active,nhathau_id');
		$totalPages = $this->duan->totalPages();
		$ipagesbefore = $ipageindex - INT_PAGE_SUPPORT;
		if ($ipagesbefore < 1)
			$ipagesbefore = 1;
		$ipagesnext = $ipageindex + INT_PAGE_SUPPORT;
		if ($ipagesnext > $totalPages)
			$ipagesnext = $totalPages;
		$this->set('lstDuan',$lstDuan);
		$this->set('pagesindex',$ipageindex);
		$this->set('pagesbefore',$ipagesbefore);
		$this->set('pagesnext',$ipagesnext);
		$this->set('pageend',$totalPages);
		$this->_template->renderPage();
	}
	function lstMyActivityProject() {
		$this->checkLogin(true);
		$this->checkActive(true);
		$this->checkLock(true);
		$account_id = $_SESSION['account']['id'];
		$this->duan->where(" and duan.active=1 and duan.nhathau_id is null and ngayketthuc>now() and account_id=$account_id");
		$data = $this->duan->search('id,tenduan,alias');
		if(empty($data))
			die('NO_PROJECT');
		foreach($data as $duan) {
			$linkduan = BASE_PATH.'/duan/view/'.$duan['duan']['id'].'/'.$duan['duan']['alias'];
			$tenduan = $duan['duan']['tenduan'];
			$duan_id = $duan['duan']['id'];
			echo "<li><a class='link' id='moithau_$duan_id' href='javascript:showDialogVerify($duan_id)'>$tenduan</a></li>";
		}
	}
	function active_account() {
		$this->set('title','Vui lòng kiểm tra email để xác nhận tài khoản của bạn');
		$this->_template->render();  
	}
	function afterAction() {

	}

}