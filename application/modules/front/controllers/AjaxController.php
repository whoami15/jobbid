<?php

class Front_AjaxController extends Zend_Controller_Action
{

    public function init()
    {
    	$this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
    }
	public function refeshCaptchaAction() {
		$type = $this->_request->getParam('t','');
		if(!in_array($type, zendcms_Controller_Helper_Const::$captcha_type)) die('ERROR');
		$session = new Zend_Session_Namespace('front');
    	$captcha = new Zend_Captcha_Image();
       	$captcha->setWordLen('4');
       	$captcha->setTimeout('300');
       	$captcha->setHeight('40');
		$captcha->setWidth('200');
		$captcha->setLineNoiseLevel(0);
		$captcha->setImgDir(PATH_CAPTCHA_IMAGES);
		$captcha->setImgUrl(DOMAIN.$this->getFrontController()->getBaseUrl().'/captcha/images/');
		$captcha->setFont(PATH_CAPTCHA_FONT);
		$id = $captcha->generate();
		$session->captcha_word[$type] = $captcha->getWord();
		die($captcha->getImgUrl().$id.$captcha->getSuffix());
	}
	public function checkCaptchaAction() {
		$type = $this->_request->getParam('t','');
		if(!in_array($type, zendcms_Controller_Helper_Const::$captcha_type)) die('ERROR');
		$session = new Zend_Session_Namespace('front');
    	if(!isset($session->captcha_word[$type])) die('ERROR');
		$captcha_word = $this->_request->getParam('word','');
		if(strcmp($captcha_word, $session->captcha_word[$type]) == 0) {
			die('OK');
		}
		die('WRONG');
	}
	public function addToCartAction() {
		try {
			$sanpham_id = $this->_request->getParam('id','');
			if(empty($sanpham_id)) throw new zendcms_Exceptions_Exception('ERROR');
			$dbSanpham = new Application_Model_DbTable_SanPham();
			if(($sanpham = $dbSanpham->findById($sanpham_id,'t0.id,ten_san_pham,slug,gianhang_id,tinh_trang,loai_gia,gia_san_pham,gia_ban,trang_thai,path_thumb,filename')) == null) throw new zendcms_Exceptions_Exception('ERROR');
			$session = new Zend_Session_Namespace('front');
			if(!isset($session->cart[$sanpham->gianhang_id])) $session->cart[$sanpham->gianhang_id] = array(
				'gianhang_id' => $sanpham->gianhang_id,
				'num_item' => 0,
				'total' => 0,
				'sanphams' => array()
			);
			if(!isset($session->cart[$sanpham->gianhang_id]['sanphams'][$sanpham->id])) {
				$sanpham->soluong = 1;
				$session->cart[$sanpham->gianhang_id]['sanphams'][$sanpham->id] = (array)$sanpham;;
				$session->cart[$sanpham->gianhang_id]['num_item']++;
				if($sanpham->loai_gia != 3)
					$session->cart[$sanpham->gianhang_id]['total']+= $sanpham->gia_ban;
			}
			$this->_helper->json(zendcms_Controller_Helper_ArrayUtils::array_result('OK', 1));
		} catch (Exception $e) {
			$this->_helper->json(zendcms_Controller_Helper_ArrayUtils::array_result($e->getMessage(), 0));
		}
	}
	public function removeOutCartAction() {
		try {
			$sanpham_id = $this->_request->getParam('id1','');
			$gianhang_id = $this->_request->getParam('id2','');
			if(empty($sanpham_id) || empty($gianhang_id)) throw new zendcms_Exceptions_Exception('ERROR');
			$session = new Zend_Session_Namespace('front');
			if(isset($session->cart[$gianhang_id]['sanphams'][$sanpham_id])) {
				$sanpham = $session->cart[$gianhang_id]['sanphams'][$sanpham_id];
				unset($session->cart[$gianhang_id]['sanphams'][$sanpham_id]);
				$session->cart[$gianhang_id]['num_item']--;
				if($sanpham['loai_gia'] != 3)
					$session->cart[$gianhang_id]['total']-= $sanpham['gia_ban'];
			}
			$this->_helper->json(zendcms_Controller_Helper_ArrayUtils::array_result('OK', 1));
		} catch (Exception $e) {
			$this->_helper->json(zendcms_Controller_Helper_ArrayUtils::array_result($e->getMessage(), 0));
		}
	}
	public function sendOrderMailAction() {
		$purchase_id = $this->_request->getParam('id','');
		if(!empty($purchase_id)) {
			$dbPurchase = new Application_Model_DbTable_Purchase();
			if(($purchase = $dbPurchase->findById($purchase_id)) != null) {
				if($purchase->is_send == false) {
					$dbGianhang = new Application_Model_DbTable_GianHang();
					if(($gianhang = $dbGianhang->findById($purchase->gianhang_id)) == null) return;
					$link = DOMAIN.$this->getFrontController()->getBaseUrl().'/'.$gianhang->ma_gian_hang.'/phieu-dat-hang?id='.$purchase->id.'&code='.$purchase->code;
					$link = '<a href="'.$link.'">'.$link.'</a>';
					$send_mail = new zendcms_Controller_Helper_SendMail();
		    		$send_mail->sendEmailByTemplate($gianhang->email_gianhang, array(
		    			'link' => $link
		    		),TEMPLATE_ORDER);
		    		$dbPurchase->update(array('is_send' => 1), array('id = ?' => $purchase_id));
				}
			}
		}
	}
    public function indexAction()
    {
        // action body
       /* $data = array(
        	'username' => '123',
        	'password' => '123456',
        	'email' => 'test@yahoo.com'
        );
       	if(zendcms_Controller_Helper_ValidateUtils::validateRegisterForm($data))
       	 	echo 'valid';
       	 else
       	 	echo 'not valid';*/
    	/*$db = new Application_Model_DbTable_GianHang();
		if($db->checkExistMaGianHang('1233') == true) die('da ton tai');
		die('ok');*/
    	//$session = new Zend_Session_Namespace('front');
    	//print_r($session->taikhoan);
    	//$db = new Application_Model_DbTable_SanphamVip();
    	//print_r($db->findAllSanPhamVip());
    	/*$str = '';
    	$parts = explode('@', $str);
    	echo  $parts[0];*/
    	//$session = new Zend_Session_Namespace('front');
    	//unset($session->cart);
    	/*$session->cart[1] = array('id' => 1);
    	$session->cart[2] = array('id' => 2);*/
    	$dbVip = new Application_Model_DbTable_Vip();
    	echo $dbVip->isVip(9);
    	echo 'DONE';
    	//echo zendcms_Controller_Helper_NumberUtils::parseInt($str);
    	//print_r(DOMAIN.$this->getFrontController()->getBaseUrl());
    	//$str = 'sss';
    	//print_r(intval($str));
    	/*$db = new admin_Model_DbTable_ChucNang();
    	print_r($db->getMenu());*/
    	//print_r($db->loadCategories());
    	//echo md5('123456');
    	
    }


}

