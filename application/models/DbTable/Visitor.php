<?php

class Application_Model_DbTable_Visitor extends Zend_Db_Table_Abstract
{

    protected $_name = 'visitors';
    public static function getVisitor($loggedInfo) {
    	$uid = isset($loggedInfo)?$loggedInfo['id']:null;
    	$IpAddress = Core_Utils_Tools::getIPClient();
    	$date = new Zend_Date();
    	$date->subMinute(TIME_CREATE_NEW_VISITOR);
    	$query = 'SELECT * FROM `visitors` WHERE `ip_address`=? AND `last_time` >= ?';
    	$db = Zend_Registry::get('connectDb');
    	$stmt = $db->prepare($query);
    	$stmt->execute(array($IpAddress,$date->toString(TIME_FORMAT_SQL)));
    	$row = $stmt->fetch();
    	$now = Core_Utils_Date::getCurrentDateSQL();
    	if($row == false) {
    		$row = array(
    			'id' => null,
    			'ip_address' => $IpAddress,
    			'first_time' => $now,
    			'last_time' => $now,
    			'account_id' => $uid
    		);
    		$dbVisitor = new Application_Model_DbTable_Visitor();
    		$id = $dbVisitor->insert($row);
    		$row['id'] = $id;
    	} else {
    		$query = 'UPDATE LOW_PRIORITY IGNORE `visitors` SET `last_time` = ?,`account_id` = ? WHERE `id` = ?';
    		$stmt = $db->prepare($query);
    		$stmt->execute(array($now,$uid,$row['id']));
    	}
    	$stmt->closeCursor();
    	$db->closeConnection();
    	return $row;
    }
}

