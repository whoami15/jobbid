<?php

class Admin_AjaxController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    	$this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
    }

    public function indexAction()
    {
        // action body
    }
	public function loadDanhMucConAction() {
		try {
    		//throw new Exception('ERROR');
	        $session = new Zend_Session_Namespace('front');
	        if(!isset($session->taikhoan)) {
	        	$this->_helper->json(zendcms_Controller_Helper_ArrayUtils::array_result('END_SESSION', 0));
	        }
	        $danhmuccha_id = $this->_request->getParam('id','');
	        if(empty($danhmuccha_id)) throw new Exception(zendcms_Controller_Helper_Const::$messages['ERROR']);
	        $dbDanhMucCon = new Application_Model_DbTable_DanhMucCon();
	        $this->_helper->json(zendcms_Controller_Helper_ArrayUtils::array_result($dbDanhMucCon->findByRoot($danhmuccha_id), 1));
    	} catch (Exception $e) {
	        $this->_helper->json(zendcms_Controller_Helper_ArrayUtils::array_result($e->getMessage(), 0));
    	}
	}

}

