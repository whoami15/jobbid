<?php

class Admin_SanPhamController extends Zend_Controller_Action
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
        // action body
    }
	public function themSanPhamAction()
    {
    	try {
    		//throw new Exception('ERROR');
	        if(!isset($this->session->taikhoan)) {
	        	$this->_redirect(LOGIN_PAGE);
	        	return ;
	        }
	        $taikhoan = $this->session->taikhoan;
	       	$this->_helper->layout->setLayout('admin_layout');
	        $dbDanhMucGoc = new Application_Model_DbTable_DanhMucGoc();
	        $this->view->danhmucgoc = $dbDanhMucGoc->findAll();
	        $dbModule = new Application_Model_DbTable_Module();
	        $this->view->modules = $dbModule->findModuleByGianhang($taikhoan->gianhang_id);
	        $dbTinhThanh = new Application_Model_DbTable_TinhThanh();
	        $this->view->tinhthanh = $dbTinhThanh->findAll();
    	} catch (Exception $e) {
    		if(isset(zendcms_Controller_Helper_Const::$messages[$e->getMessage()])) 
    			$this->view->error_msg = zendcms_Controller_Helper_Const::$messages[$e->getMessage()];
    		else 
    			$this->view->error_msg = $e->getMessage();
	    	$this->_forward('error','thong-bao','admin');
    	}
    }
    public function submitThemSanPhamAction() {
    	try {
	        if(!isset($this->session->taikhoan)) {
	        	$this->_redirect(LOGIN_PAGE);
	        	return;
	        }
	        $taikhoan = $this->session->taikhoan;
	    	$formdata = $this->_request->getParams();
	    	if(zendcms_Controller_Helper_ValidateUtils::validateThemSanPhamForm($formdata) == false) throw new Exception('ERROR');
	    	$time = zendcms_Controller_Helper_Utils::getCurrentDateSQL();
	    	$upload = new Zend_File_Transfer_Adapter_Http();
			$upload->addValidator('Extension', false, zendcms_Controller_Helper_Const::$upload_image_ext);
			$upload->addValidator('FilesSize',false,array('min' => MIN_FILE_SIZE_UPLOAD, 'max' => MAX_FILE_SIZE_UPLOAD));
			$image_id = '0';
			if($upload->isValid()) {
				$info = $upload->getFileInfo();
				$info = $info['upload_image'];
				$parts = zendcms_Controller_Helper_Utils::getPartsFilename(strtolower($info['name']));
				$filename = zendcms_Controller_Helper_Utils::uploadFileName($parts['ext']);
				$upload_path = PUBLIC_DIR . PATH_UPLOAD_PRODUCT_IMAGE . '/' . $filename;
				$upload->addFilter('Rename',array(
					'target'    => $upload_path,
					'overwrite' => true
				));
				$upload->receive($info['name']);
				$thumb_name = 'thumb_'.$filename;
				$resize_result = zendcms_Controller_Helper_ImageUtils::image_resize_ratio($upload_path, $parts['ext'], PUBLIC_DIR . PATH_UPLOAD_PRODUCT_IMAGE . '/' . $thumb_name, 140);
				if($resize_result['rs'] == 'TO_SMALL') { //to small
					$thumb_name = $filename;
				}
				$resize_result = zendcms_Controller_Helper_ImageUtils::image_resize($upload_path,$parts['ext'], PUBLIC_DIR . PATH_UPLOAD_PRODUCT_IMAGE . '/' . $filename, 400 , null);
				$dbImage = new Application_Model_DbTable_Images();
				$image_id = $dbImage->insert(array(
					'id' => null,
					'filename' => $info['name'], 
					'path_thumb' => PATH_UPLOAD_PRODUCT_IMAGE.'/'.$thumb_name, 
					'path' => PATH_UPLOAD_PRODUCT_IMAGE.'/'.$filename, 
					'width' => $resize_result['new_width'], 
					'height' => $resize_result['new_height'], 
					'create_time' => $time, 
					'create_user' => $taikhoan->id, 
					'deleted' => 0
				));
			}
	    	$dbSanpham = new Application_Model_DbTable_SanPham();
	    	$data_sanpham = $dbSanpham->createRow($formdata);
	    	$data_sanpham->setFromArray(array(
	    		'id' => null,
	    		'slug' => getSlug($formdata['ten_san_pham']),
	    		'image_id' => $image_id,
	    		'gianhang_id' => $taikhoan->gianhang_id,
	    		'create_time' => $time,
	    		'locked' => '0'
	    	));
	    	if(($sanpham_id = $dbSanpham->insert($data_sanpham->toArray())) == false) throw new Exception('ERROR');
	    	$dbModule = new Application_Model_DbTable_Module();
	    	$dbModule->addSanpham2Module($sanpham_id, $formdata['chkModuleSanPham'], $taikhoan->gianhang_id, $time);
    		$dbSanpham->updateDanhmucBySanpham($this->session->taikhoan->gianhang_id);
	    	$this->_redirect("/admin/san-pham/xem-danh-sach");
    	} catch (Exception $e) {
    		if(isset(zendcms_Controller_Helper_Const::$messages[$e->getMessage()])) 
    			$this->view->error_msg = zendcms_Controller_Helper_Const::$messages[$e->getMessage()];
    		else 
    			$this->view->error_msg = $e->getMessage();
	    	$this->_forward('error','thong-bao','admin');
    	}
    }

	public function capNhatSanPhamAction()
    {
    	try {
    		//throw new Exception('ERROR');
	        if(!isset($this->session->taikhoan)) {
	        	$this->_redirect(LOGIN_PAGE);
	        	return ;
	        }
	        $sanpham_id = $this->_request->getParam('id','');
	        if(empty($sanpham_id)) throw new zendcms_Exceptions_Exception('ERROR');
	        $dbSanPham = new Application_Model_DbTable_SanPham();
	        if(($sanpham = $dbSanPham->findById($sanpham_id)) == null) throw new zendcms_Exceptions_Exception('ERROR');
	        $taikhoan = $this->session->taikhoan;
	        if($sanpham->gianhang_id != $taikhoan->gianhang_id) throw new zendcms_Exceptions_Exception('ERROR');
	        $this->_helper->layout->disableLayout();
	        $this->view->sanpham = (array)$sanpham;
	        $dbDanhMucGoc = new Application_Model_DbTable_DanhMucGoc();
	        $this->view->danhmucgoc = $dbDanhMucGoc->findAll();
	        $dbModule = new Application_Model_DbTable_Module();
	        $this->view->modules = $dbModule->findModuleByGianhang($taikhoan->gianhang_id);
	        $this->view->sanpham_modules = $dbModule->findModulesBySanpham($sanpham_id);
	        $dbTinhThanh = new Application_Model_DbTable_TinhThanh();
	        $this->view->tinhthanh = $dbTinhThanh->findAll();
	        $this->view->flag = $this->_request->getParam('f','');
	        
    	} catch (Exception $e) {
    		if(isset(zendcms_Controller_Helper_Const::$messages[$e->getMessage()])) 
    			$this->view->error_msg = zendcms_Controller_Helper_Const::$messages[$e->getMessage()];
    		else 
    			$this->view->error_msg = $e->getMessage();
	    	$this->_forward('error','thong-bao','admin');
    	}
    }
    
	public function submitCapNhatSanPhamAction() {
    	try {
	        if(!isset($this->session->taikhoan)) {
	        	$this->_redirect(LOGIN_PAGE);
	        	return;
	        }
	        $taikhoan = $this->session->taikhoan;
	    	$formdata = $this->_request->getParams();
	    	if(zendcms_Controller_Helper_ValidateUtils::validateCapNhatSanPhamForm($formdata) == false) throw new Exception('ERROR');
	    	$sanpham_id = $formdata['id'];
	        $dbSanPham = new Application_Model_DbTable_SanPham();
	        if(($sanpham = $dbSanPham->findById($sanpham_id)) == null) throw new zendcms_Exceptions_Exception('ERROR');
	        if($sanpham->gianhang_id != $taikhoan->gianhang_id) throw new zendcms_Exceptions_Exception('ERROR');
	    	$time = zendcms_Controller_Helper_Utils::getCurrentDateSQL();
	    	$upload = new Zend_File_Transfer_Adapter_Http();
			$upload->addValidator('Extension', false, zendcms_Controller_Helper_Const::$upload_image_ext);
			$upload->addValidator('FilesSize',false,array('min' => MIN_FILE_SIZE_UPLOAD, 'max' => MAX_FILE_SIZE_UPLOAD));
			$image_id = $sanpham->image_id;
			if($upload->isValid()) {
				$info = $upload->getFileInfo();
				$info = $info['upload_image'];
				$parts = zendcms_Controller_Helper_Utils::getPartsFilename(strtolower($info['name']));
				$filename = zendcms_Controller_Helper_Utils::uploadFileName($parts['ext']);
				$upload_path = PUBLIC_DIR . PATH_UPLOAD_PRODUCT_IMAGE . '/' . $filename;
				$upload->addFilter('Rename',array(
					'target'    => $upload_path,
					'overwrite' => true
				));
				$upload->receive($info['name']);
				$thumb_name = 'thumb_'.$filename;
				$resize_result = zendcms_Controller_Helper_ImageUtils::image_resize_ratio($upload_path, $parts['ext'], PUBLIC_DIR . PATH_UPLOAD_PRODUCT_IMAGE . '/' . $thumb_name, 140);
				if($resize_result['rs'] == 'TO_SMALL') { //to small
					$thumb_name = $filename;
				}
				$resize_result = zendcms_Controller_Helper_ImageUtils::image_resize($upload_path,$parts['ext'], PUBLIC_DIR . PATH_UPLOAD_PRODUCT_IMAGE . '/' . $filename, 500 , null);
				$dbImage = new Application_Model_DbTable_Images();
				$image_id = $dbImage->insert(array(
					'id' => null,
					'filename' => $info['name'], 
					'path_thumb' => PATH_UPLOAD_PRODUCT_IMAGE.'/'.$thumb_name, 
					'path' => PATH_UPLOAD_PRODUCT_IMAGE.'/'.$filename, 
					'width' => $resize_result['new_width'], 
					'height' => $resize_result['new_height'], 
					'create_time' => $time, 
					'create_user' => $taikhoan->id, 
					'deleted' => 0
				));
			}
			$formdata['image_id'] = $image_id;
			$formdata['update_time'] = $time;
			$data_sanpham = zendcms_Controller_Helper_ArrayUtils::childs($formdata, array('ten_san_pham','tinh_trang','loai_gia','gia_san_pham','gia_ban','noi_ban','bao_hanh','trang_thai','image_id','chi_tiet','danhmucgoc_id','danhmuccon_id','update_time'));
	    	$data_sanpham['slug'] = getSlug($formdata['ten_san_pham']);
			$dbSanpham = new Application_Model_DbTable_SanPham();
	    	$dbSanpham->update($data_sanpham, array('id=?'=>$sanpham_id));
	    	$dbModule = new Application_Model_DbTable_Module();
	    	$dbModule->addSanpham2Module($sanpham_id, $formdata['chkModuleSanPham'], $taikhoan->gianhang_id, $time,true);
    		$dbSanpham->updateDanhmucBySanpham($taikhoan->gianhang_id);
    		//update VIP
    		$dbVip = new Application_Model_DbTable_Vip();
	        if($dbVip->isVip($sanpham_id) > 0) {
	        	$cache = zendcms_Controller_Helper_Utils::loadCache();
	        	$cache->remove('sanphamvip');
	        }
	    	$this->_redirect("/admin/san-pham/cap-nhat-san-pham/id/$sanpham_id?f=1");
    	} catch (Exception $e) {
    		if(isset(zendcms_Controller_Helper_Const::$messages[$e->getMessage()])) 
    			$this->view->error_msg = zendcms_Controller_Helper_Const::$messages[$e->getMessage()];
    		else 
    			$this->view->error_msg = $e->getMessage();
	    	$this->_forward('error','thong-bao','admin');
    	}
    }
    
    public function xemDanhSachAction() {
    	//Xem danh sach san pham
		try {
	        if(!isset($this->session->taikhoan)) {
	        	$this->_redirect(LOGIN_PAGE);
	        	return;
	        }
	        //$taikhoan = $this->session->taikhoan;
	        $this->_helper->layout->setLayout('admin_layout');
	        $dbDanhMucGoc = new Application_Model_DbTable_DanhMucGoc();
			$this->view->list_danhmucgoc = $dbDanhMucGoc->findAll();
	        
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
	        $sSearch = $this->_request->getParam('sSearch','');
	        if(SAFE_MODE) $sSearch = processContent($sSearch);
	        $sWhere = ' t0.locked = 0 and t0.gianhang_id = :gianhang_id ';
	        $params = array('gianhang_id' => $taikhoan->gianhang_id);
	        if(!empty($sSearch)) {
	        	 $formdata = Zend_Json_Decoder::decode($sSearch);
	        	 foreach($formdata as $field) {
	        	 	$value = $field['value'];
	        	 	if(!empty($value)) {
	        	 		switch ($field['name']) {
	        	 			case 'ten_san_pham':
	        	 				$value = str_replace(' ', '%', $value);
	        	 				$sWhere.=" and t0.ten_san_pham like :ten_san_pham";
	        	 				$params['ten_san_pham'] = "%$value%";
	        	 				break;
	        	 			case 'danhmucgoc_id':
	        	 				$sWhere.=" and t0.danhmucgoc_id = :danhmucgoc_id";
	        	 				$params['danhmucgoc_id'] = $value;
	        	 				break;
	        	 			case 'trang_thai':
	        	 				$sWhere.=" and t0.trang_thai = :trang_thai";
	        	 				$params['trang_thai'] = $value;
	        	 				break;
	        	 			default:
	        	 				break;
	        	 		}
	        	 	}
	        	 }
	        }
	       
	        $iDisplayStart = $this->_request->getParam('iDisplayStart',0);
	        $iDisplayLength = $this->_request->getParam('iDisplayLength',DEFAULT_DISPLAY_LENGTH);
	        $db = new Application_Model_DbTable_SanPham();
	        $aaData = $db->getAll($sWhere,$params,$iDisplayStart,$iDisplayLength+1);
	        $length = count($aaData);
	        unset($aaData[$iDisplayLength]);
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
	public function deleteAction() {
		try {
	        if(!isset($this->session->taikhoan)) throw new zendcms_Exceptions_Exception('END_SESSION');
	        $ids = $this->_request->getParam('id',array());
	        $db = new Application_Model_DbTable_SanPham();
	        $db->deleteByIds($ids,$this->session->taikhoan->gianhang_id);
	        $db->updateDanhmucBySanpham($this->session->taikhoan->gianhang_id);
			//update VIP
    		$dbVip = new Application_Model_DbTable_Vip();
	        if($dbVip->isVip($ids) > 0) {
	        	$cache = zendcms_Controller_Helper_Utils::loadCache();
	        	$cache->remove('sanphamvip');
	        }
	       	$this->_helper->json(zendcms_Controller_Helper_ArrayUtils::array_result('', 1));
		} catch (Exception $e) {
			$this->_helper->json(zendcms_Controller_Helper_ArrayUtils::array_result($e->getMessage(), 0));
		}
		
	}
	public function soldOutAction() {
		try {
	        if(!isset($this->session->taikhoan)) throw new zendcms_Exceptions_Exception('END_SESSION');
	        $ids = $this->_request->getParam('id',array());
	        $db = new Application_Model_DbTable_SanPham();
	        $db->updateStateByIds($ids, 3,$this->session->taikhoan->gianhang_id);
	        $db->updateDanhmucBySanpham($this->session->taikhoan->gianhang_id);
	       	$this->_helper->json(zendcms_Controller_Helper_ArrayUtils::array_result('', 1));
		} catch (Exception $e) {
			$this->_helper->json(zendcms_Controller_Helper_ArrayUtils::array_result($e->getMessage(), 0));
		}
	}
}

