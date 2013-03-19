<?php

class Application_Model_DbTable_Article extends Zend_Db_Table_Abstract
{

    protected $_name = 'articles';
	public static function findAll($page,&$totalResult) {
    	$db = Zend_Registry::get('connectDb');
    	$from = ($page - 1)*SEARCH_PAGE_SIZE;
    	$to = SEARCH_PAGE_SIZE;
    	$query = 'SELECT SQL_CALC_FOUND_ROWS `id`,`title`,content,datemodified FROM `articles` WHERE `active` = 1 ORDER BY `datemodified` DESC limit '.$from.','.$to;
    	$stmt = $db->prepare($query);
        $stmt->execute();
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
	public static function findTopNews() {
    	$cache = Core_Utils_Tools::loadCache(3600);
    	if(($rows = $cache->load(CACHE_TOP_NEWS)) == null) {
    		$db = Zend_Registry::get('connectDb');
    		$query = 'SELECT `id`,`title` FROM `articles` ORDER BY `datemodified` DESC LIMIT 1,10';
    		$stmt = $db->prepare($query);
    		$stmt->execute();
    		$rows = $stmt->fetchAll();
    		$stmt->closeCursor();
    		$db->closeConnection();
    		$cache->save($rows,CACHE_TOP_NEWS);
    	} 
    	return $rows;
    }
    
}

