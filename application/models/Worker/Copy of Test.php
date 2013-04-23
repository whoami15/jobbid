<?php

class Application_Model_Worker_Test 
{
	protected static $_instance = null;
	var $_header;
	var $_cUrl;
	public static function getInstance($className=__CLASS__){
		//Check instance
		if(empty(self::$_instance)){
			self::$_instance = new $className;
		}
		//Return instance
		return self::$_instance;
	}
	public function __construct(){
		$this->_cUrl = new Core_Dom_Curl(array(
				'method' => 'GET',
				'header' => array(
						'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
						'Accept-Encoding: gzip, deflate',
						'Accept-Language: en-US,en;q=0.5',
						'Connection: keep-alive',
						'DNT: 1',
						'User-Agent: Mozilla/5.0 (Windows NT 6.1; WOW64; rv:19.0) Gecko/20100101 Firefox/19.0',
						'X-Requested-With: 	XMLHttpRequest',
						'Cookie: __utma=259897482.1689604994.1351605073.1366299993.1366340806.53; __utmz=259897482.1366198743.50.6.utmcsr=facebookad|utmccn=pro_tangtientrieu_thang04|utmcmd=PromoP|utmctr=Fans_Friend_123vn|utmcct=tang-tien-trieu; __utmv=259897482.|1=User%20ID=thanhphuong7486=1; __atuvc=0%7C12%2C0%7C13%2C0%7C14%2C0%7C15%2C16%7C16; __utmx=259897482.YNCbXckDSTOh7MhnaRUGCQ$54197633-8:1; __utmxx=259897482.YNCbXckDSTOh7MhnaRUGCQ$54197633-8:1358337355:15552000; s3=1360132972; banner_footer_count=19; zingid=1366125523_128; __atssc=facebook%3B1; PHPSESSID=uu95rnj0ic5782lcf5hn0l5363; __utmb=259897482.17.9.1366341461284; __utmc=259897482; uin=213504237; acn=thanhphuong7486; vngauth=AAEMWdq0cFHt0LkMAAAAAGGgMHA%3D; s1=1366341418; s2=11a4511a49a0d221ea07d7a460c49371'
				)
		));
		 
	}
	public function start() {
		//echo Core_Utils_String::getSlug('Hà Nội');die;
		$url = 'http://123.vn/tang-tien-trieu.html';
		$content = $this->_cUrl->getContent($url);
		//Core_Utils_Log::write($content);die('OK');
		$doc = Core_Dom_Query::newDocumentHTML($content,'UTF-8');
		$doc->find("#frm_lucky")->submit('success1');
		die('OK');
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
					$value = trim($tds->get(1)->textContent);
				}
				
