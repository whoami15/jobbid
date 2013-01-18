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
}