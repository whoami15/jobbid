<?php

class IndexController extends VanillaController {
	function __construct($controller, $action) {		
		global $inflect;
		$this->_controller = ucfirst($controller);
		
		$this->_action = $action;
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
	function index() {
		//error('Test');
		//print_r(session_cache_expire());die();
		$this->setModel("duan");
		$this->duan->showHasOne(array('linhvuc'));
		$this->duan->orderBy('duan.id','desc');
		$this->duan->setPage(1);
		$this->duan->setLimit(PAGINATE_LIMIT);
		$this->duan->where(" and active = 1 and nhathau_id is null and ngayketthuc>now()");
		$data = $this->duan->search("duan.id,tenduan,alias,linhvuc_id,tenlinhvuc,averagecost,ngaypost,prior,views,bidcount,UNIX_TIMESTAMP(ngayketthuc)-UNIX_TIMESTAMP(now()) as timeleft,duan.active");
		$this->set("lstData1",$data);
		$this->duan->showHasOne(array('nhathau','hosothau'));
		$this->duan->orderBy('timeupdate','desc');
		$this->duan->setPage(1);
		$this->duan->setLimit(5);
		$this->duan->where(" and duan.active = 1 and duan.nhathau_id is not null");
		$data = $this->duan->search("duan.id,tenduan,alias,linhvuc_id,tenlinhvuc,giathau,prior,bidcount,displayname,duan.nhathau_id,duan.active,nhathau_alias");
		$this->set("lstData2",$data);
		$this->setModel("linhvuc");
		$data = $this->linhvuc->search();
		$this->set("lstLinhvuc",$data);
		$this->_template->render();
	}
        
	function afterAction() {

	}

}