<?php

class Admin_ModuleController extends Zend_Controller_Action
{
	private $session = null;
    public function init()
    {
        /* Initialize action controller here */
    	$this->session = new Zend_Session_Namespace('front');
	    if(isset($this->session->taikhoan)) {
	    	$this->view->taikhoan = $this->session->taikhoan;
	    }
    }

    public function indexAction()
    {
    	try {
	        if(!isset($this->session->taikhoan)) {
	        	$this->_redirect(LOGIN_PAGE);
	        	return;
	        }
	        //$taikhoan = $session->taikhoan;
	        $this->_helper->layout->setLayout('admin_layout');
	        
		} catch (Exception $e) {
    		if(isset(zendcms_Controller_Helper_Const::$messages[$e->getMessage()])) 
    			$this->view->error_msg = zendcms_Controller_Helper_Const::$messages[$e->getMessage()];
    		else 
    			$this->view->error_msg = $e->getMessage();
	    	$this->_forward('error','thong-bao','admin');
    	}
    }

	public function listAction() {
		try {
			if(!isset($this->session->taikhoan)) throw new zendcms_Exceptions_Exception('END_SESSION');
			$taikhoan = $this->session->taikhoan;
	        $sEcho = $this->_request->getParam('sEcho',''); 
	        $iDisplayStart = $this->_request->getParam('iDisplayStart',0);
	        $iDisplayLength = $this->_request->getParam('iDisplayLength',DEFAULT_DISPLAY_LENGTH);
	        $db = new Application_Model_DbTable_Module();
	        $aaData = $db->findModuleByGianhang($taikhoan->gianhang_id);
	        $length = count($aaData);
	        $result = array(
	        	'sEcho' => $sEcho,
	        	'iTotalRecords' => $iDisplayStart+$length,
	        	'iTotalDisplayRecords' =>$iDisplayStart+$length,
	        	'aaData'=>$aaData
	        );
	        $this->_helper->json($result);
		} catch (Exception $e) {
			$this->_helper->json(zendcms_Controller_Helper_ArrayUtils::array_result($e->getMessage(), 0));
		}
	}
	
	// [popup]
	public function editAction() {
		try {
	        if(!isset($this->session->taikhoan)) throw new zendcms_Exceptions_Exception('END_SESSION');
	        //$taikhoan = $session->taikhoan;
	       $this->_helper->layout->disableLayout();
	        
		} catch (Exception $e) {
			if($e->getMessage()=='END_SESSION') {
				$this->renderScript('/redirect-login.phtml');
			} else {
				if(isset(zendcms_Controller_Helper_Const::$messages[$e->getMessage()])) 
    				die(zendcms_Controller_Helper_Const::$messages[$e->getMessage()]);
    			else 
    				die ($e->getMessage());
			}
    	}
	}
	
	// [ajax update]
	public function doEditAction() {
		try {
	        if(!isset($this->session->taikhoan)) throw new zendcms_Exceptions_Exception('END_SESSION');
	        $taikhoan = $this->session->taikhoan;
	        $form_data = $this->_request->getParams();
	        if(zendcms_Controller_Helper_ValidateUtils::validateCapNhatModuleForm($form_data) == false) throw new zendcms_Exceptions_Exception('ERROR');
	        $data_update = zendcms_Controller_Helper_ArrayUtils::childs($form_data, array('ten_module','vitri','state'),false);
	        $db = new Application_Model_DbTable_Module();
	        $db->update($data_update, array('ma_module = ?' => $form_data['ma_module'],'gianhang_id = ?' => $taikhoan->gianhang_id));
	        $this->_helper->json(zendcms_Controller_Helper_ArrayUtils::array_result('OK', 1));
		} catch (Exception $e) {
			$this->_helper->json(zendcms_Controller_Helper_ArrayUtils::array_result($e->getMessage(), 0));
    	}
	}
	
	// [ajax update]
	public function updateStateAction() {
		try {
	        if(!isset($this->session->taikhoan)) throw new zendcms_Exceptions_Exception('END_SESSION');
	        $taikhoan = $this->session->taikhoan;
	       	$ma_modules = $this->_request->getParam('id',array());
	       	$state = $this->_request->getParam('state',null);
	       	if($state == null || in_array(intval($state), array(0,1)) == false) throw new zendcms_Exceptions_Exception('ERROR');
	        $db = new Application_Model_DbTable_Module();
	        $db->updateStateByIds($ma_modules, $taikhoan->gianhang_id, $state);
	        $this->_helper->json(zendcms_Controller_Helper_ArrayUtils::array_result('OK', 1));
		} catch (Exception $e) {
			$this->_helper->json(zendcms_Controller_Helper_ArrayUtils::array_result($e->getMessage(), 0));
    	}
	}
}

