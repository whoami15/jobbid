<?php

class Front_ActionController extends Zend_Controller_Action
{
	private $session;
	private $account;
    public function init()
    {
    	$this->_helper->layout->setLayout('front_layout');
        $this->session = new Zend_Session_Namespace('session');
        $this->session->visitor = Application_Model_DbTable_Visitor::getVisitor($this->session->logged);
        $this->account = $this->session->logged;
    }
	public function refeshJobAction()
    {
        try {
        	$this->_helper->layout->disableLayout();
        	$jobId = $this->_request->getParam('job_id','');
        	if(empty($jobId)) throw new Core_Exception('ERROR');
        	if($this->account == null) throw new Core_Exception('LOGIN_REQUIRED');
       	 	if(Application_Model_DbTable_Activity::getNumActivity(ACTION_REFESH_JOB) > LIMIT_REFESH_JOB) {
        		Application_Model_DbTable_Activity::insertLockedActivity(ACTION_REFESH_JOB,$jobId);
        		throw new Core_Exception('LIMIT_REFESH_JOB');
        	}
        	if(($job = Application_Model_DbTable_Job::findById($jobId)) == null) throw new Core_Exception('LINK_ERROR');
        	if(Core_Utils_Tools::isOwner($job) == false) throw new Core_Exception('LIMIT_PERMISSION');
        	Core_Utils_DB::update('jobs', array('time_update' => Core_Utils_Date::getCurrentDateSQL()), array('id' => $jobId));
        	Application_Model_DbTable_Activity::insertActivity(ACTION_REFESH_JOB,$jobId);
        	$this->_redirect(Core_Utils_Tools::genJobUrl($job));
        } catch (Exception $e) {
        	$this->view->error_msg = Core_Exception::getErrorMessage($e);
        	$this->_forward('error','message','front');
        }
    }
}

