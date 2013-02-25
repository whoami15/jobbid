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
    }

    public function loginAction()
    {
    	
    	if($this->session->logged) {
			$this->_redirect('/index');
    		die;
    	}
    	$form = new Front_Form_Login();
        $this->view->form = $form;
    }
	

}

