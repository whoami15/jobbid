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

	}
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
		$_SESSION['redirect_url'] = getUrl();
		$id = $_GET["id"];
		if($id!=null) {
			$this->linhvuc->showHasMany();
			$this->linhvuc->where(" and linhvuc.id='$id' ");
			$select = array();
			array_push($select,"*");
			array_push($select,"tenduan");
			$data = $this->linhvuc->search($select);
			print_r($data);die();
		}
	}
	function afterAction() {

	}

}