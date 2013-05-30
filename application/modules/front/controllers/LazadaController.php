<?php

class Front_LazadaController extends Zend_Controller_Action
{
	var $url = 'http://www.lazada.vn/';
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
        $t1 = Core_Utils_Tools::getServerTime($this->url);
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
    public function index2Action()
    {
    	// action body
    	$t2 = $this->_request->getParam('t2','');
    	if(empty($t2)) die('t2 empty');
    	$t1 = time();
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
    	$this->renderScript('/lazada/index.phtml');
    }
	public function runAction() {
		$this->_helper->layout->disableLayout();
		$cookie = $this->_request->getParam('cookie','');
		$state = $this->_request->getParam('viewstate','');
		$site = new Application_Model_Site_Lazada(trim($cookie));
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
		if(!empty($cookie)) {
			$cache = Core_Utils_Tools::loadCache(86400);
			$cache->save($cookie,'CACHE_COOKIE');
		}
		$site = new Application_Model_Site_Lazada(trim($cookie));
		$content = $site->getContent($this->_request->getParam('url',''));
		echo $content;
		die;
	}


}

