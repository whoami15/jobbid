<?php
class Core_Utils_Tools
{	
	public static function getCurrentDateSQL() {
		return date('Y-m-d H:i:s');
	}
	public static function toUnUnicode($string) {
		$pattern = array("a" => "á|à|ạ|ả|ã|Á|À|Ạ|Ả|Ã|ă|ắ|ằ|ặ|ẳ|ẵ|Ă|Ắ|Ằ|Ặ|Ẳ|Ẵ|â|ấ|ầ|ậ|ẩ|ẫ|Â|Ấ|Ầ|Ậ|Ẩ|Ẫ", "o" => "ó|ò|ọ|ỏ|õ|Ó|Ò|Ọ|Ỏ|Õ|ô|ố|ồ|ộ|ổ|ỗ|Ô|Ố|Ồ|Ộ|Ổ|Ỗ|ơ|ớ|ờ|ợ|ở|ỡ|Ơ|Ớ|Ờ|Ợ|Ở|Ỡ", "e" =>
				"é|è|ẹ|ẻ|ẽ|É|È|Ẹ|Ẻ|Ẽ|ê|ế|ề|ệ|ể|ễ|Ê|Ế|Ề|Ệ|Ể|Ễ", "u" => "ú|ù|ụ|ủ|ũ|Ú|Ù|Ụ|Ủ|Ũ|ư|ứ|ừ|ự|ử|ữ|Ư|Ứ|Ừ|Ự|Ử|Ữ", "i" => "í|ì|ị|ỉ|ĩ|Í|Ì|Ị|Ỉ|Ĩ", "y" => "ý|ỳ|ỵ|ỷ|ỹ|Ý|Ỳ|Ỵ|Ỷ|Ỹ", "d" => "đ|Đ", "c" => "ç", );
		$i = 0;
		while ((list($key, $value) = each($pattern)) != null)
		{
			$i++;
			if($i>=5000) break;
			$string = preg_replace('/' . $value . '/i', $key, $string);
		}
		return $string;
	}
	public static function file_get_contents_utf8($fn) {
		$opts = array(
				'http' => array(
						'method'=>"GET",
						'header'=>"Content-Type: text/html; charset=utf-8"
				)
		);
	
		$context = stream_context_create($opts);
		$result = @file_get_contents($fn,false,$context);
		return $result;
	}
	
	public static function getParams($url) {
		$parts = parse_url($url);
		$query = array();
		if(isset($parts['query']) && !empty($parts['query']))
			parse_str($parts['query'], $query);
		return $query;
	}
}