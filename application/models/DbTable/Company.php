<?php

class Application_Model_DbTable_Company extends Zend_Db_Table_Abstract
{

    protected $_name = 'company';
	public static function findById($id) {
    	$db = Zend_Registry::get('connectDb');
    	$query = 'SELECT * FROM `company` WHERE `status` = 1 AND `id` = ?';
    	$stmt = $db->prepare($query);
        $stmt->execute(array($id));
        $row = $stmt->fetch();
        $stmt->closeCursor();
        $db->closeConnection();
        return $row==false?null:$row;
    }
	public static function suggest($keyword) {
    	$db = Zend_Registry::get('connectDb');
    	$query = 'SELECT id,`company` as label FROM `company` WHERE `company` LIKE ?';
    	$stmt = $db->prepare($query);
        $stmt->execute(array($keyword));
        $rows = $stmt->fetchAll();
        $stmt->closeCursor();
        $db->closeConnection();
        return $rows;
    }
    public static function findAll($page,&$totalResult) {
    	$db = Zend_Registry::get('connectDb');
    	$from = ($page - 1)*SEARCH_PAGE_SIZE;
    	$to = SEARCH_PAGE_SIZE;
    	$query = 'SELECT SQL_CALC_FOUND_ROWS `id`,`company`,`time_update`,`description` FROM `company` WHERE `status`= 1 ORDER BY `time_update` DESC limit '.$from.','.$to;
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
	public static function findByKey($key) {
    	$db = Zend_Registry::get('connectDb');
    	$query = 'SELECT * FROM `company` WHERE `company` = ?';
    	$stmt = $db->prepare($query);
        $stmt->execute(array($key));
        $row = $stmt->fetch();
        $stmt->closeCursor();
        $db->closeConnection();
        return $row==false?null:$row;
    }
    
    public function save($companyName) {
    	if(empty($companyName)) return null;
    	$now = Core_Utils_Date::getCurrentDateSQL();
    	if(($company = Application_Model_DbTable_Company::findByKey($companyName)) == null) {
            return $this->insert(array(
            	'id' => null,
            	'company' => $companyName,
            	'create_time' => $now,
            	'time_update' => $now
            ));
         } else {
         	Core_Utils_DB::update('company', array('time_update' => $now), array('id' => $company['id']));
            return $company['id'];
         }
    }
	public static function findNewCompanies() {
    	$cache = Core_Utils_Tools::loadCache(3600);
    	if(($rows = $cache->load(CACHE_NEW_COMPANY)) == null) {
    		$db = Zend_Registry::get('connectDb');
    		$query = 'SELECT `id`,`company` FROM `company` WHERE `status`= 1 AND `mapping_to` IS NULL ORDER BY `time_update` DESC LIMIT 0,10';
    		$stmt = $db->prepare($query);
    		$stmt->execute();
    		$rows = $stmt->fetchAll();
    		$stmt->closeCursor();
    		$db->closeConnection();
    		$cache->save($rows,CACHE_NEW_COMPANY);
    	} 
    	return $rows;
    }

}

