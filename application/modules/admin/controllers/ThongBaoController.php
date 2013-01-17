<?php

class Admin_ThongBaoController extends Zend_Controller_Action
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
        // action body
    }

	public function errorAction()
    {
        $this->_helper->layout->setLayout('admin_layout');
    }
	public function successAction()
    {
        $this->_helper->layout->setLayout('admin_layout');
    }
}

