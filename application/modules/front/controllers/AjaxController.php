<?php

class Front_AjaxController extends Zend_Controller_Action
{

    public function init()
    {
    	$this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
    }
    public function autoCompleteAction() {
    	$type = $this->_request->getParam('type','');
    	$keyword = $this->_request->getParam('keyword','');
    	$result = array();
    	if(!empty($keyword)) {
    		$keyword = '%'.str_replace(' ', '%', trim($keyword)).'%';
	    	if($type=='company') {
	    		$result = Application_Model_DbTable_Company::suggest($keyword);
	    	} else {
	    		$result = Application_Model_DbTable_JobTitle::suggest($keyword);
	    	}
    	}
		$this->_helper->json($result);    	
    }
	public function refeshCaptchaAction() {
		$type = $this->_request->getParam('t','');
		if(!in_array($type, Core_Const::$captcha_type)) die('ERROR');
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
		if(!in_array($type, Core_Const::$captcha_type)) die('ERROR');
		$session = new Zend_Session_Namespace('front');
    	if(!isset($session->captcha_word[$type])) die('ERROR');
		$captcha_word = $this->_request->getParam('word','');
		if(strcmp($captcha_word, $session->captcha_word[$type]) == 0) {
			die('OK');
		}
		die('WRONG');
	}
	/*
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
	}*/

}

