<?php

class Application_Model_DbTable_Tag extends Zend_Db_Table_Abstract
{
    protected $_name = 'tags';
    public static function findTagByJob($jobId) {
    	$cache = Core_Utils_Tools::loadCache(86400);
    	if(($array = $cache->load(CACHE_JOB_TAGS)) == null) {
    		$db = Zend_Registry::get('connectDb');
    		$query = 'SELECT `key`,`tag`,`job_id` FROM `tags` t0 LEFT JOIN `job_tags` t1 ON t0.id = t1.`tag_id` WHERE t0.status = 1 ORDER BY `relevancy` DESC';
    		$stmt = $db->prepare($query);
    		$stmt->execute();
    		$rows = $stmt->fetchAll();
    		$stmt->closeCursor();
    		$db->closeConnection();
    		foreach($rows as $row) {
    			if($row['job_id'] == null) continue;
    			if(isset($array[$row['job_id']]) && count($array[$row['job_id']]) >= 3 ) continue;
    			$array[$row['job_id']][] = array('key' => $row['key'],'tag' => $row['tag']);
    		}
    		$cache->save($array,CACHE_JOB_TAGS);
    	}
    	if(isset($array[$jobId])) {
    		return $array[$jobId];
    	}
    	return array();
    }
    public static function insertTag($tag,$priority = 0) {
    	$db = new Application_Model_DbTable_Tag();
    	$db->insert(array(
    		'id' => null,
    		'key' => Core_Utils_String::getSlug($tag),
    		'tag' => $tag,
    		'num_job' => $priority,
    		'status' => 1		
    	));    	
    }
 	public static function findByKey($key) {
    	$db = Zend_Registry::get('connectDb');
    	$query = 'SELECT * FROM `tags` WHERE status = 1 and `key` = ?';
    	$stmt = $db->prepare($query);
    	$stmt->execute(array($key));
    	$row = $stmt->fetch();
    	$stmt->closeCursor();
    	$db->closeConnection();
    	return $row==false?null:$row;
    }
    public static function findTopTag() {
    	$cache = Core_Utils_Tools::loadCache(3600);
    	if(($rows = $cache->load(CACHE_TOP_TAGS)) == null) {
    		$db = Zend_Registry::get('connectDb');
    		$query = 'SELECT * FROM `tags` ORDER BY `num_job` DESC LIMIT 1,10';
    		$stmt = $db->prepare($query);
    		$stmt->execute();
    		$rows = $stmt->fetchAll();
    		$stmt->closeCursor();
    		$db->closeConnection();
    		$cache->save($rows,CACHE_TOP_TAGS);
    	} 
    	return $rows;
    }
    public static function findAllTag() {
    	$cache = Core_Utils_Tools::loadCache(3600);
    	if(($rows = $cache->load(CACHE_ALL_TAGS)) == null) {
    		$db = Zend_Registry::get('connectDb');
    		$query = 'SELECT * FROM `tags` WHERE status = 1';
    		$stmt = $db->prepare($query);
    		$stmt->execute();
    		$rows = $stmt->fetchAll();
    		$stmt->closeCursor();
    		$db->closeConnection();
    		$cache->save($rows,CACHE_ALL_TAGS);
    	}
    	return $rows;
    }
	public static function getTagsCloud() {
    	$cache = Core_Utils_Tools::loadCache(3600);
    	if(($cloud = $cache->load(CACHE_TAGS_CLOUD)) == null) {
    		$db = Zend_Registry::get('connectDb');
    		$query = 'SELECT * FROM `tags` WHERE status = 1 ORDER BY `num_job` DESC';
    		$stmt = $db->prepare($query);
    		$stmt->execute();
    		$rows = $stmt->fetchAll();
    		$max = 0;
    		foreach($rows as $row) {
    			if($row['num_job'] > $max) $max = $row['num_job'];
    		}
    		$maxWeight = 50;
    		$tags = array();
    		foreach ($rows as $row) {
    			$weight = floor($row['num_job']/$max*$maxWeight);
    			$tags[] = array(
    				'title' => $row['tag'], 
    				'weight' => $weight,
		            'params' => array('url' => $row['key'])
    			);
    		}
    		$cloud = new Zend_Tag_Cloud(array(
		    	'tags' => $tags 
    		));
    		$stmt->closeCursor();
    		$db->closeConnection();
    		$cache->save($cloud,CACHE_TAGS_CLOUD);
    	}
    	return $cloud;
    }
  
}

