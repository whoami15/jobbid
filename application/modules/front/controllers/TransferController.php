<?php

class Front_TransferController extends Zend_Controller_Action
{
	private $session;
    public function init()
    {
        /* Initialize action controller here */
    	//$this->_helper->layout->setLayout('front_layout');
    	$this->_helper->layout->disableLayout();
    }
	public function listAction() {
		$this->view->list = Application_Model_DbTable_Transfer::findAllDuan();
	}
	public function readAction() {
		$id = $this->_request->getParam('id','');
		if(empty($id)) die('ERROR');
		$this->view->data = Application_Model_DbTable_Transfer::readDuan($id);
	}
    
}

