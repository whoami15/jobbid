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
	public static function findAll() {
    	$db = Zend_Registry::get('connectDb');
    	$query = 'SELECT * FROM `company` WHERE `status` = 1';
    	$stmt = $db->prepare($query);
        $stmt->execute();
        $rows = $stmt->fetchAll();
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
    	if(($company = Application_Model_DbTable_Company::findByKey($companyName)) == null) {
            return $this->insert(array(
            	'id' => null,
            	'company' => $companyName
            ));
         } else {
            return $company['id'];
         }
    }

}

