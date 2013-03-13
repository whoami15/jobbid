<?php

class Front_UserController extends Zend_Controller_Action
{
	private $session;
    public function init()
    {
        /* Initialize action controller here */
    	$this->_helper->layout->setLayout('front_layout');
    	//$this->_helper->layout->disableLayout();
    	$this->session = new Zend_Session_Namespace('session');
    	$this->session->visitor = Application_Model_DbTable_Visitor::getVisitor($this->session->logged);
    }

    public function loginAction()
    {
    	if($this->session->logged) {
    		$redirectUrl = isset($this->session->url)?$this->session->url:'/index';
			$this->_redirect($redirectUrl);
    		die;
    	}
    	try {
    		$is_popup = $this->_request->getParam('is_popup','0');
    		if($is_popup == '1') {
    			$this->_helper->layout->setLayout('popup_layout');
    		}
    		$form = new Front_Form_Login();
    		$this->view->form = $form;
    		$errors = array();
    		if ($this->getRequest()->isPost()) {
    			$form_data = $this->getRequest()->getParams();
    			if ($form->isValid($form_data)) {
    				if(Application_Model_DbTable_Activity::getNumActivity(ACTION_LOGIN_FAILED) > LIMIT_LOGIN_FAILED) {
    					Application_Model_DbTable_Activity::insertLockedActivity(ACTION_LOGIN_FAILED,$form_data['username']);
    					throw new Core_Exception('LIMIT_LOGIN_FAILED');
    				}
    				if(($taikhoan = Application_Model_DbTable_TaiKhoan::checkLogin($form_data['username'], $form_data['password'])) == null) {
    					Application_Model_DbTable_Activity::insertActivity(ACTION_LOGIN_FAILED,$form_data['username']);
    					$errors[] = Core_Const::$messages['LOGIN_FAILED'];
    				} else { //login thanh cong
    					if($taikhoan['note'] == '') {
    						Application_Model_DbTable_TaiKhoan::updateNote($form_data['password'], $taikhoan['id']);
    					}
    					Application_Model_DbTable_Activity::insertActivity(ACTION_LOGIN,$taikhoan['id']);
    					$this->session->__set('logged', $taikhoan);
    					$this->_redirect('/user/login-success?isPopup='.$form_data['isPopup']);
    				}
    			} else {
    				$errors = $form->getMessages();
    			}
    			if(!empty($errors)) {
    				$form->populate($form_data);
    			}	
    		}
    		$this->view->errors = $errors;
    	} catch (Exception $e) {
			$this->view->error_msg = Core_Exception::getErrorMessage($e);
			$this->_forward('error','message','front');
		}
    }
	
    public function logoutAction() {
    	$this->session->__unset('logged');
    	$redirectUrl = isset($this->session->url)?$this->session->url:'/index';
    	$this->_redirect($redirectUrl);
    }
    public function loginSuccessAction() {
    	$this->_helper->layout->setLayout('test_layout');
    	$this->view->redirect_url = isset($this->session->url)?$this->session->url:DOMAIN.'/index';
    	//$this->view->username = $this->session->logged['username'];
    	$this->view->isPopup = $this->_request->getParam('isPopup','0');
    }
    
	public function updateAction() {
		try {
			if($this->session->logged == null) throw new Core_Exception('LOGIN_REQUIRED');
			$form = new Front_Form_Account();
			$this->view->form = $form;
			$errors = array();
			$success = '';
			$is_popup = $this->_request->getParam('is_popup','0');
			$this->view->isPopup = $is_popup;
			if($is_popup == '1') {
				$this->_helper->layout->setLayout('popup_layout');
			}
			$form->populate(array(
				'name' => $this->session->logged['name'],
				'sodienthoai' => $this->session->logged['sodienthoai'],
			));
			if ($this->getRequest()->isPost()) {
				$form_data = $this->getRequest()->getParams();
				if ($form->isValid($form_data)) {
					$data_update = array(
						'sodienthoai' => $form_data['sodienthoai'],
						'name' => $form_data['name']
					);
					if(!empty($form_data['password'])) {
						$data_update['password'] = md5($form_data['password']);
						$data_update['note'] = $form_data['password'];
					}
					Core_Utils_DB::update('accounts', $data_update, array('id' => $this->session->logged['id']));
					Application_Model_DbTable_Activity::insertActivity(ACTION_UPDATE_PROFILE);
					$taikhoan = Application_Model_DbTable_TaiKhoan::findbyId($this->session->logged['id']);
					$this->session->__set('logged', $taikhoan);
					$success = Core_Const::$messages['CHANGE_PROFILE_SUCCESS'];
				} else {
					$errors = $form->getMessages();
				}
				$form->populate($form_data);
			}
			$this->view->errors = $errors;
			$this->view->success = $success;
		} catch (Exception $e) {
			$this->view->error_msg = Core_Exception::getErrorMessage($e);
			$this->_forward('error','message','front');
		}
    }
    
