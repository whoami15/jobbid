<?php

class Front_JobController extends Zend_Controller_Action
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
    public function viewJobAction() {
    	try {
    		$jobId = $this->_request->getParam('id','');
    		if(empty($jobId)) throw new Core_Exception('LINK_ERROR');
    		Core_Utils_DB::update('jobs',array('view' => '`view` + 1'),array('id' => 1));
    		$job = Application_Model_DbTable_Job::findById($jobId);
    		if($job==null) throw new Core_Exception('LINK_ERROR');
    		$similarJobs = Application_Model_DbTable_Job::getSimilarJob($job);
    		$this->view->job = $job;
    		$this->view->similarJobs = $similarJobs;
    		$this->view->facebook_comment = DOMAIN.'/job/view-job?id='.$jobId;
    	} catch (Exception $e) {
    		$this->view->error_msg = Core_Exception::getErrorMessage($e);
    		$this->_forward('error','message','front');
    	}
    	
    	
    }
	public function testAction() {
		$this->_helper->layout->setLayout('test_layout');
	}
    public function createJobAction()
    {
        try {
        	$form = new Front_Form_PostJob();
        	$this->view->form = $form;
        	if ($this->getRequest()->isPost()) {
	        	if(!isset($this->account)) {
	        		throw new Core_Exception('LOGIN_REQUIRED'); 
	        	}
	        	if($this->account['active'] == 0) {
	        		throw new Core_Exception('ACTIVE_REQUIRED'); 
	        	}
        		if(Application_Model_DbTable_Lock::isLocked(ACTION_POST_JOB) == true) {
        			throw new Core_Exception('LOCK_ACTION');
        		}
        		$form_data = $this->getRequest()->getParams();
        		if ($form->isValid($form_data)) {
        			if(Application_Model_DbTable_Activity::getNumActivity(ACTION_POST_JOB) > LIMIT_POST_JOB) {
        				Application_Model_DbTable_Activity::insertLockedActivity(ACTION_POST_JOB,'LIMIT_POST_JOB');
        				throw new Core_Exception('LIMIT_POST_JOB');
        			}
        			if(Core_Utils_String::checkContent($form_data['job_description']) == false) {
        				Application_Model_DbTable_Activity::insertLockedActivity(ACTION_POST_JOB,'PROHIBITION_WORDS');
        				throw new Core_Exception('PROHIBITION_WORDS');
        			}
        			$modelCompany = new Application_Model_DbTable_Company();
        			$companyId = $modelCompany->save($form_data['company']);
        			$modelJobTitle = new Application_Model_DbTable_JobTitle();
        			$jobTitleId = $modelJobTitle->save($form_data['job_title']);
        			$modelJob = new Application_Model_DbTable_Job();
        			$now = Core_Utils_Date::getCurrentDateSQL();
        			$jobId = $modelJob->insert(array(
        					'id' => null,
        					'title' => $form_data['company'].' - '.$form_data['job_title'],
        					'account_id' => $this->account['id'],
        					'company_id' => $companyId,
        					'job_title_id' => $jobTitleId,
        					'job_description' => $form_data['job_description'],
        					'city_id' => $form_data['city_id'],
        					'email_to' => $form_data['email_to'],
        					'job_type' => $form_data['job_type'],
        					'view' => 0,
        					'time_create' => $now,
        					'time_update' => $now,
        					'sec_id' => '',
        					'status' => 1,
        					'active' => 0
        			));
        			Application_Model_DbTable_Activity::insertActivity(ACTION_POST_JOB,$jobId);
        			$dbSecureKey = new Application_Model_DbTable_SecureKey();
					$key = strtoupper(Core_Utils_Tools::genSecureKey());
					$dbSecureKey->insert(array(
							'id' => null,
							'account_id' => $this->account['id'],
							'key' => $key,
							'type' => KEY_VERIFY_JOB,
							'ref_id' => $jobId,
							'create_time' => $now,
							'status' => 1
					));
        			/*$email_content = Core_Utils_Email::render('verify_job.phtml', array(
						'name'=> $this->account['username'],
						'link_verify' => DOMAIN.'/job/verify?secure_key='.$key,
						'secure_key' => $key
					));*/
					$coreEmail = new Core_Email();
					//$coreEmail->send($form_data['email_to'], EMAIL_SUBJECT_VERIFY_ACCOUNT, $email_content);
        			$this->_redirect('/job/verify?email='.$form_data['email_to']);
        		} else {
        			$form->populate($form_data);
        		}
        	}
        } catch (Exception $e) {
        	$this->view->error_msg = Core_Exception::getErrorMessage($e);
        	$this->_forward('error','message','front');
        }	
    }
	public function indexAction()
    {
        // action body
    }
	public function redirectAction() {
		//$this->_redirect('/view')
		$this->_forward('view-job','job','front',array('id' => 8));
	}
 	public function verifyAction()
    {
        try {
	        $email = $this->_request->getParam('email','');
        	if(empty($email)) throw new Core_Exception('LINK_ERROR');
        	$this->view->email = $email;
        } catch (Exception $e) {
        	$this->view->error_msg = Core_Exception::getErrorMessage($e);
        	$this->_forward('error','message','front');
        }
        
    	
    }
}

