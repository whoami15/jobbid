<?php

class Front_AdminController extends Zend_Controller_Action
{
	private $session;
	private $account;
    public function init()
    {
        $this->session = new Zend_Session_Namespace('session');
        $this->account = $this->session->logged;
        if($this->account == null || $this->account['role'] != 1) die;
        $this->_helper->layout->setLayout('admin_layout');
    }
	public function lockAccountAction()
    {
        $uid = $this->_request->getParam('uid','');
        if(!empty($uid)) {
        	Core_Utils_DB::insert('locks', array(
        		'id' => null,
        		'account_id' => $uid,
        		'lock_action' => 999,
        		'create_time' => Core_Utils_Date::getCurrentDateSQL(),
        		'status' => 1
        	));
        	echo 'Locked user id : '.$uid;
        }
        die('OK');
    }
    public function indexAction() {
    	
    }
	public function prohibitionAction() {
    	if($this->_request->isPost()) {
    		$word = trim($this->_request->getParam('prohibitions_words',''));
    		if(!empty($word)) {
    			if(Core_Utils_DB::query('SELECT * FROM `prohibitions` WHERE `words` = ?',2,array($word)) == null) {
    				Application_Model_DbTable_Prohibition::addWords($word);
    			}
    		}
    	}
    	$this->view->list = Core_Utils_DB::query('SELECT * FROM `prohibitions` WHERE `status` = 1 ORDER BY `id` DESC LIMIT 0,20');
    }
}

