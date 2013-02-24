<?php

class Application_Model_DbTable_City extends Zend_Db_Table_Abstract
{
    protected $_name = 'cities';
	public static function findById($id) {
    	$db = Zend_Registry::get('connectDb');
    	$query = 'SELECT * FROM `cities` WHERE `status` = 1 AND `id` = ?';
    	$stmt = $db->prepare($query);
        $stmt->execute(array($id));
        $row = $stmt->fetch();
        $stmt->closeCursor();
        $db->closeConnection();
        return $row==false?null:$row;
    }
    public static function findAll() {
    	$db = Zend_Registry::get('connectDb');
    	$query = 'SELECT * FROM `cities` WHERE `status` = 1 order by stt';
    	$stmt = $db->prepare($query);
        $stmt->execute();
        $rows = $stmt->fetchAll();
        $stmt->closeCursor();
        $db->closeConnection();
        return $rows;
    }
}

