<?php

class Front_Yes24Controller extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    	$this->session = new Zend_Session_Namespace('session');
    }

    
	public function indexAction()
    {
        // action body
        $t2 = $this->_request->getParam('t2','');
        if(empty($t2)) die('t2 empty');
        $t1 = Core_Utils_Tools::getServerTime('http://www.yes24.vn');
        $t2 =  strtotime(str_replace('_', ' ', $t2));
        $t = $t2 - $t1;
    	if($this->_request->isXmlHttpRequest()){
    		$this->_helper->json(array('count' => $t));
    	} else {
    		$this->_helper->layout->setLayout('admin_layout');
	        $this->view->count = $t; 
	        $cache = Core_Utils_Tools::loadCache(86400);
	        $this->view->cookie = $cache->load('CACHE_COOKIE');
    	}
    }
	public function runAction() {
		$this->_helper->layout->disableLayout();
		$cookie = $this->_request->getParam('cookie','');
		$state = $this->_request->getParam('viewstate','');
		//$site = new Application_Model_Site_123Vn(trim($cookie));
		$site = new Application_Model_Site_Yes24(trim($cookie),trim($state));
		$result = $site->start();
		$this->_helper->json(array(
			'result' => 'OK',
			'data' => $result
		));
		die;
	}
	public function getContentAction() {
		$this->_helper->layout->disableLayout();
		$cookie = $this->_request->getParam('cookie','');
		$state = $this->_request->getParam('viewstate','');
		if(!empty($cookie)) {
			$cache = Core_Utils_Tools::loadCache(86400);
			$cache->save($cookie,'CACHE_COOKIE');
		}
		$site = new Application_Model_Site_Yes24(trim($cookie),trim($state));
		$content = $site->getContent($this->_request->getParam('url',''));
		//$doc = Core_Dom_Query::newDocumentHTML($content,'UTF-8');
		//$viewState = $doc->find("#__VIEWSTATE")->val();
		echo $content;
		die;
	}


}

