<?php

class Admin_GianHangController extends Zend_Controller_Action
{
	private $session = null;
    public function init()
    {
        $this->session = new Zend_Session_Namespace('front');
	    if(isset($this->session->taikhoan)) {
	    	$this->view->taikhoan = $this->session->taikhoan;
	    }
    }

    public function indexAction()
    {
        // action body
    }
    
	public function capNhatLogoAction()
    {
    	try {
	        if(!isset($this->session->taikhoan)) {
	        	$this->_redirect(LOGIN_PAGE);
	        	return ;
	        }
	        $this->_helper->layout->setLayout('admin_layout');
	        $dbLogo = new Application_Model_DbTable_Logo();
	        $taikhoan = $this->session->taikhoan;
	        if($this->_request->isPost()) {
	        	$upload = new Zend_File_Transfer_Adapter_Http();
				$upload->addValidator('Extension', false, zendcms_Controller_Helper_Const::$upload_image_ext);
				$upload->addValidator('FilesSize',false,array('min' => MIN_FILE_SIZE_UPLOAD, 'max' => MAX_FILE_SIZE_UPLOAD));
				$logo_id = 0;
		        if($upload->isValid()) {
					$info = $upload->getFileInfo();
					$info = $info['logo'];
					$parts = zendcms_Controller_Helper_Utils::getPartsFilename(strtolower($info['name']));
					$filename = zendcms_Controller_Helper_Utils::uploadFileName($parts['ext']);
					$upload_path = PUBLIC_DIR . PATH_UPLOAD_LOGO . '/' . $filename;
					$upload->addFilter('Rename',array(
						'target'    => $upload_path,
						'overwrite' => true
					));
					$upload->receive($info['name']);
					$thumb_name = 'thumb_'.$filename;
					$resize_result = zendcms_Controller_Helper_ImageUtils::image_resize_ratio($upload_path, $parts['ext'], PUBLIC_DIR . PATH_UPLOAD_LOGO . '/' . $thumb_name, 90);
					if($resize_result['rs'] == 'TO_SMALL') { //to small
						$thumb_name = $filename;
					}
					zendcms_Controller_Helper_ImageUtils::image_resize($upload_path,$parts['ext'], PUBLIC_DIR . PATH_UPLOAD_LOGO . '/' . $filename, null , 100);
					$dbLogo = new Application_Model_DbTable_Logo();
					$logo_id = $dbLogo->insert(array(
						'id' => null,
						'thumb' => PATH_UPLOAD_LOGO.'/'.$thumb_name,
						'view' => PATH_UPLOAD_LOGO.'/'.$filename
					));
					$this->view->logo_url = PATH_UPLOAD_LOGO.'/'.$filename;
				}
				if($logo_id != 0) {
					$dbGianhang = new Application_Model_DbTable_GianHang();
					$dbGianhang->update(array('logo' => $logo_id), array('id = ?' => $taikhoan->gianhang_id));
					$taikhoan->logo = $logo_id;
				}
	        } else {
	        	$logo = $dbLogo->findbyId($taikhoan->logo);
	        	$this->view->logo_url = $logo->view;
	        }
    	} catch (Exception $e) {
    		if(isset(zendcms_Controller_Helper_Const::$messages[$e->getMessage()])) 
    			$this->view->error_msg = zendcms_Controller_Helper_Const::$messages[$e->getMessage()];
    		else 
    			$this->view->error_msg = $e->getMessage();
	    	$this->_forward('error','thong-bao','admin');
    	}
    }
    
	public function capNhatThongTinAction()
    {
    	try {
	        if(!isset($this->session->taikhoan)) {
	        	$this->_redirect(LOGIN_PAGE);
	        	return ;
	        }
	        $this->_helper->layout->setLayout('admin_layout');
	        $taikhoan = $this->session->taikhoan;
	        $dbTinhThanh = new Application_Model_DbTable_TinhThanh();
    		$this->view->tinhthanh = $dbTinhThanh->findAll();
	        if($this->_request->isPost()) {
	        	$form_data = $this->_request->getParams();
	        	if(zendcms_Controller_Helper_ValidateUtils::validateUpdateGianhangForm($form_data) == false) throw new zendcms_Exceptions_Exception(zendcms_Controller_Helper_Const::$error_messages['VALIDATE_FORM']);
	        	$data_update = zendcms_Controller_Helper_ArrayUtils::childs($form_data, 
	        		array('email_gianhang','tinhthanh_id','slogan','yahoo','dien_thoai','dia_chi','ten_gian_hang','ho_ten'));
	        	$dbGianhang = new Application_Model_DbTable_GianHang();
	        	$dbGianhang->update($data_update, array('id = ?' => $taikhoan->gianhang_id));
	        	$taikhoan->email_gianhang = $form_data['email_gianhang'];
	        	$taikhoan->tinhthanh_id = $form_data['tinhthanh_id'];
	        	$taikhoan->slogan = $form_data['slogan'];
	        	$taikhoan->yahoo = $form_data['yahoo'];
	        	$taikhoan->dien_thoai = $form_data['dien_thoai'];
	        	$taikhoan->dia_chi = $form_data['dia_chi'];
	        	$taikhoan->ten_gian_hang = $form_data['ten_gian_hang'];
	        	$taikhoan->ho_ten = $form_data['ho_ten'];
	        	$this->view->success_msg = zendcms_Controller_Helper_Const::$success_messages['UPDATE'];
	        } else {
	        	//$logo = $dbLogo->findbyId($taikhoan->logo);
	        	//$this->view->logo_url = $logo->view;
	        }
    	} catch (Exception $e) {
    		if(isset(zendcms_Controller_Helper_Const::$messages[$e->getMessage()])) 
    			$this->view->error_msg = zendcms_Controller_Helper_Const::$messages[$e->getMessage()];
    		else 
    			$this->view->error_msg = $e->getMessage();
	    	$this->_forward('error','thong-bao','admin');
    	}
    }
    
	public function capNhatFooterAction()
    {
    	try {
	        if(!isset($this->session->taikhoan)) {
	        	$this->_redirect(LOGIN_PAGE);
	        	return ;
	        }
	        $this->_helper->layout->setLayout('admin_layout');
	        $taikhoan = $this->session->taikhoan;
	        $dbGianhang = new Application_Model_DbTable_GianHang();
	        if($this->_request->isPost()) {
	        	$footer = $this->_request->getParam('footer','');
	        	$footer = substr($footer, 0, 2000);
	        	$dbGianhang->update(array('footer' => $footer), array('id = ?' => $taikhoan->gianhang_id));
	        	$this->view->footer = $footer;
	        	$this->view->success_msg = zendcms_Controller_Helper_Const::$success_messages['UPDATE'];
	        } else {
	        	$this->view->footer = $dbGianhang->findFooter($taikhoan->gianhang_id);
	        	//$logo = $dbLogo->findbyId($taikhoan->logo);
	        	//$this->view->logo_url = $logo->view;
	        }
    	} catch (Exception $e) {
    		if(isset(zendcms_Controller_Helper_Const::$messages[$e->getMessage()])) 
    			$this->view->error_msg = zendcms_Controller_Helper_Const::$messages[$e->getMessage()];
    		else 
    			$this->view->error_msg = $e->getMessage();
	    	$this->_forward('error','thong-bao','admin');
    	}
    }

}

