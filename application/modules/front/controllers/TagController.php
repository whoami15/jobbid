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
	        $totalRows = 0;
	        $page = $this->_request->getParam('p',1);
	        $this->view->jobs = Application_Model_DbTable_Job::findAll(array(
	        	'company_id' => $companyId
	        ),$page,$totalRows);
	       	$this->view->title = 'Việc làm tại "'.$company['company'].'"';
	       	$this->view->page = $page;
        	$this->view->totalPage = ceil($totalRows/SEARCH_PAGE_SIZE);
        	$this->view->url = Core_Utils_Tools::genCompanyUrl($companyId, $company['company']);
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
	        $page = $this->_request->getParam('p',1);
	        $totalRows = 0;
	        $this->view->jobs = Application_Model_DbTable_Job::findAll(array(
	        	'city_id' => $id
	        ),$page,$totalRows);
	        $this->view->title = 'Việc làm tại "'.$city['name_city'].'"';
	        $this->view->page = $page;
	        $this->view->url = Core_Utils_Tools::genCityUrl($id, $city['name_city']);
        	$this->view->totalPage = ceil($totalRows/SEARCH_PAGE_SIZE);
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
	        $page = $this->_request->getParam('p',1);
	        $totalRows = 0;
	        $this->view->jobs = Application_Model_DbTable_Job::findAll(array(
	        	'position_id' => $id
	        ),$page,$totalRows);
	        $this->view->title = 'Việc làm liên quan đến "'.$jobTitle['job_title'].'"';
	        $this->view->page = $page;
	        $this->view->url = Core_Utils_Tools::genPositionUrl($id, $jobTitle['job_title']);
        	$this->view->totalPage = ceil($totalRows/SEARCH_PAGE_SIZE);
	        $this->renderScript('/tag/index.phtml');
    	} catch (Exception $e) {
    		$this->view->error_msg = Core_Exception::getErrorMessage($e);
    		$this->_forward('error','message','front');
    	}
    }
    public function tagCloudAction() {
    	try {
    		$this->view->title = 'Tags cloud - '.SITE_TITLE;
		    $this->view->cloud = Application_Model_DbTable_Tag::getTagsCloud();
    	} catch (Exception $e) {
    		$this->view->error_msg = Core_Exception::getErrorMessage($e);
    		$this->_forward('error','message','front');
    	}
    }
    public function indexAction() {
    	try {
    		$key = $this->_request->getParam('key');
    		if(in_array($key, array('tag-cloud','company','position','city'))) {
    			$this->_forward($key);
    		} else {
    			//print_r($this->_request->getParams());die;
    			if(($tag = Application_Model_DbTable_Tag::findByKey($key)) == null) {
    				throw new Core_Exception('LINK_ERROR');
    			}
    			$rows = Application_Model_DbTable_JobTag::findJobByTag($tag['id']);
    			$ids = array();
    			foreach ($rows as $row) {
    				$ids[] = $row['job_id'];
    			}
    			$page = $this->_request->getParam('p',1);
		        $totalRows = 0;
		        if(empty($ids)) {
		        	$this->view->jobs = array();
		        } else {
		        	 $this->view->jobs = Application_Model_DbTable_Job::findAll(array(
			        	'ids' => $ids
			        ),$page,$totalRows);
		        }
		        $this->view->title = 'Hiển thị kết quả tìm kiếm cho tag "'.$tag['tag'].'"';
		        $this->view->page = $page;
		        $this->view->url = Core_Utils_Tools::genTagUrl($tag['key']).'?';
	        	$this->view->totalPage = ceil($totalRows/SEARCH_PAGE_SIZE);
		        $this->renderScript('/tag/index.phtml');
    		}
    	} catch (Exception $e) {
    		$this->view->error_msg = Core_Exception::getErrorMessage($e);
    		$this->_forward('error','message','front');
    	}
    }
}

