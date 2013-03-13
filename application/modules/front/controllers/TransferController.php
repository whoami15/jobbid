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
		//$this->view->list = Application_Model_DbTable_Transfer::findAllDuan();
		//$this->view->list = Core_Utils_DB::query('SELECT `id`,`title` FROM `_articles` ORDER BY `id` LIMIT 0,100');
		$this->view->list = Core_Utils_DB::query('SELECT `id`,`tieude` FROM `_raovats`');
	}
	public function readAction() {
		$id = $this->_request->getParam('id','');
		if(empty($id)) die('ERROR');
		//$this->view->data = Application_Model_DbTable_Transfer::readDuan($id);
		//$this->view->data = Core_Utils_DB::query('SELECT * FROM `_articles` WHERE `id` = ?',2,array($id));
		$this->view->data = Core_Utils_DB::query('SELECT * FROM `_raovats` WHERE `id` = ?',2,array($id));
	}
    
}

