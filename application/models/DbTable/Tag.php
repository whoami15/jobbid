<?php

class Application_Model_DbTable_Tag extends Zend_Db_Table_Abstract
{
    protected $_name = 'tags';
    public static function insertTag($tag,$priority = 0) {
    	$db = new Application_Model_DbTable_Tag();
    	$db->insert(array(
    		'id' => null,
    		'tag' => $tag,
    		'priority' => $priority,
    		'status' => 1		
    	));    	
    }
    
    public static function findTopTag() {
    	$cache = Core_Utils_Tools::loadCache(86400);
    	if(($rows = $cache->load(CACHE_TOP_TAGS)) == null) {
    		$db = Zend_Registry::get('connectDb');
    		$query = 'SELECT * FROM `tags` ORDER BY `priority` DESC LIMIT 1,10';
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
    	$cache = Core_Utils_Tools::loadCache(86400);
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
  
}