				$array[$key] = $value;
			} catch (Exception $e) {
			}
		}
		//print_r($array['mo-ta-cong-viec']);die;
		$email = Core_Utils_Array::getValue($array,'email-lien-he');
		if(empty($email)) die('EMPTY_EMAIL');
		
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
		$companyId = null;
		if(!empty($company)) {
			$modelCompany = new Application_Model_DbTable_Company();
        	$companyId = $modelCompany->save($company);
		}
        $modelJob = new Application_Model_DbTable_Job();
        $now = Core_Utils_Date::getCurrentDateSQL();
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
        		'active' => 1
        ));
        die('OK');
		unset($array['Mô tả công việc:']);
		foreach ($array as $key => $value) {
			$description.= $key.' '.$value.PHP_EOL;
		}
		print_r($array);die;
		$info =  trim($doc->find('tbInfo-row br-L')->text());
		print_r($doc->find('.TTTD-ten')->text());
		die;
		
		$parts = parse_url($url);
		print_r($parts);die;
		$validate = new Zend_Validate_EmailAddress();
		if($validate->isValid($str)) {
			echo 'valid';
		} else {
			echo 'invalid';
		}
		die;
		$str = strip_tags($str);
		echo $str;die;
		$array = array('1','4','3','5');
		$array1 = array_splice($array, 0,8);
		print_r($array1);
		print_r($array);
		die;
		/*$rows = Core_Utils_DB::query('SELECT * FROM `emails_`');
		$ids = array();
		$array = array();
		foreach ($rows as $row) {
			$array[] = trim($row['email']);
		}
		$query = 'INSERT DELAYED INTO `emails`(`email`) VALUES (?)';
		$db = Zend_Registry::get('connectDb');
    	$stmt = $db->prepare($query);
    	$i = 0;
		foreach ($array as $email) {
			$i++;
			if($i % 100 == 0) echo $i.PHP_EOL;
			$stmt->execute(array($email)); 
		}
		$stmt->closeCursor();
    	$db->closeConnection();*/
		$rows = Core_Utils_DB::query('SELECT *  FROM `emails`
GROUP BY email
HAVING COUNT(*) > 1');
		$ids = array();
		foreach ($rows as $row) {
			echo 'Delete email '.$row['email'].PHP_EOL;
			$ids[] = $row['id'];
		}
		if(!empty($ids)) {
			Core_Utils_DB::query('DELETE FROM `emails` WHERE `id` IN ('.join(',',$ids).')',3);
		}
		die;
		$client = new Zend_Http_Client('https://ajax.googleapis.com/ajax/services/search/web?v=1.0&q=cong%20viec%20ban%20thoi%20gian&start=1');
		$response = $client->request();
		$response = json_decode($response->getBody());
		print_r($response);die;
		/*$ta
		$from = strtotime('2013-03-01');
		$end = strtotime('2013-03-02');
		echo $end - $from;
		die;*/
		/* $rows = Core_Utils_DB::query('SELECT * FROM `_accounts`');
		foreach($rows as $row) {
			Core_Utils_DB::insert('accounts', $row);
		}
		die;  */
		$url ='http://localhost/jobbid/transfer/list';
		$content = $this->_cUrl->getContent($url);
		$doc = Core_Dom_Query::newDocumentHTML($content,'UTF-8');
		$modelJobTitle = new Application_Model_DbTable_JobTitle();
		$modelJob = new Application_Model_DbTable_Job();
		$now = Core_Utils_Date::getCurrentDateSQL();
		foreach ($doc['ul > li > a'] as $a) {
			$url = 'http://localhost'.$a->getAttribute('href');
			//Core_Utils_Tools::log($url);die;
			$content = $this->_cUrl->getContent($url);
			Core_Dom_Query::cleanup();
			$doc = Core_Dom_Query::newDocumentHTML($content,'UTF-8');
			$data = array();
			foreach($doc['ul > li'] as $li2) {
				$data[$li2->getAttribute('id')] = trim($li2->textContent);
			}
			Core_Utils_DB::insert('raovats', array(
				'id' => $data['id'],
				'tieude' => $data['tieude'],
				'noidung' => $data['noidung'],
				'ngaypost' => $data['ngaypost'],
				'ngayupdate' => $data['ngayupdate'],
				'views' => $data['views'],
				'account_id' => $data['account_id'],
				'status' => 1
			));
			/*Core_Utils_DB::insert('articles', array(
				'id' => $data['id'],
				'title' => $data['title'],
				'imagedes' => $data['imagedes'],
				'content' => $data['content'],
				'datemodified' => $data['datemodified'],
				'usermodified' => $data['usermodified'],
				'viewcount' => $data['viewcount'],
				'active' => $data['active']
			));*/
			//$jobTitleId = $modelJobTitle->save($data['tenduan']);
			/*$jobId = $modelJob->insert(array(
					'id' => null,
					'title' => $data['tenduan'],
					'account_id' => $data['account_id'],
					'company_id' => null,
					'job_title_id' => null,
					'job_description' => $data['thongtinchitiet'],
					'city_id' => $data['tinh_id'],
					'email_to' => $data['duan_email'],
					'job_type' => 1,
					'view' => $data['views'],
					'time_create' => $data['ngaypost'],
					'time_update' => $data['timeupdate'],
					'sec_id' => '',
					'status' => 1,
					'active' => 1
			));
			Core_Utils_DB::insert('mapping', array(
				'id1' => $data['id'],
				'id2' => $jobId,
				'type' => 1
			));*/
			//print_r($data);die;
			//Core_Utils_Tools::log($li->textContent);
		}
		die;
		
		die;
		$tags = Application_Model_DbTable_Tag::findAllTag();
		foreach($tags as $tag) {
			$key = Core_Utils_String::getSlug($tag['tag']);
			if(Application_Model_DbTable_Tag::findByKey($key) == null) {
				Core_Utils_DB::update('tags', array('key' => $key), array('id' => $tag['id']));
			}
			
		}
		die;
		$str = array();
		foreach($tags as $index => $tag ) {
			$str[] = "MATCH(t0.`txt`) AGAINST('{$tag['tag']}') AS r$index";
		}
		$str = join(',', $str);
    	$query = "SELECT $str FROM `data_fulltext` t0,`tags` t1
WHERE t0.`ref_id`=12";
    	$db = Zend_Registry::get('connectDb');
    	$stmt = $db->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch();
        $stmt->closeCursor();
        $db->closeConnection();
        $array = array();
        foreach($row as $key => $value) {
        	$key = str_replace('r', '', $key);
        	if($value > 1)
        		$array[$key] = $value;
        }
        asort($array,SORT_NUMERIC);
        $len = count($array);
        $array = array_slice($array, $len-10,10,true);
        foreach($array as $key => $value) {
        	$str = Core_Utils_String::toUnUnicode($tags[$key]['tag'].' : '.$value);
        	echo $str.PHP_EOL;
        }
       // print_r($array);
	}
}

