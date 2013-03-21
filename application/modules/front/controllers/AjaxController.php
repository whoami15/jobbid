<?php

class Front_AjaxController extends Zend_Controller_Action
{
	private $session;
    public function init()
    {
    	$this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $this->session = new Zend_Session_Namespace('session');
        $this->session->visitor = Application_Model_DbTable_Visitor::getVisitor($this->session->logged);
    }
	public function checkLoggedAction() {
		if(!isset($this->session->logged)) {
			die('NOT_LOGIN');
		}
		if($this->session->logged['active'] == 0) {
			die('NOT_VERIFY');
		}
		die('OK');
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
	public function fbauthAction()
    {
    	$accessToken = $this->_request->getParam('accessToken','');
    	if(empty($accessToken)) die('ERROR');
    	$graphInfo = Core_Utils_Facebook::getGraphInfo($accessToken);
    	$taikhoan = Application_Model_DbTable_TaiKhoan::findByFbId($graphInfo->id);
    	if($taikhoan == null) die('ERROR');
    	$this->session->__set('logged', $taikhoan);
    	$this->session->__set('graphInfo', $graphInfo);
    	$redirectUrl = isset($this->session->url)?$this->session->url:'/index';
    	die('OK');
    }
    public function verifyRegistrationAction()
    {
    	$key = $this->_request->getParam('key','');
    	if(empty($key)) die('ERROR');
    	if(Application_Model_DbTable_Activity::getNumActivity(ACTION_VERIFY_REGISTRATION_FAILED) > LIMIT_VERIFY_FAILED) {
    		Application_Model_DbTable_Activity::insertLockedActivity(ACTION_VERIFY_REGISTRATION_FAILED);
    		die('LIMIT');
    	}
    	if(($secure_key = Application_Model_DbTable_SecureKey::findByKey($key)) == null) {
    		Application_Model_DbTable_Activity::insertActivity(ACTION_VERIFY_REGISTRATION_FAILED);
    		die('FAILED');
    	} 
    	Application_Model_DbTable_Activity::insertActivity(ACTION_VERIFY_REGISTRATION,$secure_key['account_id']);
    	Application_Model_DbTable_SecureKey::removeSecureKey($secure_key['id']);
    	Core_Utils_DB::update('accounts', array('active' => 1), array('id' => $secure_key['account_id'],'status' => 1));
    	if(($account = Application_Model_DbTable_TaiKhoan::findbyId($secure_key['account_id'])) == null) die('ERROR');
    	$this->session->__set('logged', $account);
    	die(isset($this->session->url)?$this->session->url:'/index');
    }
	public function verifyJobAction()
    {
    	$key = $this->_request->getParam('key','');
    	if(empty($key)) die('ERROR');
    	if(Application_Model_DbTable_Activity::getNumActivity(ACTION_VERIFY_JOB_FAILED) > LIMIT_VERIFY_FAILED) {
    		Application_Model_DbTable_Activity::insertLockedActivity(ACTION_VERIFY_JOB_FAILED,$key);
    		die('LIMIT');
    	}
    	if(($secure_key = Application_Model_DbTable_SecureKey::findByKey($key)) == null) {
    		Application_Model_DbTable_Activity::insertActivity(ACTION_VERIFY_JOB_FAILED);
    		die('FAILED');
    	} 
    	Application_Model_DbTable_Activity::insertActivity(ACTION_VERIFY_JOB_SUCCESS,$secure_key['ref_id']);
    	Application_Model_DbTable_SecureKey::removeSecureKey($secure_key['id']);
    	Core_Utils_DB::update('jobs', array('active' => 1), array('id' => $secure_key['ref_id'],'status' => 1));
    	die('OK');
    }
    public function reportJobAction()
    {
    	$jobId = $this->_request->getParam('id','');
    	if(empty($jobId)) die('ERROR');
    	if(isset($this->session->reports[$jobId])) die('OK');
    	if(Application_Model_DbTable_Job::doReport($jobId, $this->session->visitor) == true) {
    		$this->session->reports[$jobId] = $jobId; 
    	}
    	die('OK');
    }
	public function testAction() {
		$str = 'Việc làm thêm 5';
    	$db = Zend_Registry::get('connectDb');
    	$query = 'INSERT INTO `tags`(`key`,`tag`) VALUES (NULL,?)';
    	$stmt = $db->prepare($query);
    	$stmt->execute(array($str));
    	$stmt->closeCursor();
    	$db->closeConnection();
    	die;
		$first = 'Vina Design - Tuyển Nhân Viên Thiết Kế Đồ Họa Photoshop, Flash Mô tả công việc:
- Công việc đòi hỏi tính sáng tạo cao, có nhiều ý tưởng mới,hay và đặc biệt.
- Có kỹ năng và thẩm mỹ trong thiết kế website, brochures, posters, etc.
- có khả năng sử dụng thành thạo các công cụ thiết kế (như vẽ tay và các phần mềm thiết kế đồ họa) để đưa những ý tưởng sáng tạo vào ứng dụng thực tiễn.
- Làm việc trong môi trường có tính sáng tạo cao
- Nội dung công việc, thời gian làm việc và các vấn đề chi tiết sẽ trao đổi trong vòng phỏng vấn';
		$second = 'nhân viên thiết kế';
		//$second = 'them sinh vien';
		var_dump(metaphone($first));
		var_dump(metaphone($second));die;
		similar_text($second,$first,$p);
		echo $p.'%';
		die;
		$list = explode(',', $string);
		foreach($list as $item) {
			Application_Model_DbTable_Tag::insertTag($item);
		}
		die('OK');
		if(Core_Utils_String::checkContent($content) == true) {
			echo 'true';
		} else {
			echo 'false';
		}
		die;
		print_r($this->session->logged);die;
		$date = new Zend_Date();
		$date->subMinute(5);
		echo $date->toString();
		//Core_Utils_DB::update('jobs',array('view' => '`view` + 1'),array('id' => 1));
		//echo $key;
		/*$str = file_get_contents('https://graph.facebook.com/me?access_token=AAACF3doGSoEBAD0ph0PHsAftEr5GVbZBR0IjpximstoVGjiwj2xbSuVxVXKIO3qlS5VyJ0ZCA9zsa7L2GMMZB1dhq0HgiIsrZCCjm7uP0XtuA3jOkVcy');
		$array = json_decode($str);
		print_r($array);*/
		/* $session = new Zend_Session_Namespace('session');
		//$session->unsetAll();
		print_r($session->logged); */
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

