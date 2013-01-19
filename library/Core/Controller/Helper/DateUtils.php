<?php
class Core_Controller_Helper_DateUtils
{
	public static function formatSQLDate($date,$format) {
		$date = new Zend_Date($date,'Y-M-d H:m:s');
    	return $date->toString($format);
	}
     
}
?>