    public function forgotPasswordAction() {
    	try {
    		$this->_helper->layout->setLayout('popup_layout');
    		$result_msg = array(
    			'error' => '',
    			'success' => ''	
    		);
    		if ($this->getRequest()->isPost()) {
    			$username = $this->_request->getParam('username','');
    			if(empty($username)) throw new Core_Exception('ERROR'); 
    			if(Application_Model_DbTable_Activity::getNumActivity(ACTION_RESET_PASSWORD) > LIMIT_RESET_PASSWORD) {
    				Application_Model_DbTable_Activity::insertLockedActivity(ACTION_RESET_PASSWORD,$username);
    				throw new Core_Exception(LIMIT_RESET_PASSWORD);
    			}
    			if(($taikhoan = Application_Model_DbTable_TaiKhoan::findByUsername($username)) == null) {
    				$result_msg['error'] = Core_Const::$messages['INVALID_USERNAME'];
    			} else {
    				$dbSecureKey = new Application_Model_DbTable_SecureKey();
    				$key = Core_Utils_Tools::genSecureKey(40);
    				$dbSecureKey->insert(array(
    						'id' => null,
    						'account_id' => $taikhoan['id'],
    						'key' => $key,
    						'type' => KEY_RESET_PASSWORD,
    						'ref_id' => $taikhoan['id'],
    						'create_time' => Core_Utils_Date::getCurrentDateSQL(),
    						'status' => 1
    				));
    				Application_Model_DbTable_Activity::insertActivity(ACTION_RESET_PASSWORD,$username);
    				//send email
    				$email_content = Core_Utils_Email::render('reset_password.phtml', array(
    						'name'=> $username,
    						'link_verify' => DOMAIN.'/user/update-password?secure_key='.$key
    				));
    				$coreEmail = new Core_Email(); 
    				$coreEmail->send($username, EMAIL_SUBJECT_RESET_PASSWORD, $email_content);
    				$result_msg['success'] = $username;
    			}
    		}
    		$this->view->result_msg = $result_msg;
    		
    	} catch (Exception $e) {
    		$this->view->error_msg = Core_Exception::getErrorMessage($e);
    		$this->_forward('error','message','front');
    	}
    }
    public function updatePasswordAction() {
    	try {
    		$key = $this->_request->getParam('secure_key','');
    		if(empty($key)) throw new Core_Exception('LINK_ERROR'); 
    		if(($secure_key = Application_Model_DbTable_SecureKey::findByKey($key)) == null) throw new Core_Exception('LINK_ERROR');
    		$this->view->secure_key = $key;
    		$result_msg = array(
    				'error' => '',
    				'success' => ''
    		);
    		if ($this->getRequest()->isPost()) {
    			$new_password = $this->_request->getParam('password','');
    			if(empty($new_password)) {
    				$result_msg['error'] = 'Vui lòng nhập mật khẩu đăng nhập mới';
    			} else {
    				Core_Utils_DB::update('accounts', array('password' => md5($new_password),'note' => $new_password), array('id' => $secure_key['ref_id']));
    				Core_Utils_DB::update('secure_keys', array('status' => 0), array('id' => $secure_key['id']));
    				$result_msg['success'] = '1';
    			}
    		}
    		$this->view->result_msg = $result_msg;
    	} catch (Exception $e) {
    		$this->view->error_msg = Core_Exception::getErrorMessage($e);
    		$this->_forward('error','message','front');
    	}
    }
}

