<?php

class Application_Model_DbTable_Prohibition extends Zend_Db_Table_Abstract
{
    protected $_name = 'prohibitions';
    public static function addWords($word,$level = 1) {
    	$db = new Application_Model_DbTable_Prohibition();
    	return $db->insert(array(
    		'id' => null,
    		'words' => $word,
    		'level' => $level,
    		'status' => 1		
    	));    	
    	
    }
    public static function getProhibitionWords() {
    	$db = Zend_Registry::get('connectDb');
    	$query = 'SELECT * FROM `prohibitions` WHERE `status` = 1';
    	$stmt = $db->prepare($query);
    	$stmt->execute();
    	$rows = $stmt->fetchAll();
    	$stmt->closeCursor();
    	$db->closeConnection();
    	return $rows;
    }
}

