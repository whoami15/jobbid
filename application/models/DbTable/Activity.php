<?php

class Application_Model_DbTable_Activity extends Zend_Db_Table_Abstract
{
    protected $_name = 'activities';
    public static function insertActivity($action,$dataRef=null) {
    	$session = new Zend_Session_Namespace('session');
    	$data = array(
    		'visitor_id' => $session->visitor['id'],
    		'action' => $action,
    		'data_ref' => $dataRef
    	);
    	$db = Zend_Registry::get('connectDb');
    	$query = 'INSERT DELAYED INTO `activities`(`id`,`visitor_id`,`action`,`data_ref`,`create_time`) VALUES (null, :visitor_id, :action, :data_ref, now())';
    	$stmt = $db->prepare($query);
    	$stmt->execute($data);
    	$stmt->closeCursor();
    	$db->closeConnection();
    }
    public static function getNumActivity($action,$dataRef=null) {
    	if(Application_Model_DbTable_Lock::isLocked($action) == true) {
        	throw new Core_Exception('LOCK_ACTION');
        }
    	$session = new Zend_Session_Namespace('session');
    	$params = array(
    		'visitor_id' => $session->visitor['id'],
    		'action' => $action
    	);
    	$query = 'SELECT COUNT(*) as num FROM  `activities` WHERE `visitor_id` = :visitor_id AND `action` = :action';
    	if($dataRef != null) {
    		$query.=' AND `data_ref` = :data_ref';
    		$params['data_ref'] = $dataRef;
    	}
    	$db = Zend_Registry::get('connectDb');
    	$stmt = $db->prepare($query);
    	$stmt->execute($params);
    	$row = $stmt->fetch();
    	$stmt->closeCursor();
    	$db->closeConnection();
    	return $row['num'];
    }
    public static function insertLockedActivity($action,$dataRef=null) {
    	$session = new Zend_Session_Namespace('session');
    	$data = array(
    			'visitor_id' => $session->visitor['id'],
    			'action' => $action,
    			'data_ref' => $dataRef
    	);
    	$db = Zend_Registry::get('connectDb');
    	$query = 'INSERT DELAYED INTO `locked_activities`(`id`,`visitor_id`,`action`,`data_ref`,`create_time`) VALUES (null, :visitor_id, :action, :data_ref, now())';
    	$stmt = $db->prepare($query);
    	$stmt->execute($data);
    	$stmt->closeCursor();
    	$db->closeConnection();
    }
}

