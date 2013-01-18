<?php
class Core_Utils_NumberUtil
{	
	public static function parseInt($string) {
		$length = strlen($string);
		$str = '';
		for($i = 0; $i<$length;$i++) {
			if(is_numeric($string[$i])) {
				$str.=$string[$i];
			}
		}
		return intval($str);
	}
}