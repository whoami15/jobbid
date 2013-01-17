<?php
function toAscii($str, $replace=array(), $delimiter='-') {
	if( !empty($replace) ) {
		$str = str_replace((array)$replace, ' ', $str);
	}

	$clean = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
	$clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
	$clean = strtolower(trim($clean, '-'));
	$clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);

	return $clean;
}
function getSlug($string)
{
	$seperator = '-';
	$allowANSIOnly = true;
	$pattern = array("a" => "á|à|ạ|ả|ã|Á|À|Ạ|Ả|Ã|ă|ắ|ằ|ặ|ẳ|ẵ|Ă|Ắ|Ằ|Ặ|Ẳ|Ẵ|â|ấ|ầ|ậ|ẩ|ẫ|Â|Ấ|Ầ|Ậ|Ẩ|Ẫ", "o" => "ó|ò|ọ|ỏ|õ|Ó|Ò|Ọ|Ỏ|Õ|ô|ố|ồ|ộ|ổ|ỗ|Ô|Ố|Ồ|Ộ|Ổ|Ỗ|ơ|ớ|ờ|ợ|ở|ỡ|Ơ|Ớ|Ờ|Ợ|Ở|Ỡ", "e" =>
		"é|è|ẹ|ẻ|ẽ|É|È|Ẹ|Ẻ|Ẽ|ê|ế|ề|ệ|ể|ễ|Ê|Ế|Ề|Ệ|Ể|Ễ", "u" => "ú|ù|ụ|ủ|ũ|Ú|Ù|Ụ|Ủ|Ũ|ư|ứ|ừ|ự|ử|ữ|Ư|Ứ|Ừ|Ự|Ử|Ữ", "i" => "í|ì|ị|ỉ|ĩ|Í|Ì|Ị|Ỉ|Ĩ", "y" => "ý|ỳ|ỵ|ỷ|ỹ|Ý|Ỳ|Ỵ|Ỷ|Ỹ", "d" => "đ|Đ", "c" => "ç", );
	while (list($key, $value) = each($pattern))
	{
		$string = preg_replace('/' . $value . '/i', $key, $string);
	}
	if ($allowANSIOnly)
	{
		$string = strtolower($string);
		$string = preg_replace(array('/[^a-zA-Z0-9 -]/', '/[ -]+/', '/^-|-$/'), array('', $seperator, ''), $string);
	}
	return $string;
}

function getCurrentDateSQL() {
	return date('Y-m-d H:i:s');
}
function parseMailContent($obj, $template)
{
	$matches = array('');
	while(count($matches) > 0){
		preg_match("/\[([a-zA-Z0-9])*\]/", $template, $matches);
		if(empty($matches)){break;}
		$tag = $matches[0];
		$property = substr($tag, 1, strlen($tag)-2);
		if ($property != '') {
			$value = $obj[$property];
			$template = str_replace($tag, $value, $template);
		}
	} // while
	return $template;
}
function processContent($content) {
	//$matches = array();
	//preg_match("/\\\*/", $content, $matches);
	///print_r($matches);die();
	//return preg_replace('/\"/', '"', $content);
	return str_replace('\\"', '"', $content);
}
?>