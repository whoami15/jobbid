<?php
class Core_Utils_Facebook
{	
	public static function getGraphInfo($accessToken) {
		$str = file_get_contents('https://graph.facebook.com/me?access_token='.$accessToken);
		return json_decode($str);
	}
}