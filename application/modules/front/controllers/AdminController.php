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
        $action = $this->_request->getParam('a',999);
        if(!empty($uid)) {
        	Core_Utils_DB::query('INSERT DELAYED INTO `locks` (`account_id`,`lock_action`,`create_time`,`status`) VALUES (?,?,NOW(),1)',3,array($uid,$action));
        	echo 'Locked user id : '.$uid.' with action '.$action.'<br/>';
        }
        die('OK');
    }
    public function indexAction() {
    	
    	
    }
	public function prohibitionAction() {
		try {
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
		    		$this->_redirect('/admin/prohibition');die;
	    		} else if($form_data['button'] == 'Search') {
	    			$array['words'] = $form_data['words'];
	    			$form['words']['attrs']['value'] = $form_data['words'];
	    		}
	    	}
	    	$this->view->html = Core_Utils_Tools::form2HTML($form);
	    	$this->view->list = Core_Utils_DB::search('prohibitions', $array,' order by id desc');
		} catch (Exception $e) {
			$this->_forward('error','admin','front',array('msg' => $e->getMessage(),'trace' => $e->getTraceAsString()));
		}
    }
    public function removeAction() {
    	$tableName = $this->_request->getParam('t','');
    	$id = $this->_request->getParam('id','');
    	$key = $this->_request->getParam('key','id');
    	$flag = $this->_request->getParam('f','1');
    	if(empty($tableName) || empty($id)) die('ERROR');
    	if($flag == 1) { //delete
    		Core_Utils_DB::delete($tableName, $id,$key);
    	} else { //update status
    		Core_Utils_DB::update($tableName, array('status' => 0),array($key => $id));
    	}
    	die('OK');
    }
	public function doGrabAction() {
    	$grab = $this->_request->getParams();
		try {
			Core_Utils_Log::log('Grab link '.$grab['url'].'...');
    		$grabber = new $grab['class_name']($grab);
    		$grabber->doGrab();
    	} catch (Exception $e) {
    		Core_Utils_Log::error($e->getMessage(),Zend_Log::EMERG);
    	}
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
		try {
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
	    		$form_data = $this->_request->getParams();
	    		//print_r($form_data);die;
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
		    		$this->_redirect('/admin/tag');die;
	    		} else if($form_data['button'] == 'Search') {
	    			$array['tag'] = "%{$form_data['tag']}%";
	    			$form['tag']['attrs']['value'] = $form_data['tag'];
	    		}
	    	}
	    	
	    	$this->view->html = Core_Utils_Tools::form2HTML($form);
	    	$this->view->list = Core_Utils_DB::search($tableName, $array,' order by id desc');
		} catch (Exception $e) {
			$this->_forward('error','admin','front',array('msg' => $e->getMessage(),'trace' => $e->getTraceAsString()));
		}
		
    }
	public function articleAction() {
		try {
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
	    				'content' => $form_data['content'],
	    				'datemodified' => Core_Utils_Date::getCurrentDateSQL()
	    			);
	    			if(!empty($form_data['id'])) { //update
	    				Core_Utils_DB::update($tableName,$data , array('id' => $form_data['id']));
	    			} else {
		    			Core_Utils_DB::insert($tableName, $data);
	    			}
	    			$this->_redirect('/admin/article');die;
	    		} else if($form_data['button'] == 'Search') {
	    			$array['title'] = "%{$form_data['title']}%";
	    			$form['title']['attrs']['value'] = $form_data['title'];
	    		}
	    	}
	    	
	    	$this->view->html = Core_Utils_Tools::form2HTML($form);
	    	$this->view->list = Core_Utils_DB::search($tableName, $array,' order by id desc','`id`,`title`');
		} catch (Exception $e) {
			$this->_forward('error','admin','front',array('msg' => $e->getMessage(),'trace' => $e->getTraceAsString()));
		}
    }
    public function testAction() {
    	die;
    }
    public function errorAction() {
    	$msg = $this->_request->getParam('msg','');
    	$trace = $this->_request->getParam('trace','');
    	die('ERROR : '.$msg.'<pre>'.$trace.'</pre>');
    }
	public function mailistAction() {
		try {
			$form = array(
				'id' => array(
					'tag' => 'input',
					'attrs' => array(
						'type' => 'text',
						'style' => 'display:none'
					)
				),
				/* 'email' => array(
					'tag' => 'textarea',
					'attrs' => array(
						'type' => 'textarea',
						'placeholder' => 'Email...'
					)
					
				) */
			);
			$tableName = 'emails';
			$this->view->title = 'Mailist management';
			$array = array('status' => 1);
	    	if($this->_request->isPost()) {
	    		$form_data = $this->_request->getParams();
	    		//print_r($form_data);die;
	    		if($form_data['button'] == 'Save') {
		    		if(!empty($form_data['email'])) {
		    			if(!empty($form_data['id'])) { //update
		    				Core_Utils_DB::update($tableName, array('email' => $form_data['email']), array('id' => $form_data['id']));
		    			} else {
		    				$emails = explode(',', $form_data['email']);
		    				foreach ($emails as $item) {
		    					Core_Utils_Tools::addEmail($item);
		    				}
		    			}
		    		}
		    		$this->_redirect('/admin/mailist');die;
	    		} else if($form_data['button'] == 'Search') {
	    			$array['email'] = "%{$form_data['email']}%";
	    			$form['email']['attrs']['value'] = $form_data['email'];
	    		}
	    	}
	    	
	    	$this->view->html = Core_Utils_Tools::form2HTML($form);
	    	$this->view->list = Core_Utils_DB::search($tableName, $array,' order by id desc limit 0,30');
		} catch (Exception $e) {
			$this->_forward('error','admin','front',array('msg' => $e->getMessage(),'trace' => $e->getTraceAsString()));
		}
    }
    
	public function grabberAction() {
		try {
			$form = array(
				'id' => array(
					'tag' => 'input',
					'attrs' => array(
						'type' => 'text',
						'style' => 'display:none'
					)
				),
				'url' => array(
					'tag' => 'input',
					'attrs' => array(
						'type' => 'text',
						'placeholder' => 'Url...'
					)
					
				)
			);
			$tableName = 'links';
			$this->view->title = 'Grabber management';
			$array = array('status' => 1);
	    	if($this->_request->isPost()) {
	    		$form_data = $this->_request->getParams();
	    		//print_r($form_data);die;
	    		if($form_data['button'] == 'Save') {
		    		if(!empty($form_data['url'])) {
		    			if(($class_name = Core_Utils_Tools::getGrabber($form_data['url'])) == null) throw new Core_Exception('HOST INVALID');
		    			if(!empty($form_data['id'])) { //update
		    				Core_Utils_DB::update($tableName, array('url' => $form_data['url'],'class_name' => $class_name), array('id' => $form_data['id']));
		    			} else {
		    				Core_Utils_DB::query('INSERT DELAYED INTO `links`(`url`,`class_name`,`create_time`) VALUES (?,?,NOW())',3,array($form_data['url'],$class_name));
		    			}
		    		}
		    		$this->_redirect('/admin/grabber');die;
	    		} else if($form_data['button'] == 'Search') {
	    			$array['url'] = "%{$form_data['url']}%";
	    			$form['url']['attrs']['value'] = $form_data['url'];
	    		}
	    	}
	    	
	    	$this->view->html = Core_Utils_Tools::form2HTML($form);
	    	$this->view->list = Core_Utils_DB::search($tableName, $array,' order by id desc');
		} catch (Exception $e) {
			$this->_forward('error','admin','front',array('msg' => $e->getMessage(),'trace' => $e->getTraceAsString()));
		}
    }
    
}

