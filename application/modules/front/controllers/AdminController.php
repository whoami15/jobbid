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
		$form = array(
			'id' => array(
				'tag' => 'input',
				'attrs' => array(
					'type' => 'hidden'
				)
			),
			'words' => array(
				'tag' => 'input',
				'attrs' => array(
					'type' => 'text',
					'placeholder' => 'Prohibition words...'
				)
				
			)
		);
		$this->view->title = 'Prohibition management';
		$array = array();
    	if($this->_request->isPost()) {
    		$form_data = $_POST;
    		if($form_data['button'] == 'Save') {
	    		if(!empty($form_data['words'])) {
	    			if(!empty($form_data['id'])) { //update
	    				Core_Utils_DB::update('prohibitions', array('words' => $form_data['words']), array('id' => $form_data['id']));
	    			} else {
		    			if(Core_Utils_DB::query('SELECT * FROM `prohibitions` WHERE `words` = ?',2,array($form_data['words'])) == null) {
		    				Application_Model_DbTable_Prohibition::addWords($form_data['words']);
		    			}
	    			}
	    		}
    		} else if($form_data['button'] == 'Search') {
    			$array['words'] = $form_data['words'];
    			$form['words']['attrs']['value'] = $form_data['words'];
    		}
    	}
    	$this->view->html = Core_Utils_Tools::form2HTML($form);
    	$this->view->list = Core_Utils_DB::search('prohibitions', $array,' order by id desc');
    }
    public function removeAction() {
    	$tableName = $this->_request->getParam('t','');
    	$id = $this->_request->getParam('id','');
    	$key = $this->_request->getParam('key','id');
    	if(empty($tableName) || empty($id)) die('ERROR');
    	Core_Utils_DB::delete($tableName, $id,$key);
    	die('OK');
    }
	public function contentAction() {
    	$tableName = $this->_request->getParam('t','');
    	$id = $this->_request->getParam('id','');
    	$key = $this->_request->getParam('key','id');
    	$content = $this->_request->getParam('content','content');
    	if(empty($tableName) || empty($id)) die;
    	$row = Core_Utils_DB::query("SELECT `$content` FROM `$tableName` WHERE `$key` = ?",2,array($id));
    	if($row!= false) echo $row[$content];
    	die;
    }
	public function tagAction() {
		$form = array(
			'id' => array(
				'tag' => 'input',
				'attrs' => array(
					'type' => 'text',
					'style' => 'display:none'
				)
			),
			'tag' => array(
				'tag' => 'input',
				'attrs' => array(
					'type' => 'text',
					'placeholder' => 'Tag...'
				)
				
			)
		);
		$tableName = 'tags';
		$this->view->title = 'Tag management';
		$array = array();
    	if($this->_request->isPost()) {
    		$form_data = $_POST;
    		if($form_data['button'] == 'Save') {
	    		if(!empty($form_data['tag'])) {
	    			if(!empty($form_data['id'])) { //update
	    				Core_Utils_DB::update($tableName, array('tag' => $form_data['tag']), array('id' => $form_data['id']));
	    			} else {
		    			if(Core_Utils_DB::query('SELECT * FROM `'.$tableName.'` WHERE `tag` = ?',2,array($form_data['tag'])) == null) {
		    				Application_Model_DbTable_Tag::insertTag($form_data['tag']);
		    			}
	    			}
	    		}
    		} else if($form_data['button'] == 'Search') {
    			$array['tag'] = "%{$form_data['tag']}%";
    			$form['tag']['attrs']['value'] = $form_data['tag'];
    		}
    	}
    	
    	$this->view->html = Core_Utils_Tools::form2HTML($form);
    	$this->view->list = Core_Utils_DB::search($tableName, $array,' order by id desc');
    }
	public function articleAction() {
		$form = array(
			'id' => array(
				'tag' => 'input',
				'attrs' => array(
					'type' => 'text',
					'style' => 'display:none'
				)
			),
			'title' => array(
				'tag' => 'input',
				'attrs' => array(
					'type' => 'text',
					'placeholder' => 'Title...'
				)
				
			)
		);
		$tableName = 'articles';
		$this->view->title = 'Article management';
		$array = array();
    	if($this->_request->isPost()) {
    		$form_data = $_POST;
    		if($form_data['button'] == 'Save') {
    			$data = array(
    				'title' => $form_data['title'],
    				'content' => $form_data['content']
    			);
    			if(!empty($form_data['id'])) { //update
    				Core_Utils_DB::update($tableName,$data , array('id' => $form_data['id']));
    			} else {
	    			Core_Utils_DB::insert($tableName, $data);
    			}
    		} else if($form_data['button'] == 'Search') {
    			$array['title'] = "%{$form_data['title']}%";
    			$form['title']['attrs']['value'] = $form_data['title'];
    		}
    	}
    	
    	$this->view->html = Core_Utils_Tools::form2HTML($form);
    	$this->view->list = Core_Utils_DB::search($tableName, $array,' order by id desc','`id`,`title`');
    }
}

