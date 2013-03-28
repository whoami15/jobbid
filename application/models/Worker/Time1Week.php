<?php

class Application_Model_Worker_Time1Week
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
		 
		 
	}
	public function start() {
		$date = new Zend_Date();
		$date->subWeek(1);
		$rows = Core_Utils_DB::query("SELECT t0.*,t1.`company` FROM `jobs` t0 LEFT JOIN `company` t1 ON t0.`company_id`=t1.`id` WHERE t0.`active` = 1 AND t0.`status` = 1 AND t0.`time_create` >= '{$date->toString('Y-MM-dd HH:mm:ss')}' ORDER BY `view` DESC LIMIT 0,10");
		$data = array();
		foreach ($rows as $row) {
			$data[] = array(
				'subject' => $row['title'],
				'content' => Core_Utils_Email::render('weekly.phtml', array(
        			'job_title' => $row['title'],
        			'job_description' => Core_Utils_String::trim($row['job_description'],200),
        			'link_view' => DOMAIN.Core_Utils_Tools::genJobUrl($row).'&ref=1',
        			'company' => $row['company']
				))
			);
		}
		$cache = Core_Utils_Tools::loadCache();
		$email_contents = $cache->load(CACHE_EMAIL_CONTENTS);
		$email_contents[EMAIL_WEEKLY] = $data;
		$cache->save($email_contents,CACHE_EMAIL_CONTENTS);
		$rows = Core_Utils_DB::query('SELECT * FROM `emails`');
		$array = array();
		foreach ($rows as $row) {
			$array[] = $row['email'];
		}
		$cache->save($array,EMAIL_WEEKLY.'_emails');
	}
}

