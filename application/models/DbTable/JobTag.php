<?php

class Application_Model_DbTable_JobTag extends Zend_Db_Table_Abstract
{
    protected $_name = 'job_tags';
    public static function findJobByTag($id) {
    	$db = Zend_Registry::get('connectDb');
    	$query = 'SELECT * FROM `job_tags` WHERE status = 1 and tag_id = ?';
    	$stmt = $db->prepare($query);
    	$stmt->execute(array($id));
    	$rows = $stmt->fetchAll();
    	$stmt->closeCursor();
    	$db->closeConnection();
    	return $rows;
    }
	
  
}

