<?php

class Application_Model_DbTable_Raovat extends Zend_Db_Table_Abstract
{

    protected $_name = 'raovats';
	public static function findAll($page,&$totalResult) {
    	$db = Zend_Registry::get('connectDb');
    	$from = ($page - 1)*SEARCH_PAGE_SIZE;
    	$to = SEARCH_PAGE_SIZE;
    	$query = 'SELECT SQL_CALC_FOUND_ROWS `id`,`tieude`,`noidung`,`ngayupdate` FROM `raovats` WHERE `status` = 1 ORDER BY `ngayupdate` DESC limit '.$from.','.$to;
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
}

