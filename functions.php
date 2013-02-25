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
	$pattern = array("a" => "Ã¡|Ã |áº¡|áº£|Ã£|Ã�|Ã€|áº |áº¢|Ãƒ|Äƒ|áº¯|áº±|áº·|áº³|áºµ|Ä‚|áº®|áº°|áº¶|áº²|áº´|Ã¢|áº¥|áº§|áº­|áº©|áº«|Ã‚|áº¤|áº¦|áº¬|áº¨|áºª", "o" => "Ã³|Ã²|á»�|á»�|Ãµ|Ã“|Ã’|á»Œ|á»Ž|Ã•|Ã´|á»‘|á»“|á»™|á»•|á»—|Ã”|á»�|á»’|á»˜|á»”|á»–|Æ¡|á»›|á»�|á»£|á»Ÿ|á»¡|Æ |á»š|á»œ|á»¢|á»ž|á» ", "e" =>
		"Ã©|Ã¨|áº¹|áº»|áº½|Ã‰|Ãˆ|áº¸|áºº|áº¼|Ãª|áº¿|á»�|á»‡|á»ƒ|á»…|ÃŠ|áº¾|á»€|á»†|á»‚|á»„", "u" => "Ãº|Ã¹|á»¥|á»§|Å©|Ãš|Ã™|á»¤|á»¦|Å¨|Æ°|á»©|á»«|á»±|á»­|á»¯|Æ¯|á»¨|á»ª|á»°|á»¬|á»®", "i" => "Ã­|Ã¬|á»‹|á»‰|Ä©|Ã�|ÃŒ|á»Š|á»ˆ|Ä¨", "y" => "Ã½|á»³|á»µ|á»·|á»¹|Ã�|á»²|á»´|á»¶|á»¸", "d" => "Ä‘|Ä�", "c" => "Ã§", );
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
function parse_signed_request($signed_request, $secret) {
	list($encoded_sig, $payload) = explode('.', $signed_request, 2);

	// decode the data
	$sig = base64_url_decode($encoded_sig);
	$data = json_decode(base64_url_decode($payload), true);

	if (strtoupper($data['algorithm']) !== 'HMAC-SHA256') {
		error_log('Unknown algorithm. Expected HMAC-SHA256');
		return null;
	}

	// check sig
	$expected_sig = hash_hmac('sha256', $payload, $secret, $raw = true);
	if ($sig !== $expected_sig) {
		error_log('Bad Signed JSON signature!');
		return null;
	}

	return $data;
}

function base64_url_decode($input) {
	return base64_decode(strtr($input, '-_', '+/'));
}
?>