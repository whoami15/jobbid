<?php

class Front_TintucController extends Zend_Controller_Action
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
	        $this->view->list = Application_Model_DbTable_Article::findAll($page,$totalRows);
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
    		$article = Core_Utils_DB::query('SELECT * FROM `articles` WHERE `id` = ?',2,array($id));
    		if($article==null) throw new Core_Exception('LINK_ERROR');
    		Core_Utils_DB::query('UPDATE `articles` SET `viewcount` = `viewcount` + 1 WHERE `id` = ?',3,array($id));
    		$this->view->data = $article;
    		$this->view->facebook_comment = DOMAIN.'/tintuc/view?id='.$id;
    		$this->view->title = $article['title'];
    		$this->view->description = Core_Utils_String::trim($article['content'],250);
    	} catch (Exception $e) {
    		$this->view->error_msg = Core_Exception::getErrorMessage($e);
    		$this->_forward('error','message','front');
    	}
    }
	
}

