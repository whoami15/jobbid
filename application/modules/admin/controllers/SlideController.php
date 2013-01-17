<?php

class Admin_SlideController extends Zend_Controller_Action
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
	        $db = new Application_Model_DbTable_Slide();
	        $aaData = $db->findSlideByGianhang($taikhoan->gianhang_id);
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
	
	public function addAction()
    {
    	try {
	        if(!isset($this->session->taikhoan)) {
	        	$this->_redirect(LOGIN_PAGE);
	        	return ;
	        }
	        $dbSlide = new Application_Model_DbTable_Slide();
	        $this->_helper->layout->setLayout('admin_layout');
	        $taikhoan = $this->session->taikhoan;
	        if($this->_request->isPost()) {
	        	$upload = new Zend_File_Transfer_Adapter_Http();
				$upload->addValidator('Extension', false, zendcms_Controller_Helper_Const::$upload_image_ext);
				$upload->addValidator('FilesSize',false,array('min' => MIN_FILE_SIZE_UPLOAD, 'max' => MAX_FILE_SIZE_UPLOAD));
		        if($upload->isValid()) {
		        	$stt = $this->_request->getParam('stt',0);
		        	$stt = intval($stt);
					$info = $upload->getFileInfo();
					$info = $info['upload_image'];
					$parts = zendcms_Controller_Helper_Utils::getPartsFilename(strtolower($info['name']));
					$filename = zendcms_Controller_Helper_Utils::uploadFileName($parts['ext']);
					$upload_path = PUBLIC_DIR . PATH_UPLOAD_SLIDE . '/' . $filename;
					$upload->addFilter('Rename',array(
						'target'    => $upload_path,
						'overwrite' => true
					));
					$upload->receive($info['name']);
					$thumb_name = 'thumb_'.$filename;
					$resize_result = zendcms_Controller_Helper_ImageUtils::image_resize($upload_path, $parts['ext'], PUBLIC_DIR . PATH_UPLOAD_SLIDE . '/' . $thumb_name, null,70);
					if($resize_result['rs'] == 'TO_SMALL') { //to small
						$thumb_name = $filename;
					}
					$resize_result = zendcms_Controller_Helper_ImageUtils::image_resize($upload_path,$parts['ext'], PUBLIC_DIR . PATH_UPLOAD_SLIDE . '/' . $filename, null , 250);
					$dbSlide->insert(array(
						'id' => null,
						'gianhang_id' => $taikhoan->gianhang_id,
						'filename' => $filename,
						'thumb' => PATH_UPLOAD_SLIDE.'/'.$thumb_name,
						'image_url' => PATH_UPLOAD_SLIDE.'/'.$filename,
						'width' => $resize_result['new_width'],
						'height' => $resize_result['new_height'],
						'stt' => $stt,
						'state' => 1
					));
					$this->_redirect('admin/slide');
				} else {
					throw new zendcms_Exceptions_Exception('ERROR');
				}
	        } 
	        if(($num = $dbSlide->countSlides($taikhoan->gianhang_id)) >= LIMIT_SLIDE)
	        	throw new zendcms_Exceptions_Exception(sprintf(zendcms_Controller_Helper_Const::$error_messages['LIMIT_SLIDE'],$num));
    	} catch (Exception $e) {
    		if(isset(zendcms_Controller_Helper_Const::$messages[$e->getMessage()])) 
    			$this->view->error_msg = zendcms_Controller_Helper_Const::$messages[$e->getMessage()];
    		else 
    			$this->view->error_msg = $e->getMessage();
	    	$this->_forward('error','thong-bao','admin');
    	}
    }
	public function deleteAction() {
		try {
	        if(!isset($this->session->taikhoan)) throw new zendcms_Exceptions_Exception('END_SESSION');
	        $ids = $this->_request->getParam('id',array());
	        $db =new Application_Model_DbTable_Slide();
	        $db->deleteByIds($ids,$this->session->taikhoan->gianhang_id);
	       	$this->_helper->json(zendcms_Controller_Helper_ArrayUtils::array_result('', 1));
		} catch (Exception $e) {
			$this->_helper->json(zendcms_Controller_Helper_ArrayUtils::array_result($e->getMessage(), 0));
		}
		
	}
	// [ajax update]
	public function updateStateAction() {
		try {
	        if(!isset($this->session->taikhoan)) throw new zendcms_Exceptions_Exception('END_SESSION');
	        $taikhoan = $this->session->taikhoan;
	       	$slide_ids = $this->_request->getParam('id',array());
	       	$state = $this->_request->getParam('state',null);
	       	if($state == null || in_array(intval($state), array(0,1)) == false) throw new zendcms_Exceptions_Exception('ERROR');
	        $db = new Application_Model_DbTable_Slide();
	        $db->updateStateByIds($slide_ids, $taikhoan->gianhang_id, $state);
	        $this->_helper->json(zendcms_Controller_Helper_ArrayUtils::array_result('', 1));
		} catch (Exception $e) {
			$this->_helper->json(zendcms_Controller_Helper_ArrayUtils::array_result($e->getMessage(), 0));
    	}
	}
	
	// [ajax update]
	public function updatePositionAction() {
		try {
			//throw new zendcms_Exceptions_Exception('Loi he thong!');
	        if(!isset($this->session->taikhoan)) throw new zendcms_Exceptions_Exception('END_SESSION');
	        $taikhoan = $this->session->taikhoan;
	       	$slide_id = $this->_request->getParam('row_id','');
	       	$stt = $this->_request->getParam('value',0);
	       	if(empty($slide_id)) return ;
	        $db = new Application_Model_DbTable_Slide();
	        $db->update(array('stt' => $stt), array('id = ?' => $slide_id,'gianhang_id = ?' => $this->session->taikhoan->gianhang_id));
	        $this->_helper->json(zendcms_Controller_Helper_ArrayUtils::array_result($stt, 1));
		} catch (Exception $e) {
			$this->_helper->json(zendcms_Controller_Helper_ArrayUtils::array_result($e->getMessage(), 0));
    	}
	}

}

