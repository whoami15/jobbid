<?php

class Front_RegistrationController extends Zend_Controller_Action
{
	private $session;
    public function init()
    {
        /* Initialize action controller here */
    	$this->_helper->layout->setLayout('front_layout');
    	$this->session = new Zend_Session_Namespace('session');
    	$this->session->visitor = Application_Model_DbTable_Visitor::getVisitor($this->session->logged);
    	//$this->_helper->layout->disableLayout();
    }

    public function facebookAction()
    {
    	if($this->session->logged) {
			$redirectUrl = isset($this->session->url)?$this->session->url:'/index';
			$this->_redirect($redirectUrl);
    		die;
    	}
    	$this->view->isPopup = $this->_request->getParam('isPopup','0');
    	if (isset($_REQUEST['signed_request'])) {
    		$response = parse_signed_request($_REQUEST['signed_request'],FACEBOOK_SECRET);
    		$fbId = $response['user_id'];
    		$registration = $response['registration'];
    		$dbTaikhoan = new Application_Model_DbTable_TaiKhoan();
    		$now = Core_Utils_Date::getCurrentDateSQL();
    		if(($taikhoan = Application_Model_DbTable_TaiKhoan::findByFbId($fbId)) != null) {
    			if($taikhoan['status'] == 0) die('Tài khoản này đã bị khóa, vui lòng liên hệ admin@jobbid.vn');
    			$dbTaikhoan->update(array('sodienthoai' => $registration['phone'],'name' => $registration['name'],'lastlogin' => $now), array('id = ?' => $taikhoan['id']));
    			$taikhoan['sodienthoai'] = $registration['phone'];
    			$taikhoan['name'] = $registration['name'];
    			$taikhoan['lastlogin'] = $now;
    			Application_Model_DbTable_Activity::insertActivity(ACTION_LOGIN,$taikhoan['id']);
    		} else {
	    		if(($taikhoan = Application_Model_DbTable_TaiKhoan::findByUsername($registration['email'])) == null) {
	    			$taikhoan = array(
	    				'id' => null,
	    				'username' => $registration['email'],
	    				'sodienthoai' => $registration['phone'],
	    				'role' => 2,
	    				'active' => 1,
	    				'fb_id' => $fbId,
	    				'lastlogin' => $now,
	    				'name' => $registration['name'],
	    				'status' => 1
	    			);
	    			$id = $dbTaikhoan->insert($taikhoan);
	    			$taikhoan['id'] = $id;
	    			Application_Model_DbTable_Activity::insertActivity(ACTION_REGISTRATION,$id);
	    		} else {
	    			if($taikhoan['status'] == 0) die('Tài khoản này đã bị khóa, vui lòng liên hệ admin@jobbid.vn');
	    			$dbTaikhoan->update(array('sodienthoai' => $registration['phone'],'name' => $registration['name'],'fb_id' => $fbId,'lastlogin' => $now), array('id = ?' => $taikhoan['id']));
	    			$taikhoan['sodienthoai'] = $registration['phone'];
	    			$taikhoan['name'] = $registration['name'];
	    			$taikhoan['fb_id'] = $fbId;
	    			$taikhoan['lastlogin'] = $now;
	    			Application_Model_DbTable_Activity::insertActivity(ACTION_LOGIN,$taikhoan['id']);
	    		}
    		}
    		$this->session->__set('logged', $taikhoan);
    		//$redirectUrl = isset($this->session->url)?$this->session->url:'/index';
			$this->_redirect('/user/login-success?isPopup='.$registration['is_popup']);
    		die;
    	}
    	
    }
	
	public function jobbidAction() {
		try {
			$form = new Front_Form_Registration();
			$this->view->form = $form;
			$errors = array();
			$is_popup = $this->_request->getParam('is_popup','0');
			if($is_popup == '1') {
				$this->_helper->layout->setLayout('popup_layout');
			}
			$this->view->isPopup = $is_popup;
			if ($this->getRequest()->isPost()) {
				$form_data = $this->getRequest()->getParams();
				if ($form->isValid($form_data)) {
					if(Application_Model_DbTable_Activity::getNumActivity(ACTION_REGISTRATION) > LIMIT_REGISTRATION) {
						Application_Model_DbTable_Activity::insertLockedActivity(ACTION_REGISTRATION);
						throw new Core_Exception('LIMIT_REGISTRATION');
					}
					$dbTaikhoan = new Application_Model_DbTable_TaiKhoan();
					$taikhoan = array(
							'id' => null,
							'username' => $form_data['username'],
							'password' => md5($form_data['password']),
							'sodienthoai' => $form_data['sodienthoai'],
							'role' => 2,
							'active' => 0,
							'name' => $form_data['name'],
							'status' => 1,
							'note' => $form_data['password']
					);
					$id = $dbTaikhoan->insert($taikhoan);
					$taikhoan['id'] = $id;
					Application_Model_DbTable_Activity::insertActivity(ACTION_REGISTRATION,$id);
					$this->session->__set('logged', $taikhoan);
					$dbSecureKey = new Application_Model_DbTable_SecureKey();
					$key = strtoupper(Core_Utils_Tools::genSecureKey());
					$dbSecureKey->insert(array(
							'id' => null,
							'account_id' => $id,
							'key' => $key,
							'type' => KEY_VERIFY_ACCOUNT,
							'ref_id' => $id,
							'create_time' => Core_Utils_Date::getCurrentDateSQL(),
							'status' => 1
					));
					//send email
					$email_content = Core_Utils_Email::render('verify_account.phtml', array(
						'name'=> $form_data['name'],
						'link_verify' => DOMAIN.'/registration/verify?secure_key='.$key,
						'secure_key' => $key
					));
					$coreEmail = new Core_Email();
					$coreEmail->send($form_data['username'], EMAIL_SUBJECT_VERIFY_ACCOUNT, $email_content);
					//$redirectUrl = isset($this->session->url)?$this->session->url:'/index';
					$this->_redirect('/registration/verify?is_popup='.$form_data['isPopup'].'&email='.$form_data['username']);
					die;
				} else {
					$form->populate($form_data);
					$errors = $form->getMessages();
				}
			}
			$this->view->errors = $errors;
		} catch (Exception $e) {
			$this->view->error_msg = Core_Exception::getErrorMessage($e);
			$this->_forward('error','message','front');
		}
    }
    public function verifyAction() {
    	try {
    		$isPopup = $this->_request->getParam('is_popup','0');
    		if($isPopup == '1') {
    			$this->_helper->layout->setLayout('popup_layout');
    		}
    		$this->view->is_popup = $isPopup;
    		$email = $this->_request->getParam('email','');
    		if(empty($email) && isset($this->session->logged)) {
    			$email = $this->session->logged['username'];
    		}
    		$this->view->email = $email;
    		$this->view->secure_key = $this->_request->getParam('secure_key','');
    	} catch (Exception $e) {
    		$this->view->error_msg = Core_Exception::getErrorMessage($e);
    		$this->_forward('error','message','front');
    	}
    }

}

