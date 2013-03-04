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
    		$form = new Front_Form_Login();
    		$this->view->form = $form;
    		$errors = array();
    		if ($this->getRequest()->isPost()) {
    			$form_data = $this->getRequest()->getParams();
    			$this->_redirect('/user/login-success?isPopup='.$form_data['isPopup']);die;
    			if ($form->isValid($form_data)) {
    				if(Application_Model_DbTable_Activity::getNumActivity(ACTION_LOGIN_FAILED) > LIMIT_LOGIN_FAILED) {
    					Application_Model_DbTable_Activity::insertLockedActivity(ACTION_LOGIN_FAILED,$form_data['username']);
    					throw new Core_Exception('LIMIT_LOGIN_FAILED');
    				}
    				if(($taikhoan = Application_Model_DbTable_TaiKhoan::checkLogin($form_data['username'], $form_data['password'])) == null) {
    					Application_Model_DbTable_Activity::insertActivity(ACTION_LOGIN_FAILED,$form_data['username']);
    					$errors[] = Core_Const::$messages['LOGIN_FAILED'];
    				} else { //login thanh cong
    					Application_Model_DbTable_Activity::insertActivity(ACTION_LOGIN,$taikhoan['id']);
    					$this->session->__set('logged', $taikhoan);
    					$this->_redirect('/user/login-success?isPopup='.$form_data['isPopup']);
    				}
    				
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
}

