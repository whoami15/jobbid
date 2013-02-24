<?php

class Front_JobController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    	$this->_helper->layout->setLayout('front_layout');
    }
    public function viewJobAction() {
    	try {
    		$jobId = $this->_request->getParam('id','');
    		if(empty($jobId)) throw new Core_Exception('LINK_ERROR');
    		$job = Application_Model_DbTable_Job::findById($jobId);
    		if($job==null) throw new Core_Exception('LINK_ERROR');
    		$similarJobs = Application_Model_DbTable_Job::getSimilarJob($job);
    		$this->view->job = $job;
    		$this->view->similarJobs = $similarJobs;
    		
    	} catch (Exception $e) {
    		$this->view->error_msg = Core_Exception::getErrorMessage($e);
    		$this->_forward('error','message','front');
    	}
    	
    	
    }
	public function testAction() {
		
	}
    public function createJobAction()
    {
        // action body
        $form = new Front_Form_PostJob();
        $this->view->form = $form;
        if ($this->getRequest()->isPost()) {
            $form_data = $this->getRequest()->getParams();
            if ($form->isValid($form_data)) {
            	$modelCompany = new Application_Model_DbTable_Company();
            	$companyId = $modelCompany->save($form_data['company']);
            	$modelJobTitle = new Application_Model_DbTable_JobTitle();
            	$jobTitleId = $modelJobTitle->save($form_data['job_title']);
            	$modelJob = new Application_Model_DbTable_Job();
            	$now = Core_Utils_Date::getCurrentDateSQL();
            	$secId = Core_Utils_Tools::genKey();
            	$jobId = $modelJob->insert(array(
            		'id' => null,
            		'title' => $form_data['company'].' - '.$form_data['job_title'],
            		'account_id' => 1,
            		'company_id' => $companyId,
            		'job_title_id' => $jobTitleId,
            		'job_description' => $form_data['job_description'],
            		'city_id' => $form_data['city_id'],
            		'email_to' => $form_data['email_to'],
            		'job_type' => $form_data['job_type'],
            		'view' => 0,
            		'time_create' => $now,
            		'time_update' => $now,
            		'sec_id' => $secId
            	));
            	$this->_redirect('/message/success?type=post-job&email='.$form_data['email_to']);
            } else {
            	$form->populate($form_data);
            }
        }
    }
	public function indexAction()
    {
        // action body
    }

}

