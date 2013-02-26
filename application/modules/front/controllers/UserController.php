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
    	$form = new Front_Form_Login();
        $this->view->form = $form;
    }
	

}

