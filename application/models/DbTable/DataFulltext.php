<?php

class Application_Model_DbTable_DataFulltext extends Zend_Db_Table_Abstract
{
    protected $_name = 'data_fulltext';
    public static function saveData($text,$job_id) {
    	$db = Zend_Registry::get('connectDb');
    	$query = 'SELECT * FROM `data_fulltext` WHERE `job_id` = ?';
    	$stmt = $db->prepare($query);
    	$stmt->execute(array($job_id));
    	$row = $stmt->fetch();
    	if($row == false) { //insert new\
    		Core_Utils_DB::insert('data_fulltext', array(
	    		'job_id' => $job_id,
	    		'txt' => $text,
	    		'flag' => 0
    		));
    		
    	} else { //update
    		Core_Utils_DB::update('data_fulltext', array('txt' => $text,'flag' => 0), array('job_id' => $job_id));
    	}
    	$stmt->closeCursor();
    	$db->closeConnection();
    }
  
}

