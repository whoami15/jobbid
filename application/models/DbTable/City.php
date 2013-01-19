<?php

class Application_Model_DbTable_City extends Zend_Db_Table_Abstract
{
    protected $_name = 'cities';
    public static function findAll() {
    	$db = Zend_Registry::get('connectDb');
    	$query = 'SELECT * FROM `cities` WHERE `status` = 1';
    	$stmt = $db->prepare($query);
        $stmt->execute();
        $rows = $stmt->fetchAll();
        $stmt->closeCursor();
        $db->closeConnection();
        return $rows;
    }
}

