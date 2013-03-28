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
		$email_contents = $cache->load(CACHE_EMAIL_CONTENTS);
		if($email_contents != null && !empty($email_contents)) {
			foreach ($email_contents as $type => $contents) {
				$emails = $cache->load($type.'_emails');
				if($emails == null || empty($emails)) {
					unset($email_contents[$type]);
					continue;
				}
				$rand_key = array_rand($contents);
				$content = $contents[$rand_key];
				$receivers = array_splice($emails, 0,100);
				$cache->save($emails,$type.'_emails');
				$coreEmail = new Core_Email();
				$coreEmail->send($receivers, $content['subject'], $content['content']);
				
			}
			$cache->save($email_contents,CACHE_EMAIL_CONTENTS);
		}
	}
}