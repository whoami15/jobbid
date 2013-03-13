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
    		$job = Application_Model_DbTable_Job::findById($jobId);
    		if($job==null) throw new Core_Exception('LINK_ERROR');
    		Core_Utils_DB::query('UPDATE `jobs` SET `view` = `view` + 1 WHERE `id` = ?',3,array($jobId));
    		$similarJobs = Application_Model_DbTable_Job::getSimilarJob($job);
    		$this->view->tags = Application_Model_DbTable_Tag::findTagByJob($jobId);
    		$this->view->job = $job;
    		$this->view->similarJobs = $similarJobs;
    		$this->view->facebook_comment = DOMAIN.'/job/view-job?id='.$jobId;
    		$this->view->title = $job['title'];
    		$this->view->description = Core_Utils_String::trim($job['job_description'],250);
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
        	$this->view->title = 'Bạn đang đăng tin tuyển dụng tại jobbid.vn';
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
        			//$modelJobTitle = new Application_Model_DbTable_JobTitle();
        			//$jobTitleId = $modelJobTitle->save($form_data['job_title']);
        			$modelJob = new Application_Model_DbTable_Job();
        			$now = Core_Utils_Date::getCurrentDateSQL();
        			$jobId = $modelJob->insert(array(
        					'id' => null,
        					'title' => $form_data['title'],
        					'account_id' => $this->account['id'],
        					'company_id' => $companyId,
        					'job_title_id' => null,
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
        			$email_content = Core_Utils_Email::render('verify_job.phtml', array(
						'name'=> $this->account['username'],
						'link_verify' => DOMAIN.'/job/verify?secure_key='.$key,
						'secure_key' => $key,
        				'job_title' => $form_data['job_title']
					));
					$coreEmail = new Core_Email();
					$coreEmail->send($form_data['email_to'], EMAIL_SUBJECT_VERIFY_JOB, $email_content);
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
		try {
			$cache = Core_Utils_Tools::loadCache();
			if(($array = $cache->load(CACHE_TRANSFER_ID)) == null) {
				$rows = Core_Utils_DB::query('SELECT * FROM `mapping` where type = 1');
				$array = array();
				foreach($rows as $row) {
					$array[$row['id1']] = $row['id2'];
				}
				$cache->save($array,CACHE_TRANSFER_ID);
			}
			$id = $this->_request->getParam('id',-1);
			if(!isset($array[$id])) throw new Core_Exception('LINK_ERROR');
			$this->_forward('view-job','job','front',array('id' => $array[$id]));
		} catch (Exception $e) {
			$this->view->error_msg = Core_Exception::getErrorMessage($e);
			$this->_forward('error','message','front');
		}
	}
 	public function verifyAction()
    {
        try {
        	$this->view->title = 'Xác nhận tin tuyển dụng tại jobbid.vn';
	        $email = $this->_request->getParam('email','');
        	if(empty($email) && isset($this->session->logged)) {
    			$email = $this->session->logged['username'];
    		}
        	if(empty($email)) throw new Core_Exception('LINK_ERROR');
        	$this->view->email = $email;
        	$this->view->secure_key = $this->_request->getParam('secure_key','');
        } catch (Exception $e) {
        	$this->view->error_msg = Core_Exception::getErrorMessage($e);
        	$this->_forward('error','message','front');
        }
    }
	public function myJobsAction()
    {
        try {
        	$this->_helper->layout->setLayout('popup_layout');
        	if($this->account == NULL) {
        		throw new Core_Exception('LOGIN_REQUIRED');
        	}
        	$this->view->my_jobs = Application_Model_DbTable_Job::findJobsByUser($this->account['id']);
        } catch (Exception $e) {
        	$this->view->error_msg = Core_Exception::getErrorMessage($e);
        	$this->_forward('error','message','front');
        }
    }
	public function editAction()
    {
        try {
        	$jobId = $this->_request->getParam('job_id','');
        	if(empty($jobId)) throw new Core_Exception('ERROR');
        	if($this->account == null) throw new Core_Exception('LOGIN_REQUIRED');
        	if(($job = Application_Model_DbTable_Job::findById($jobId)) == null) throw new Core_Exception('LINK_ERROR');
        	if(Core_Utils_Tools::isOwner($job) == false) throw new Core_Exception('LIMIT_PERMISSION');
        	
        	$form = new Front_Form_PostJob();
        	$this->view->form = $form;
        	$this->view->flag = $this->_request->getParam('f','');
        	$this->view->job = $job;
        	$this->view->title = 'Chỉnh sửa tin tuyển dụng tại jobbid.vn';
        	$form->populate($job);
        	if ($this->getRequest()->isPost()) {
	        	if($this->account['active'] == 0) {
	        		throw new Core_Exception('ACTIVE_REQUIRED'); 
	        	}
        		if(Application_Model_DbTable_Lock::isLocked(ACTION_POST_JOB) == true) {
        			throw new Core_Exception('LOCK_ACTION');
        		}
        		$form_data = $this->getRequest()->getParams();
        		if ($form->isValid($form_data)) {
        			if(Application_Model_DbTable_Activity::getNumActivity(ACTION_EDIT_JOB) > LIMIT_EDIT_JOB) {
        				Application_Model_DbTable_Activity::insertLockedActivity(ACTION_EDIT_JOB,$jobId);
        				throw new Core_Exception('LIMIT_EDIT_JOB');
        			}
        			if(Core_Utils_String::checkContent($form_data['job_description']) == false) {
        				Application_Model_DbTable_Activity::insertLockedActivity(ACTION_POST_JOB,'PROHIBITION_WORDS');
        				throw new Core_Exception('PROHIBITION_WORDS');
        			}
        			$modelCompany = new Application_Model_DbTable_Company();
        			$companyId = $modelCompany->save($form_data['company']);
        			//$modelJobTitle = new Application_Model_DbTable_JobTitle();
        			//$jobTitleId = $modelJobTitle->save($form_data['job_title']);
        			$modelJob = new Application_Model_DbTable_Job();
        			$now = Core_Utils_Date::getCurrentDateSQL();
        			$modelJob->update(array(
        					'title' => $form_data['title'],
        					'account_id' => $this->account['id'],
        					'company_id' => $companyId,
        					'job_title_id' => null,
        					'job_description' => $form_data['job_description'],
        					'city_id' => $form_data['city_id'],
        					'email_to' => $form_data['email_to'],
        					'job_type' => $form_data['job_type'],
        					'time_update' => $now
        			),array('id = ?' => $jobId));
        			Application_Model_DbTable_Activity::insertActivity(ACTION_EDIT_JOB,$jobId);
        			$this->_redirect('/job/edit?job_id='.$jobId.'&f=1');
        		} else {
        			$form->populate($form_data);
        		}
        	}
        } catch (Exception $e) {
        	$this->view->error_msg = Core_Exception::getErrorMessage($e);
        	$this->_forward('error','message','front');
        }	
    }
}

