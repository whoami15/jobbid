<?php

class EmailController extends VanillaController {
	function __construct($controller, $action) {		
		global $inflect;
		$this->_controller = ucfirst($controller);		
		$this->_action = $action;
		$model = 'email';
		$this->$model =& new $model;
		$this->_template =& new Template($controller,$action);
	}
	function beforeAction () {	
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
	
    function listEmail($ipageindex) {
		$this->checkAdmin();
		$this->email->orderBy('id','desc');
		$this->email->setPage($ipageindex);
		$this->email->setLimit(PAGINATE_LIMIT);
		$strWhere = '';
		if(isset($_GET['keyword'])) {
			$keyword = $_GET['keyword'];
			if($keyword!=null)
				$strWhere.=" and email like '%$keyword%'";
		}
		$this->email->where($strWhere);	
		$lstEmail = $this->email->search();
		$totalPages = $this->email->totalPages();
		$ipagesbefore = $ipageindex - INT_PAGE_SUPPORT;
		if ($ipagesbefore < 1)
			$ipagesbefore = 1;
		$ipagesnext = $ipageindex + INT_PAGE_SUPPORT;
		if ($ipagesnext > $totalPages)
			$ipagesnext = $totalPages;
		$this->set('lstEmail',$lstEmail);
		$this->set('pagesindex',$ipageindex);
		$this->set('pagesbefore',$ipagesbefore);
		$this->set('pagesnext',$ipagesnext);
		$this->set('pageend',$totalPages);
		$this->_template->renderPage();
	}
	function saveEmail() {
		try {
			$this->checkAdmin(true);
			if(!isset($_GET['email']))
				die('ERROR_SYSTEM');
			$email = $_GET['email'];
			$this->email->where(" and email = '$email'");
			$data = $this->email->search();
			if(empty($data)==false)
				die('ERROR_EXIST');
			$this->email->id = null;
			$this->email->email = $email;
			$this->email->insert();
			echo 'DONE';
		} catch (Exception $e) {
			echo 'ERROR_SYSTEM';
		}
	}  
	function deleteEmail($id=null) {
		$this->checkAdmin(true);
		if($id==null)
			die('ERROR_SYSTEM');
		$this->email->id = $id;
		if($this->email->delete()==-1) {
			echo "ERROR_SYSTEM";
		} else {
			echo "DONE";
		}
	}
	function afterAction() {

	}

}