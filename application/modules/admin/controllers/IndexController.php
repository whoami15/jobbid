<?php

class Admin_IndexController extends Zend_Controller_Action
{

	private $session = null;
    public function init()
    {
        /* Initialize action controller here */
    	$this->session = new Zend_Session_Namespace('front');
	    if(isset($this->session->taikhoan)) {
	    	$this->view->taikhoan = $this->session->taikhoan;
	    }
    }

    public function indexAction()
    {
    	try {
    		//throw new Exception('ERROR');
	        $session = new Zend_Session_Namespace('front');
	        if(!isset($session->taikhoan)) {
	        	$this->_redirect(LOGIN_PAGE);
	        }
	        $this->_helper->layout->setLayout('admin_layout');
    	} catch (Exception $e) {
    		if(isset(zendcms_Controller_Helper_Const::$messages[$e->getMessage()])) 
    			$this->view->error_msg = zendcms_Controller_Helper_Const::$messages[$e->getMessage()];
    		else 
    			$this->view->error_msg = $e->getMessage();
	    	$this->_forward('error','thong-bao','admin');
    	}
    }


}

