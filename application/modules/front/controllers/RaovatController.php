<?php

class Front_RaovatController extends Zend_Controller_Action
{
	private $session;
	private $account;
    public function init()
    {
        /* Initialize action controller here */
    	$this->_helper->layout->setLayout('front_layout');
    	$this->session = new Zend_Session_Namespace('session');
    	$this->session->visitor = Application_Model_DbTable_Visitor::getVisitor($this->session->logged);
    	$this->session->url = Core_Utils_Tools::getFullURL();
    	$this->account = $this->session->logged;
    }
    public function indexAction() {
    	try {
    		$page = $this->_request->getParam('p',1);
    		$totalRows = 0;
	        $this->view->list = Application_Model_DbTable_Raovat::findAll($page,$totalRows);
	        $this->view->page = $page;
	        $this->view->totalPage = ceil($totalRows/SEARCH_PAGE_SIZE);
	        //$this->view->url = "/?keyword=$keyword&city_id=$cityId";
    	} catch (Exception $e) {
    		$this->view->error_msg = Core_Exception::getErrorMessage($e);
    		$this->_forward('error','message','front');
    	}
    }
    
    public function viewAction() {
    	try {
    		$id = $this->_request->getParam('id','');
    		if(empty($id)) throw new Core_Exception('LINK_ERROR');
    		$raovat = Core_Utils_DB::query('SELECT * FROM `raovats` WHERE `id` = ?',2,array($id));
    		if($raovat==null) throw new Core_Exception('LINK_ERROR');
    		Core_Utils_DB::query('UPDATE `raovats` SET `views` = `views` + 1 WHERE `id` = ?',3,array($id));
    		$this->view->data = $raovat;
    		$this->view->facebook_comment = DOMAIN.'/raovat/view?id='.$id;
    		$this->view->title = $raovat['tieude'];
    		$this->view->description = Core_Utils_String::trim($raovat['noidung'],250);
    	} catch (Exception $e) {
    		$this->view->error_msg = Core_Exception::getErrorMessage($e);
    		$this->_forward('error','message','front');
    	}
    }
	
}

