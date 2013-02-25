<?php

class Front_RegistrationController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    	$this->_helper->layout->setLayout('front_layout');
    	//$this->_helper->layout->disableLayout();
    }

    public function facebookAction()
    {
    	$session = new Zend_Session_Namespace('session');
    	if($session->logged) {
			$this->_redirect('/index');
    		die;
    	}
    	if ($_REQUEST) {
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
	    		} else {
	    			if($taikhoan['status'] == 0) die('Tài khoản này đã bị khóa, vui lòng liên hệ admin@jobbid.vn');
	    			$dbTaikhoan->update(array('sodienthoai' => $registration['phone'],'name' => $registration['name'],'fb_id' => $fbId,'lastlogin' => $now), array('id = ?' => $taikhoan['id']));
	    			$taikhoan['sodienthoai'] = $registration['phone'];
	    			$taikhoan['name'] = $registration['name'];
	    			$taikhoan['fb_id'] = $fbId;
	    			$taikhoan['lastlogin'] = $now;
	    		}
    		}
    		$session->__set('logged', $taikhoan);
    		$this->_redirect('/index');
    		die;
    	}
    	
    }
	
	public function jobbidAction() {
    	$form = new Front_Form_Registration();
        $this->view->form = $form;		
        $errors = array();
		if ($this->getRequest()->isPost()) {
            $form_data = $this->getRequest()->getParams();
            if ($form->isValid($form_data)) {
            	$session = new Zend_Session_Namespace('session');
            	$dbTaikhoan = new Application_Model_DbTable_TaiKhoan();
            	$taikhoan = array(
    				'id' => null,
    				'username' => $form_data['username'],
            		'password' => $form_data['password'],
    				'sodienthoai' => $form_data['sodienthoai'],
    				'role' => 2,
    				'active' => 0,
    				'name' => $form_data['name'],
    				'status' => 1
    			);
    			$id = $dbTaikhoan->insert($taikhoan);
    			$taikhoan['id'] = $id;
    			$session->__set('logged', $taikhoan);
	    		$this->_redirect('/index');
	    		die;
            } else {
                $form->populate($form_data);
                $errors = $form->getMessages();
            }
        }
        $this->view->errors = $errors;
    }

}

