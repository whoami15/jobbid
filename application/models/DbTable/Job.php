<?php

class Application_Model_DbTable_Job extends Zend_Db_Table_Abstract
{

    protected $_name = 'jobs';
	public static function findAll($data,$page) {
    	$db = Zend_Registry::get('connectDb');
    	$sWhere = 't0.`status` = 1';
    	$params = array();
    	if(!empty($data['city_id'])) {
    		$sWhere.=' AND t2.id = :city_id ';
    		$params['city_id'] = $data['city_id'];
    	}
    	if(!empty($data['keyword'])) {
    		$sWhere.= ' AND t0.title like :keyword';
    		$params['keyword'] = '%'.$data['keyword'].'%';
    	}
    	$query = 'SELECT t0.*,t1.`company`,t2.`name_city` FROM `jobs` t0 LEFT JOIN `company` t1 ON t0.`company_id` = t1.`id` LEFT JOIN `cities` t2 ON t0.`city_id` = t2.`id` WHERE '.$sWhere.' ORDER BY t0.`time_update` DESC';
    	$stmt = $db->prepare($query);
        $stmt->execute($params);
        $rows = $stmt->fetchAll();
        $stmt->closeCursor();
        $db->closeConnection();
        return $rows;
    } 

}

