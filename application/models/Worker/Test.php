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
						'X-Requested-With: 	XMLHttpRequest'
				)
		));
		 
	}
	public function start() {
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

