<?php

class Admin_MenuController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }
	public function createMenuAction() {
		$session = new Zend_Session_Namespace('front');
        if(!isset($session->taikhoan)) {
        	die('END_SESSION');
        }
		$this->_helper->layout->disableLayout();
	 	$cache = zendcms_Controller_Helper_Utils::loadCache();
        if(($menu = $cache->load('admin_menu')) == null) {
    		$db = new admin_Model_DbTable_ChucNang();
    		$menu = $db->getMenu();
    		$cache->save($menu,'admin_menu');
    	}
        $this->view->roots = $menu;
	}

}

