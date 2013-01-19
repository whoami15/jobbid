<?php
class Core_Controller_Helper_NumberUtils
{
	public static function parseInt($str) {
		$s = '';
		$i = 0;
    	while(isset($str[$i])) {
    		$c = $str[$i];
    		if(is_numeric($c))
    			$s.=$c;
    		$i++;
    	}
    	return intval($s);
	}
     
}
?>