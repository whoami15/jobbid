<?php

class Front_TestController extends Zend_Controller_Action
{
    public function init()
    {
    	$this->_helper->layout->setLayout('test_layout');
    }
	public function indexAction() {
		$this->_helper->layout->disableLayout();
	}

}

