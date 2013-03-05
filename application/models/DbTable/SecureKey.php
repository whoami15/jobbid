<?php

class Application_Model_DbTable_SecureKey extends Zend_Db_Table_Abstract
{

    protected $_name = 'secure_keys';
    public static function findByKey($key) {
    	$db = Zend_Registry::get('connectDb');
    	$query = 'SELECT * FROM `secure_keys` WHERE `key` = ? AND `status` =1';
    	$stmt = $db->prepare($query);
    	$stmt->execute(array($key));
    	$row = $stmt->fetch();
    	$stmt->closeCursor();
    	$db->closeConnection();
    	return $row==false?null:$row;
    }
    public static function removeSecureKey($id) {
    	$db = Zend_Registry::get('connectDb');
    	$query = 'UPDATE `secure_keys` SET `status` = 0 WHERE `id` = ?';
    	$stmt = $db->prepare($query);
    	$stmt->execute(array($id));
    	$stmt->closeCursor();
    	$db->closeConnection();
    }
    
}

