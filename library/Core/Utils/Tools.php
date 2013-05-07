<?php
class Core_Utils_Tools
{	
	public static function getCurrentDateSQL() {
		return date('Y-m-d H:i:s');
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
	public static function printMessage($element) {
		$messages = $element->getMessages();
		$str = '';
		if(!empty($messages)) {
			$str = join('<br/>', $messages);
		}
		return $str;
	}
	public static function genKey($email=null) {
		if($email == null) {
			$key = '';
			list($usec, $sec) = explode(' ', microtime());
			mt_srand((float) $sec + ((float) $usec * 100000));
			$inputs = array_merge(range('z','a'),range(0,9),range('A','Z'));
			for($i=0; $i<32; $i++)
			{
				$key .= $inputs{mt_rand(0,61)};
			}
			return $key;
		} else {
			return hash('ripemd160', $email);
		}
		//return ord($email)  & 0x1FE;
	}
	public static function substr($str,$len=255) {
		if(mb_strlen($str,'UTF-8') <= $len) return $str;
		return mb_substr($str, 0, $len,'UTF-8').'...';
	}
	public static function getFullURL() {
		return "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	}
	public static function genJobUrl($job) {
		return '/job/view-job/'.Core_Utils_String::getSlug($job['title']).'?id='.$job['id'];
	}
	public static function genCompanyUrl($id,$name) {
		return '/company/'.Core_Utils_String::getSlug($name).'?id='.$id;
	}
	public static function genCityUrl($id,$name) {
		return '/tag/city/'.Core_Utils_String::getSlug($name).'?id='.$id;
	}
	public static function genPositionUrl($id,$name) {
		return '/tag/position/'.Core_Utils_String::getSlug($name).'?id='.$id;
	}
	public static function genTagUrl($tag) {
		return '/tag/'.$tag;
	}
	public static function genArticleUrl($article) {
		return '/tintuc/view/'.Core_Utils_String::getSlug($article['title']).'?id='.$article['id'];
	}
	public static function genRaovatUrl($raovat) {
		return '/rao-vat/view/'.Core_Utils_String::getSlug($raovat['tieude']).'?id='.$raovat['id'];
	}	
	public static function genSecureKey($len = 10) {
		$key = '';
		list($usec, $sec) = explode(' ', microtime());
		mt_srand((float) $sec + ((float) $usec * 100000));
		$inputs = array_merge(range('z','a'),range(0,9),range('A','Z'));
		for($i=0; $i<$len; $i++)
		{
		$key .= $inputs{mt_rand(0,61)};
		}
		return $key;
	}
	public static function getIPClient() {
		return $_SERVER['REMOTE_ADDR'];
	}
	public static function isAdmin() {
		$session = new Zend_Session_Namespace('session');
		if(isset($session->logged) && $session->logged['role'] == ROLE_ADMIN) return true;
		return false;
	}
	public static function isOwner($job) {
		$session = new Zend_Session_Namespace('session');
		if(!isset($session->logged)) return false;
		if($session->logged['role'] == ROLE_ADMIN) return true;
		if($session->logged['id'] == $job['account_id']) return true;
		return false;
	}
	public static function loadCache($lifetime = null) {
		$frontendOptions = array('lifetime' => $lifetime, 'automatic_serialization' => true);
		$backendOptions = array('cache_dir' => PUBLIC_DIR .'/cache/'); // getting a Zend_Cache_Core object
		return Zend_Cache::factory('Core', 'File', $frontendOptions, $backendOptions);
	}
	public static function uid2username($uid) {
		$row = Core_Utils_DB::query('SELECT `username` FROM `accounts` WHERE `id` = ?',2,array($uid));
		return $row==false?'':$row['username'];
	}
	public static function form2HTML($form) {
		$html = '';
    	foreach ($form as $element => $item) {
    		$str = '';
    		if($item['tag'] == 'input') {
    			$str = "<input name='$element' id='$element' ";
    			foreach ($item['attrs'] as $name => $value) {
    				$str.=$name.' = "'.$value.'" ';
    			}
    			$str.='/>';
    		}
    		$html.=$str;
    	}
    	return $html;
	}
	public static function debug($e) {
		echo '<pre>'.$e->getTraceAsString().'</pre>';die;
	}
	public static function isProduct() {
		if(APPLICATION_ENV == 'production') return true;
		return false;
	}
	public static function genToken() {
		$session = new Zend_Session_Namespace('session');
		$token = Core_Utils_Tools::genSecureKey(32);
		$session->token = $token;
		return $token;
	}
	public static function strip_tags($data,$except = array()) {
		foreach ($data as $key => $value) {
			if(in_array($key, $except)) continue;
			$data[$key] = strip_tags($value);
		}
		return $data;
	}
	public static function addEmail($email) {
		if(empty($email)) return;
		$validate = new Zend_Validate_EmailAddress();
		if($validate->isValid($email) == false) return;
		Core_Utils_DB::query('INSERT DELAYED INTO `emails`(`email`) VALUES (?)',3,array($email));
	}
	public static function getGrabber($url) {
		$parts = @parse_url($url);
		if(!isset($parts['host'])) return null;
		$host = $parts['host'];
		if($host == null || empty($host)) return null;
		if(Core_Utils_String::contains($host, 'vieclam.24h.com.vn')) return 'Core_Grabber_ViecLam24h';
		return null;
	}
	public static function getImageFromUrl($contents,$dst_folder,$filename)
	{
	    $tmp_filepath = PUBLIC_DIR.'/tmp/'.$filename.'_tmp';
	    $handle = fopen($tmp_filepath, 'w');
	    fwrite($handle, $contents);
	    fclose ($handle);
	    $info = @getimagesize($tmp_filepath);
	    if(empty($info)) die('ERROR1');
		$origWidth = $info[0];
		$origHeight = $info[1];
    	$type = $info[2];
    	$sType = '';
		switch ($type) {
            case IMAGETYPE_BMP:
                $img = imagecreatefromwbmp($tmp_filepath);
                 $sType = '.bmp';
                break;
            case IMAGETYPE_GIF:
                $img = imagecreatefromgif($tmp_filepath);
                $sType = '.gif';
                break;
            case IMAGETYPE_JPEG:
                $img = imagecreatefromjpeg($tmp_filepath);
                 $sType = '.jpg';
                break;
            case IMAGETYPE_PNG:
                $img = imagecreatefrompng($tmp_filepath);
                $sType = '.png';
                break;
            default:
                die('ERROR2');
        }
        
		$new = imagecreatetruecolor($origWidth, $origHeight);
        // preserve transparency
        if ($type == IMAGETYPE_GIF or $type == IMAGETYPE_PNG) {
            imagecolortransparent($new, 
            imagecolorallocatealpha($new, 0, 0, 0, 127));
            imagealphablending($new, false);
            imagesavealpha($new, true);
        }
        imagecopyresampled($new, $img, 0, 0, 0, 0, $origWidth, $origHeight, $origWidth, $origHeight);
        $dst = $dst_folder . '/' . $filename . $sType;
        switch ($type) {
            case IMAGETYPE_BMP:
                imagewbmp($new, $dst,DEFAULT_IMAGE_RESIZE_QUALITY);
                break;
            case IMAGETYPE_GIF:
                imagegif($new, $dst,DEFAULT_IMAGE_RESIZE_QUALITY);
                break;
            case IMAGETYPE_JPEG:
                imagejpeg($new, $dst,DEFAULT_IMAGE_RESIZE_QUALITY);
                break;
            case IMAGETYPE_PNG:
                imagepng($new, $dst,9);
                break;
        }
        unlink($tmp_filepath);
    	return $dst_folder.$filename . $sType;
    	
		//print_r($result->getHeaders());
	}
	
	public static function openHtml($content,$filename) {
		file_put_contents($filename, $content);
		exec($filename);
		
	}
	
}