<?php

class Front_TagController extends Zend_Controller_Action
{
	private $session;
    public function init()
    {
        /* Initialize action controller here */
    	$this->_helper->layout->setLayout('front_layout');
    	$this->session = new Zend_Session_Namespace('session');
    	$this->session->visitor = Application_Model_DbTable_Visitor::getVisitor($this->session->logged);
    	$this->session->url = Core_Utils_Tools::getFullURL();
    }

    public function companyAction()
    {
    	try {
    		$companyId = $this->_request->getParam('id','');
	        $company = Application_Model_DbTable_Company::findById($companyId);
	        if($company == null) throw new Core_Exception('LINK_ERROR');
	        $this->view->jobs = Application_Model_DbTable_Job::findAll(array(
	        	'company_id' => $companyId
	        ),1);
	       	$this->view->title = 'Việc làm tại "'.$company['company'].'"';
	        $this->renderScript('/tag/index.phtml');
    	} catch (Exception $e) {
    		$this->view->error_msg = Core_Exception::getErrorMessage($e);
    		$this->_forward('error','message','front');
    	}
       
    }
	public function cityAction()
    {
    	try {
    		$id = $this->_request->getParam('id','');
    		$city = Application_Model_DbTable_City::findById($id);
	        if($city == null) throw new Core_Exception('LINK_ERROR');
	        $this->view->jobs = Application_Model_DbTable_Job::findAll(array(
	        	'city_id' => $id
	        ),1);
	        $this->view->title = 'Việc làm tại "'.$city['name_city'].'"';
	        $this->renderScript('/tag/index.phtml');
    	} catch (Exception $e) {
    		$this->view->error_msg = Core_Exception::getErrorMessage($e);
    		$this->_forward('error','message','front');
    	}
    }
	public function positionAction()
    {
    	try {
    		$id = $this->_request->getParam('id','');
    		$jobTitle = Application_Model_DbTable_JobTitle::findById($id);
	        if($jobTitle == null) throw new Core_Exception('LINK_ERROR');
	        $this->view->jobs = Application_Model_DbTable_Job::findAll(array(
	        	'position_id' => $id
	        ),1);
	        $this->view->title = 'Việc làm liên quan đến "'.$jobTitle['job_title'].'"';
	        $this->renderScript('/tag/index.phtml');
    	} catch (Exception $e) {
    		$this->view->error_msg = Core_Exception::getErrorMessage($e);
    		$this->_forward('error','message','front');
    	}
    }
}

