<?php
class Core_Utils_Date
{	
	public static function getCurrentDateSQL() {
		return date('Y-m-d H:i:s');
	}
	public static function convertUnixToSqlDate($unixtime) {
		$date = new Zend_Date($unixtime);
		return $date->toString('Y-MM-dd HH:mm:ss');
	} 
	public static function displaySQLDate($sDate,$toFormat='dd/MM/Y HH:mm:ss') {
		$date = new Zend_Date($sDate,'Y-MM-dd HH:mm:ss');
		return $date->toString($toFormat);
	} 
}