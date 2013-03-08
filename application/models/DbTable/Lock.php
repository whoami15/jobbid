<?php

class Application_Model_DbTable_Lock extends Zend_Db_Table_Abstract
{
    protected $_name = 'locks';
    public static function addLock($action) {
    	$session = new Zend_Session_Namespace('session');
    	if(!isset($session->logged)) return;
    	$db = new Application_Model_DbTable_Lock();
    	$db->insert(array(
    		'id' => null,
    		'account_id' => $session->logged['id'],
    		'lock_action' => $action,
    		'create_time' => Core_Utils_Date::getCurrentDateSQL(),
    		'status' => 1		
    	));    	
    	
    }
    public static function isLocked($action) {
    	$session = new Zend_Session_Namespace('session');
    	if(!isset($session->logged)) return;
    	$db = Zend_Registry::get('connectDb');
    	$query = 'SELECT count(*) as num FROM `locks` WHERE lock_action=? and account_id =? and `status` = 1';
    	$stmt = $db->prepare($query);
    	$stmt->execute(array($action,$session->logged['id']));
    	$row = $stmt->fetch();
    	$stmt->closeCursor();
    	$db->closeConnection();
    	return $row['num'] == 0?false:true;
    }
}

