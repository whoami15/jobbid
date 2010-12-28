<?php

class LinhvucController extends VanillaController {
	function __construct($controller, $action) {		
		global $inflect;
		$this->_controller = ucfirst($controller);		
		$this->_action = $action;
		$model = "linhvuc";
		$this->$model =& new $model;
		$this->_template =& new Template($controller,$action);
	}
	function beforeAction () {
		performAction('webmaster', 'updateStatistics');
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
	function setModel($model) {
		 $this->$model =& new $model;
	}
    function listLinhvucs($ipageindex) {
		//die("ERROR_NOTLOGIN");
		$this->checkAdmin();
		$this->linhvuc->orderBy('id','desc');
		$this->linhvuc->setPage($ipageindex);
		$this->linhvuc->setLimit(PAGINATE_LIMIT);
		$lstLinhvucs = $this->linhvuc->search();
		$totalPages = $this->linhvuc->totalPages();
		$ipagesbefore = $ipageindex - INT_PAGE_SUPPORT;
		if ($ipagesbefore < 1)
			$ipagesbefore = 1;
		$ipagesnext = $ipageindex + INT_PAGE_SUPPORT;
		if ($ipagesnext > $totalPages)
			$ipagesnext = $totalPages;
		$this->set("lstLinhvucs",$lstLinhvucs);
		$this->set('pagesindex',$ipageindex);
		$this->set('pagesbefore',$ipagesbefore);
		$this->set('pagesnext',$ipagesnext);
		$this->set('pageend',$totalPages);
		$this->_template->renderPage();
	}
	
	function saveLinhvuc() {
		$this->checkAdmin(true);
		$id = $_POST["linhvuc_id"];
		$tenlinhvuc = $_POST["linhvuc_tenlinhvuc"];
		if($id==null) { //insert
			die("ERROR_SYSTEM");						
		} 
		$this->linhvuc->id = $id;
		$linhvuc = $this->linhvuc->search();
		$this->linhvuc->id = $id;
		$this->linhvuc->tenlinhvuc = $tenlinhvuc;
		if(empty($linhvuc)==false) { //update
			$this->linhvuc->update();
		} else {
			$this->linhvuc->insert(false);
		}
		echo "DONE";
	}  
	function deleteLinhvuc() {
		try {
			$this->checkAdmin(true);
			$id = $_GET["linhvuc_id"];
			if($id==null) { //insert
				die("ERROR_SYSTEM");						
			} else { //update
				$this->linhvuc->id = $id;
				$this->linhvuc->delete();
			}
			echo "DONE";
		} catch (Exception $e) {
			echo 'ERROR_SYSTEM';
		}
	}	
	function exist($id=null){
		$this->checkAdmin(true);
		if($id==null)
			die("ERROR_SYSTEM");
		$this->linhvuc->id = $id;
		$linhvuc = $this->linhvuc->search();
		if(empty($linhvuc)) {
			echo "0";
		} else {
			echo "1";
		}
	}
	//Functions User
	function index() {
		$id = $_GET['linhvuc_id'];
		if($id!=null) {
			$id = mysql_real_escape_string($id);
			$_SESSION['redirect_url'] = getUrl();
			$this->linhvuc->id = $id;
			$data = $this->linhvuc->search();
			$this->set("dataLinhvuc",$data);
			$this->setModel("duan");
			$this->duan->where(" and linhvuc_id='$id' and duan.active=1 and nhathau_id is null and ngayketthuc>now()");
			$this->duan->orderBy('duan.id','desc');
			$this->duan->setPage(1);
			$this->duan->setLimit(PAGINATE_LIMIT);
			$lstDuan = $this->duan->search("duan.id,tenduan,alias,linhvuc_id,duan.account_id,averagecost,ngaypost,prior,views,bidcount,UNIX_TIMESTAMP(ngayketthuc)-UNIX_TIMESTAMP(now()) as timeleft");
			$totalPages = $this->duan->totalPages();
			$ipagesbefore = 1 - INT_PAGE_SUPPORT;
			if ($ipagesbefore < 1)
				$ipagesbefore = 1;
			$ipagesnext = 1 + INT_PAGE_SUPPORT;
			if ($ipagesnext > $totalPages)
				$ipagesnext = $totalPages;
			//print_r($lstDuan);die();
			$this->set("lstDuan",$lstDuan);
			$this->set('pagesindex',1);
			$this->set('pagesbefore',$ipagesbefore);
			$this->set('pagesnext',$ipagesnext);
			$this->set('pageend',$totalPages);
			$this->_template->render();
		}
	}
	function lstDuanByLinhvuc($ipageindex) {
		$id = $_GET["id"];
		if($id!=null) {
			$this->setModel("duan");
			$id = mysql_real_escape_string($id);
			$this->duan->where(" and linhvuc_id='$id' and duan.active=1 and nhathau_id is null and ngayketthuc>now()");
			$this->duan->orderBy('duan.id','desc');
			$this->duan->setPage($ipageindex);
			$this->duan->setLimit(PAGINATE_LIMIT);
			$lstDuan = $this->duan->search("duan.id,tenduan,alias,linhvuc_id,duan.account_id,averagecost,ngaypost,prior,views,bidcount,UNIX_TIMESTAMP(ngayketthuc)-UNIX_TIMESTAMP(now()) as timeleft");
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
	}
	function afterAction() {

	}

}