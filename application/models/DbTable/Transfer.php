<?php

class Application_Model_DbTable_Transfer extends Zend_Db_Table_Abstract
{
    //protected $_name = '';
    
    public static function findAllDuan() {
    	$query = 'SELECT `id`,`tenduan` FROM `_duans` WHERE `active` =1 AND `approve` = 1';
    	$db = Zend_Registry::get('connectDb');
    	$stmt = $db->prepare($query);
    	$stmt->execute();
    	$rows = $stmt->fetchAll();
    	$stmt->closeCursor();
    	$db->closeConnection();
    	return $rows;
    }
    public static function readDuan($id) {
    	$query = 'SELECT `id`,`tenduan`,`account_id`,`thongtinchitiet`,`tinh_id`,`duan_email`,`duan_sodienthoai`,`ngaypost`,`timeupdate`,`views` FROM `_duans` WHERE `id` = ?';
    	$db = Zend_Registry::get('connectDb');
    	$stmt = $db->prepare($query);
    	$stmt->execute(array($id));
    	$row = $stmt->fetch();
    	$stmt->closeCursor();
    	$db->closeConnection();
    	return $row==false?null:$row;
    }
    
}

