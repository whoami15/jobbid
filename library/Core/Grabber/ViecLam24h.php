<?php
class Core_Grabber_ViecLam24h
{
	var $_data;
	var $_cUrl;
	public function __construct($data){
    	$this->_data = $data;
    	$this->_cUrl = new Core_Dom_Curl(array(
				'method' => 'GET',
				'header' => array(
						'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
						'Accept-Encoding: gzip, deflate',
						'Accept-Language: en-US,en;q=0.5',
						'Connection: keep-alive',
						'DNT: 1',
						'User-Agent: Mozilla/5.0 (Windows NT 6.1; WOW64; rv:19.0) Gecko/20100101 Firefox/19.0',
						'X-Requested-With: 	XMLHttpRequest'
				)
		));
    }
    public function getLink() {
    	$content = $this->_cUrl->getContent($this->_data['url']);
		$doc = Core_Dom_Query::newDocumentHTML($content,'UTF-8');
		foreach ($doc['.text11soluong'] as $item) {
			$td = pq($item)->parent('td');
			$link = $td->find('a.linkBlack')->get(0);
			$href = 'http://hcm.vieclam.24h.com.vn'.$link->getAttribute('href');
			if(($class_name = Core_Utils_Tools::getGrabber($href)) == null) throw new Core_Exception('HOST INVALID');
		    Core_Utils_DB::query('INSERT DELAYED INTO `links`(`url`,`class_name`,`create_time`) VALUES (?,?,NOW())',3,array($href,$class_name));
		}
    }
	public function doGrab() {
		$now = Core_Utils_Date::getCurrentDateSQL();
		Core_Utils_DB::update('links', array('status' => 0,'grab_time' => $now), array('id' => $this->_data['id']));
		$content = $this->_cUrl->getContent($this->_data['url']);
		$doc = Core_Dom_Query::newDocumentHTML($content,'UTF-8');
		$title = trim($doc->find('.TTTD-ten')->text());
		$array = array();
		foreach ($doc['.colLeft > table tr'] as $tr) {
			$tds = pq($tr)->find('> td');
			try {
				$key = Core_Utils_String::getSlug(trim($tds->get(0)->textContent));
				if($key == 'mo-ta-cong-viec') {
					$td = $tds->get(1);
					$value = trim(pq($td)->html());
					//$value = $tds->get(1)->textContent;
					$value = str_ireplace(array("<br>", "<br />"), "\r\n",$value);
				} else {
					$value = @trim($tds->get(1)->textContent);
				}
				
				$array[$key] = $value;
			} catch (Exception $e) {
				Core_Utils_Log::error($e);
			}
		}
		//print_r($array['mo-ta-cong-viec']);die;
		$email = Core_Utils_Array::getValue($array,'email-lien-he');
		if(empty($email)) {
			Core_Utils_Log::write('Read email error '.$this->_data['url'],'ERROR');
			return;
		}
		
		$description = $array['mo-ta-cong-viec'].EOL;
		$description.= ' - Mức lương: '.Core_Utils_Array::getValue($array,'muc-luong').EOL;
		$description.= ' - Quyền lợi được hưởng: '.Core_Utils_Array::getValue($array,'quyen-loi-duoc-huong').EOL;
		$description.= ' - Hồ sơ bao gồm: '.Core_Utils_Array::getValue($array,'ho-so-bao-gom').EOL;
		$description.= ' - Hạn nộp hồ sơ: '.Core_Utils_Array::getValue($array,'han-nop-ho-so').EOL;
		$description.= ' - Hình thức nộp hồ sơ: '.Core_Utils_Array::getValue($array,'hinh-thuc-nop-ho-so').EOL;
		$description.=EOL.'THÔNG TIN LIÊN HỆ :'.EOL;
		$description.= ' - Người liên hệ: '.Core_Utils_Array::getValue($array,'nguoi-lien-he').EOL;
		$description.= ' - Địa chỉ liên hệ: '.Core_Utils_Array::getValue($array,'dia-chi-lien-he').EOL;
		$description.= ' - Email liên hệ: '.Core_Utils_Array::getValue($array,'email-lien-he').EOL;
		$description.= ' - Điện thoại liên hệ: '.Core_Utils_Array::getValue($array,'dien-thoai-lien-he').EOL;
		$company = Core_Utils_Array::getValue($array,'ten-cong-ty');
		$places = Core_Utils_Array::getValue($array,'dia-diem-lam-viec');
		$city_id = 0;
		$places = explode(',', $places);
		if(count($places) == 1) {
			$place = Core_Utils_String::getSlug($places[0]);
			$place = "%$place;%";
			$row = Core_Utils_DB::query('SELECT * FROM `cities` WHERE maps LIKE ?',2,array($place));
			if($row != null) $city_id = $row['id'];
		}
		if($city_id == 0) {
			$description .= ' - Địa điểm làm việc: '.Core_Utils_Array::getValue($array,'dia-diem-lam-viec').EOL;
		}
		$alias = Core_Utils_String::getSlug($title);
		$row = Core_Utils_DB::query('SELECT * FROM `job_grab` WHERE `alias` = ? AND `email` = ?',2,array($alias,$email));
		if($row != null) {
			Core_Utils_Log::write('Exist job '.$this->_data['url'],'ERROR');
			return;
		}
		$companyId = null;
		if(!empty($company)) {
			$modelCompany = new Application_Model_DbTable_Company();
        	$companyId = $modelCompany->save($company);
		}
        $modelJob = new Application_Model_DbTable_Job();
        $jobId = $modelJob->insert(array(
        		'id' => null,
        		'title' => $title,
        		'account_id' => 1,
        		'company_id' => $companyId,
        		'job_title_id' => null,
        		'job_description' => $description,
        		'city_id' => $city_id,
        		'email_to' => $email,
        		'job_type' => 1,
        		'view' => 0,
        		'time_create' => $now,
        		'time_update' => $now,
        		'sec_id' => '',
        		'status' => 1,
        		'active' => 1,
        		'link_id' => $this->_data['id']
        ));
        Core_Utils_DB::query('INSERT INTO `job_grab`(`alias`,`email`) VALUES (?,?)',3,array($alias,$email));
        $dbSecureKey = new Application_Model_DbTable_SecureKey();
        $key = Core_Utils_Tools::genSecureKey(20);
		$dbSecureKey->insert(array(
			'id' => null,
			'account_id' => 1,
			'key' => $key,
			'type' => KEY_CANCEL_JOB,
			'ref_id' => $jobId,
			'create_time' => $now,
			'status' => 1
		));
        $email_content = Core_Utils_Email::render('verify_job2.phtml', array(
        	'job_title' => $title,
        	'job_description' => Core_Utils_String::trim($description,500),
        	'link_view' => DOMAIN.Core_Utils_Tools::genJobUrl(array('title' => $title,'id' => $jobId)).'&ref=2',
        	'link_cancel' => DOMAIN.'/action/cancel-job?secure_key='.$key
		));
		//$email = DEV_EMAIL;
		Core_Utils_Log::log('Send EMAIL_SUBJECT_VERIFY_JOB to '.$email);
		$coreEmail = new Core_Email();
		$coreEmail->send($email, EMAIL_SUBJECT_VERIFY_JOB, $email_content,EMAIL_LOG);
	}
}
?>