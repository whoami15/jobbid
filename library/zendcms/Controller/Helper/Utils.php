<?php
class zendcms_Controller_Helper_Utils
{
	 
	public static function getCurrentDateSQL() {
		return date('Y-m-d H:i:s');
	}
	public static function getPartsFilename($filename)
	{
	   if(empty($filename))
	   		return null;
	   
	   $parts=explode(".",$filename);
	   return array(
	   		'name' => $parts[0],
	   		'ext' => isset($parts[1])?$parts[1]:''
	   );
	}
	public static function uploadFileName($ext) {
		$date = new Zend_Date();
		return $date->getTimestamp().'_'.date('Ymd').'.'.$ext;
	}
	
	public static function array_trim(&$arr,$len_trim) {
		$len = count($arr);
		while($len>$len_trim) {
			unset($arr[$len-1]);
			$len --;
		}
	}
	public static function loadCache($lifetime = null) {
        $frontendOptions = array('lifetime' => $lifetime, 'automatic_serialization' => true);
        $backendOptions = array('cache_dir' => PUBLIC_DIR .'/cache/'); // getting a Zend_Cache_Core object
        return Zend_Cache::factory('Core', 'File', $frontendOptions, $backendOptions);
    }
	public static function saveStatic($variable,$value) {
		$cache = zendcms_Controller_Helper_Utils::loadCache();
		if(($static = $cache->load('static')) == null) $static = array();
		$static[$variable] = $value;
		$cache->save($static,'static');
    }
	public static function loadStatic($variable) {
		$cache = zendcms_Controller_Helper_Utils::loadCache();
		if(($static = $cache->load('static')) == null) return null;
		return $static[$variable];
    }
    public static function previousMonth() {
    	$month=date("m");
    	$year=date("Y");
    	$month--;
    	if($month==0)
    		return '12'.($year-1);
    	return $month.$year;
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
    public static function validUsername($username) {
    	return preg_match('/^(?=.{1,15}$)[a-zA-Z][a-zA-Z0-9]*(?: [a-zA-Z0-9]+)*$/', $username);
    }
	public static function preg_replace_callback($matches) {
		$rep = Zend_Registry::get('rep');
    	return $rep[$matches[1]];
    }
    public static function in_array_field($needle, $needle_field, $haystack, $stdClass = false) {
	    if ($stdClass) {
	        foreach ($haystack as $item)
	            if (isset($item->$needle_field) && $item->$needle_field === $needle)
	                return $item;
	    }
	    else {
	        foreach ($haystack as $item)
	            if (isset($item[$needle_field]) && $item[$needle_field] == $needle)
	                return $item;
	    }
	    return null;
	}
	/*public static function getDirectories($path,$folder_name) {
		$dirs = scandir($path.DS.$folder_name);
		if($path=='.')
			$str = '<ul id="browser" class="filetree">';
		else
			$str = '<ul>';
		$flag = false;
		foreach ($dirs as $dir) {
			if ($dir === '.' or $dir === '..') continue;
			if(is_dir($path.DS.$folder_name.DS.$dir)) {
				$flag = true;
				$str.= '<li><span class="folder">'.$dir.'</span>'.zendcms_Controller_Helper_Utils::getDirectories($path.DS.$folder_name, $dir).'</li>';
			}
		}
		if($flag == false)
			return '';
		return $str.'</ul>';
	}*/
	/*public static function getDirectories($arr) {
		$str = '<ul>';
		if(empty($arr))
			return '';
		foreach ($arr as $key=>$value) {
			$str.= '<li><span class="folder" folder_id="'.$value['id'].'">'.$key.'</span>'.zendcms_Controller_Helper_Utils::getDirectories($value['child']).'</li>';
		}
		return $str.'</ul>';
	}*/
	public static function getDirectories($arr) {
		$str = '<ul>';
		if(empty($arr))
			return '';
		foreach ($arr as $value) {
			$str.= '<li><span class="folder" folder_id="'.$value['id'].'">'.$value['name'].'</span>'.zendcms_Controller_Helper_Utils::getDirectories($value['child']).'</li>';
		}
		return $str.'</ul>';
	}
	public static function trim($str,$length = 50) {
		if(mb_strlen($str,'utf-8') <= $length)
			return $str;
		$str = mb_substr($str, 0, $length,'utf-8').'...';
		return $str;
	}
}
?>