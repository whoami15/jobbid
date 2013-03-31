<?php
class Core_Utils_Job
{	
	
	public static function updateFulltextData() {
		$jobs = Application_Model_DbTable_Job::findChanges();
		foreach($jobs as $job) {
			$text = $job['title'].' '.$job['job_description'];
			/* Core_Utils_DB::insert('data_fulltext', array(
			 'job_id' => $job['id'],
					'txt' => $text,
					'flag' => 0
			)); */
			Application_Model_DbTable_DataFulltext::saveData($text, $job['id']);
		}
	}
	public static function updateTags() {
		$tags = Application_Model_DbTable_Tag::findAllTag();
		$str = array();
		foreach($tags as $index => $tag ) {
			$str[] = "MATCH(t0.`txt`) AGAINST('{$tag['tag']}') AS r$index";
		}
		$str = join(',', $str);
		$query = "SELECT $str FROM `data_fulltext` t0,`tags` t1 WHERE t0.`job_id`=?";
		$rows = Core_Utils_DB::query('SELECT * FROM `data_fulltext` WHERE `flag` = 0');
		$db = Zend_Registry::get('connectDb');
		$stmt = $db->prepare($query);
		$jobIds = array();
		foreach($rows as $row) {
			$job_id = $row['job_id'];
			$jobIds[] = $job_id;
			$stmt->execute(array($job_id));
			$row = $stmt->fetch();
			$array = array();
			foreach($row as $key => $value) {
				$key = str_replace('r', '', $key);
				if($value > 1)
					$array[$key] = $value;
			}
			asort($array,SORT_NUMERIC);
			$len = count($array);
			$array = array_slice($array, $len-10,10,true);
			Core_Utils_DB::query('DELETE FROM `job_tags` WHERE `job_id` = ?',3,array($job_id));
			foreach($array as $key => $value) {
				Core_Utils_DB::insert('job_tags', array(
					'job_id' => $job_id,
					'tag_id' => $tags[$key]['id'],
					'relevancy' => $value
				));
				//$str = Core_Utils_String::toUnUnicode($tags[$key]['tag'].' : '.$value);
				//echo $str.PHP_EOL;
			}
		}
		$query = 'UPDATE `data_fulltext` SET `flag` = 1 WHERE `job_id` IN ('.join(',', $jobIds).')';
		Core_Utils_DB::query($query,3);
		$stmt->closeCursor();
		$db->closeConnection();
		$rows = Core_Utils_DB::query('SELECT `tag_id`, COUNT(*) AS num_job FROM `job_tags` GROUP BY `tag_id`');
		foreach($rows as $row) {
			Core_Utils_DB::update('tags', array('num_job' => $row['num_job']), array('id' => $row['tag_id']));
		}
	}
	
	public static function removeExpriedSecureKeys() {
		$date = new Zend_Date();
		$date->subDay(3);
		Core_Utils_DB::query('UPDATE `secure_keys` SET `status` = 0  WHERE `create_time` <= ? AND `type` = 3',3,array($date->toString('Y-MM-dd HH:mm:ss')));
	}
	public static function sendEmails() {
		$cache = Core_Utils_Tools::loadCache();
		$emails = $cache->load(CACHE_MAILIST);
		if(empty($emails)) return;
		$receivers = array_splice($emails, 0,100);
		//$receivers = DEV_EMAIL;
		$cache->save($emails,CACHE_MAILIST);
		$email_contents = $cache->load(CACHE_EMAIL_CONTENTS);
		if($email_contents != null && !empty($email_contents)) {
			$coreEmail = new Core_Email();
			foreach ($email_contents as $type => $contents) {
				$rand_key = array_rand($contents);
				$content = $contents[$rand_key];
				$coreEmail->send($receivers, $content['subject'], $content['content']);
			}
		}
	}
	public static function newJobsDaily() {
		$date = new Zend_Date();
		$date->subDay(1);
		$query = "SELECT t0.*,t1.`company` FROM `jobs` t0 LEFT JOIN `company` t1 ON t0.`company_id`=t1.`id` WHERE t0.`active` = 1 AND t0.`status` = 1 AND t0.account_id=1 AND t0.`time_create` >= '{$date->toString('Y-MM-dd HH:mm:ss')}' ORDER BY `view` DESC LIMIT 0,10";
		$rows = Core_Utils_DB::query($query);
		if(empty($rows)) {
			$query = 'SELECT t0.*,t1.`company` FROM `jobs` t0 LEFT JOIN `company` t1 ON t0.`company_id`=t1.`id` WHERE t0.`active` = 1 AND t0.`status` = 1
ORDER BY `time_create` DESC,`view` DESC LIMIT 0,10';
			$rows = Core_Utils_DB::query($query);
		}
		$orther = array();
		foreach ($rows as $row) {
			$orther[] = array(
				'link' => DOMAIN.Core_Utils_Tools::genJobUrl($row).'&ref=1',
				'title' => $row['title']
			);
		}
		$data = array();
		foreach ($rows as $row) {
			$data[] = array(
				'subject' => $row['title'],
				'content' => Core_Utils_Email::render('weekly.phtml', array(
        			'job_title' => $row['title'],
        			'job_description' => Core_Utils_String::trim($row['job_description'],200),
        			'link_view' => DOMAIN.Core_Utils_Tools::genJobUrl($row).'&ref=1',
        			'company' => $row['company'],
					'orther' => $orther
				))
			);
		}
		$cache = Core_Utils_Tools::loadCache();
		$email_contents = $cache->load(CACHE_EMAIL_CONTENTS);
		$email_contents[EMAIL_WEEKLY] = $data;
		$cache->save($email_contents,CACHE_EMAIL_CONTENTS);
	}
	
	public static function grabContent() {
		Core_Utils_Log::log('BEGIN grabContent');
		$rows = Core_Utils_DB::query('SELECT * FROM `links` WHERE `status` = 1');
		foreach ($rows as $row) {
			try {
				Core_Utils_Log::log('Grab link '.$row['url'].'...');
    			$grabber = new $row['class_name']($row);
    			$grabber->doGrab();
    		} catch (Exception $e) {
    			//Core_Utils_Log::log($e->getMessage());
    			Core_Utils_Log::error($e);
    		}
		}
		Core_Utils_Log::log('END grabContent');
	}
	public static function autoUpdateJob($num) {
		$hour = date('H');
		if($hour > 1 && $hour < 9) return;
		$date = new Zend_Date();
		$date->subWeek(1);
		$rows = Core_Utils_DB::query("SELECT id FROM `jobs` WHERE `active` =1 AND `status` = 1 AND `account_id` = 1 AND `time_create` >= '{$date->toString('Y-MM-dd HH:mm:ss')}' ORDER BY RAND() LIMIT 0,".$num);
		$ids = array();
		foreach ($rows as $row) {
			$ids[] = $row['id'];
		}
		Core_Utils_DB::query('UPDATE `jobs` SET `time_update` = ? WHERE `id` IN ('.join(',',$ids).')',3,array(Core_Utils_Date::getCurrentDateSQL()));
	}
	
 	public static function getLink() {
    	$rows = Core_Utils_DB::query('SELECT * FROM `sources` WHERE `status` = 1');
    	foreach ($rows as $row) {
    		try {
    			$grabber = new $row['class_name']($row);
				$grabber->getLink();
    		} catch (Exception $e) {
    			Core_Utils_Log::error($e);
    		}
    	}
    }
}