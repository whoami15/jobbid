<?php

class Application_Model_DbTable_JobTitle extends Zend_Db_Table_Abstract
{

    protected $_name = 'job_title';
	public static function findAll() {
    	$db = Zend_Registry::get('connectDb');
    	$query = 'SELECT * FROM `job_title` WHERE `status` = 1';
    	$stmt = $db->prepare($query);
        $stmt->execute();
        $rows = $stmt->fetchAll();
        $stmt->closeCursor();
        $db->closeConnection();
        return $rows;
    }
	public static function findByKey($key) {
    	$db = Zend_Registry::get('connectDb');
    	$query = 'SELECT * FROM `job_title` WHERE `job_title` = ?';
    	$stmt = $db->prepare($query);
        $stmt->execute(array($key));
        $row = $stmt->fetch();
        $stmt->closeCursor();
        $db->closeConnection();
        return $row==false?null:$row;
    }
	public function save($titleName) {
    	if(($jobTitle = Application_Model_DbTable_JobTitle::findByKey($titleName)) == null) {
            return $this->insert(array(
            	'id' => null,
            	'job_title' => $titleName
            ));
         } else {
            return $jobTitle['id'];
         }
    }
}

