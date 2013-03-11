<?php

class Application_Model_DbTable_DataFulltext extends Zend_Db_Table_Abstract
{
    protected $_name = 'data_fulltext';
    public static function saveData($text,$job_id) {
    	$db = Zend_Registry::get('connectDb');
    	$query = 'SELECT id FROM `data_fulltext` WHERE `ref_id` = ?';
    	$stmt = $db->prepare($query);
    	$stmt->execute(array($job_id));
    	$row = $stmt->fetch();
    	$db2 = new Application_Model_DbTable_DataFulltext();
    	if($row == false) { //insert new\
    		$db2->insert(array(
    			'id' => null,
    			'txt' => $text,
    			'ref_id' => $job_id,
    			'time_update' => Core_Utils_Date::getCurrentDateSQL()		
    		));
    	} else { //update
    		$db2->update(array('txt' => $text,'time_update' => Core_Utils_Date::getCurrentDateSQL()), array('id = ?' => $row['id']));
    	}
    	$stmt->closeCursor();
    	$db->closeConnection();
    }
  
}

