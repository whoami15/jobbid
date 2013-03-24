<?php

class Front_CompanyController extends Zend_Controller_Action
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
	        $this->view->list = Application_Model_DbTable_Company::findAll($page,$totalRows);
	        $this->view->page = $page;
	        $this->view->totalPage = ceil($totalRows/SEARCH_PAGE_SIZE);
	        //$this->view->url = "/?keyword=$keyword&city_id=$cityId";
    	} catch (Exception $e) {
    		$this->view->error_msg = Core_Exception::getErrorMessage($e);
    		$this->_forward('error','message','front');
    	}
    }
	public function viewAction()
    {
    	try {
    		$companyId = $this->_request->getParam('id','');
	        $company = Application_Model_DbTable_Company::findById($companyId);
	        if($company == null) throw new Core_Exception('LINK_ERROR');
	        $totalRows = 0;
	        $page = $this->_request->getParam('p',1);
	        $this->view->jobs = Application_Model_DbTable_Job::findAll(array(
	        	'company_id' => $companyId
	        ),$page,$totalRows);
	       	$this->view->title = 'Việc làm tại "'.$company['company'].'"';
	       	$this->view->description = $company['description']==null?'Chưa cập nhật thông tin công ty.':$company['description'];
	       	$this->view->page = $page;
        	$this->view->totalPage = ceil($totalRows/SEARCH_PAGE_SIZE);
        	$this->view->url = Core_Utils_Tools::genCompanyUrl($companyId, $company['company']);
	        //$this->renderScript('/tag/index.phtml');
    	} catch (Exception $e) {
    		$this->view->error_msg = Core_Exception::getErrorMessage($e);
    		$this->_forward('error','message','front');
    	}
       
    }
}

