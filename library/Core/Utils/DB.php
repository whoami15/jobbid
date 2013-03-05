<?php
class Core_Utils_DB
{	
	public static function update($tableName,$data,$where) {
    	if(empty($data)) return;
    	$arraySet = array();
    	$params = array();
    	foreach ($data as $key => $value) {
    		$arraySet[]=" `$key` = :$key ";
    		$params[$key] = $value;
    	}
    	$sWhere = ' 1 = 1 ';
    	foreach ($where as $key => $value) {
    		$sWhere.=" AND `$key` = $value";
    	}
    	$query = 'UPDATE `'.$tableName.'` SET '.join(',', $arraySet).' WHERE '.$sWhere;
    	$db = Zend_Registry::get('connectDb');
    	$stmt = $db->prepare($query);
    	$stmt->execute($params);
    	$stmt->closeCursor();
    	$db->closeConnection();
    } 
}