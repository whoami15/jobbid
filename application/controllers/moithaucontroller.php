<?php

class MoithauController extends VanillaController {
	function __construct($controller, $action) {		
		global $inflect;
		$this->_controller = ucfirst($controller);		
		$this->_action = $action;
		$model = "moithau";
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
	function laythumoithaumoi() {
		$this->checkLogin(true);
		$account_id = $_SESSION['account']['id'];
		$data = $this->moithau->custom("select count(*) as newletters from moithaus where account_id=$account_id and hadread=0");
		echo $data[0]['']['newletters'];
	}
	function viewMyLetters() {
		$_SESSION['redirect_url'] = getUrl();
		$this->checkLogin();
		$account_id = $_SESSION["account"]["id"];
		$this->moithau->showHasOne(array('duan'));
		$this->moithau->orderBy('hadread,time','desc');
		$this->moithau->setPage(1);
		$this->moithau->setLimit(PAGINATE_LIMIT);
		$this->moithau->where(" and moithau.account_id = $account_id");
		$data = $this->moithau->search("moithau.id,duan.id,tenduan,alias,bidcount,averagecost,UNIX_TIMESTAMP(ngayketthuc)-UNIX_TIMESTAMP(now()) as timeleft,duan.active,nhathau_id,hadread");
		$totalPages = $this->moithau->totalPages();
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
	function doRead($moithau_id=null) {
		if($moithau_id==null)
			error('Liên kết bị lỗi!');
		$_SESSION['redirect_url'] = getUrl();
		$this->checkLogin();
		$this->moithau->showHasOne(array('duan'));
		$this->moithau->id = $moithau_id;
		$data = $this->moithau->search('hadread,duan_id,alias');
		if(empty($data))
			error('Không tìm thấy thư mời thầu này!');
		$duan_id = $data['moithau']['duan_id'];
		$alias = $data['duan']['alias'];
		if($data['moithau']['hadread']==0) {
			$this->moithau->id = $moithau_id;
			$this->moithau->hadread = 1;
			$this->moithau->update();
		}
		redirect(BASE_PATH."/duan/view/$duan_id/$alias");
	}
	function afterAction() {

	}

}