<?php

class Front_VerifyController extends Zend_Controller_Action
{
	private $session;
    public function init()
    {
        /* Initialize action controller here */
    	$this->_helper->layout->setLayout('front_layout');
    	$this->session = new Zend_Session_Namespace('session');
    	$this->session->visitor = Application_Model_DbTable_Visitor::getVisitor($this->session->logged);
    }
	
    public function registrationAction() {
    	try {
    		$this->_helper->layout->setLayout('test_layout');
    		$isPopup = $this->_request->getParam('is_popup','0');
    		$this->view->is_popup = $isPopup;
    	} catch (Exception $e) {
    		$this->view->error_msg = Core_Exception::getErrorMessage($e);
    		$this->_forward('error','message','front');
    	}
    }

}

