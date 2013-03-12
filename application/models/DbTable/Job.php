<?php

class Application_Model_DbTable_Job extends Zend_Db_Table_Abstract
{

    protected $_name = 'jobs';
	public static function findAll($data,$page,&$totalResult) {
    	$db = Zend_Registry::get('connectDb');
    	$sWhere = 't0.active = 1 and t0.`status` = 1 AND `num_report` < :num_report ';
    	$params = array('num_report' => LIMIT_REPORT);
    	if(!empty($data['city_id'])) {
    		$sWhere.=' AND t2.id = :city_id ';
    		$params['city_id'] = $data['city_id'];
    	}
		if(!empty($data['company_id'])) {
    		$sWhere.=' AND t0.company_id = :company_id ';
    		$params['company_id'] = $data['company_id'];
    	}
		if(!empty($data['position_id'])) {
    		$sWhere.=' AND t0.job_title_id = :job_title_id ';
    		$params['job_title_id'] = $data['position_id'];
    	}
    	if(!empty($data['keyword'])) {
    		$sWhere.= ' AND t0.title like :keyword';
    		$params['keyword'] = '%'.$data['keyword'].'%';
    	}
		if(!empty($data['ids'])) {
    		$sWhere.= ' AND t0.id IN ('.join(',', $data['ids']).')';
    	}
    	$from = ($page - 1)*SEARCH_PAGE_SIZE;
    	$to = SEARCH_PAGE_SIZE;
    	$query = 'SELECT SQL_CALC_FOUND_ROWS t0.*,t1.`company`,t2.`name_city` FROM `jobs` t0 LEFT JOIN `company` t1 ON t0.`company_id` = t1.`id` LEFT JOIN `cities` t2 ON t0.`city_id` = t2.`id` LEFT JOIN `job_title` t3 ON t0.`job_title_id` = t3.`id` WHERE '.$sWhere.' ORDER BY t0.`time_update` DESC limit '.$from.','.$to;
    	$stmt = $db->prepare($query);
        $stmt->execute($params);
        $rows = $stmt->fetchAll();
        $query = 'SELECT FOUND_ROWS() as total';
        $stmt = $db->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch();
        $totalResult = $row['total'];
        $stmt->closeCursor();
        $db->closeConnection();
        return $rows;
    } 
    public static function findById($jobId) {
    	$db = Zend_Registry::get('connectDb');
    	$query = 'SELECT t0.*,`company`,`job_title`,`name_city` FROM `jobs` t0 
LEFT JOIN `company` t1 ON t0.`company_id` = t1.`id`
LEFT JOIN `job_title` t2 ON t0.`job_title_id` = t2.`id`
LEFT JOIN `cities` t3 ON t0.`city_id` = t3.`id`
WHERE t0.active = 1 and  t0.`status` = 1 AND t0.`id` = ? AND `num_report` < ?';
    	$stmt = $db->prepare($query);
        $stmt->execute(array($jobId,LIMIT_REPORT));
        $row = $stmt->fetch();
        $stmt->closeCursor();
        $db->closeConnection();
        return $row==false?null:$row;
    }
    public static function getSimilarJob($job) {
    	$db = Zend_Registry::get('connectDb');
    	$result = array();
    	$query = 'SELECT `id`,`title`,`time_update` FROM `jobs` WHERE id!=? and active = 1  and `status` = 1 AND `job_title_id` = ?  AND `num_report` < ? ORDER BY `time_update` DESC LIMIT 0,5';
    	$stmt = $db->prepare($query);
        $stmt->execute(array($job['id'],$job['job_title_id'],LIMIT_REPORT));
        $result = $stmt->fetchAll();
        $len = count($result);
        if($len < 5) {
        	$query = 'SELECT `id`,`title`,`time_update` FROM `jobs` WHERE id!=? and active = 1 and  `status` = 1 AND `company_id` = ?  AND `num_report` < ? ORDER BY `time_update` DESC LIMIT 0,'.(5 - $len);
    		$stmt = $db->prepare($query);
        	$stmt->execute(array($job['id'],$job['company_id'],LIMIT_REPORT));
        	$rows = $stmt->fetchAll();
        	$result = array_merge($result,$rows);
        }
        $stmt->closeCursor();
        $db->closeConnection();
        return $result;
    }
    public static function doReport($jobId,$visitor) {
    	$db = Zend_Registry::get('connectDb');
    	$now = Core_Utils_Date::getCurrentDateSQL();
    	$query = 'SELECT COUNT(*) as num FROM  `activities` WHERE `visitor_id` = ? AND `action` = ? AND `data_ref` = ?';
    	$stmt = $db->prepare($query);
    	$stmt->execute(array($visitor['id'],ACTION_REPORT_JOB,$jobId));
    	$row = $stmt->fetch();
    	$flag = false;
    	if($row['num'] == 0) { //user chua report job trong session hien tai
    		if(Core_Utils_Tools::isAdmin()) { //gap admin thi tat dai ngay!
    			Core_Utils_DB::update('jobs', array('status' => 0), array('id' => $jobId));
    		} else {
    			Core_Utils_DB::update('jobs', array('num_report' => '`num_report` + 1'), array('id' => $jobId));
    		}
    		Application_Model_DbTable_Activity::insertActivity(ACTION_REPORT_JOB,$jobId);
    		$flag = true;
    	}
    	$stmt->closeCursor();
    	$db->closeConnection();
    	return $flag;
    }
    public static function findChanges() {
    	$db = Zend_Registry::get('connectDb');
    	$date = new Zend_Date();
    	$date->subDay(1);
    	$query = 'SELECT * FROM `jobs` WHERE active = 1  and `status` = 1 and `time_update` >= ?';
    	$stmt = $db->prepare($query);
    	$stmt->execute(array($date->toString('Y-M-d H:m:s')));
    	$rows = $stmt->fetchAll();
    	$stmt->closeCursor();
    	$db->closeConnection();
    	return $rows;
    }
	public static function findJobsByUser($uid) {
    	$db = Zend_Registry::get('connectDb');
    	$query = 'SELECT `id`,`title`,`account_id`,`time_update` FROM `jobs` WHERE active = 1  and `status` = 1 and `account_id` = ? order by `time_update` desc';
    	$stmt = $db->prepare($query);
    	$stmt->execute(array($uid));
    	$rows = $stmt->fetchAll();
    	$stmt->closeCursor();
    	$db->closeConnection();
    	return $rows;
    }
}

