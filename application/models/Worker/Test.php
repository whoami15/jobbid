<?php

class Application_Model_Worker_Test 
{
	protected static $_instance = null;
	var $_header;
	var $_cUrl;
	public static function getInstance($className=__CLASS__){
		//Check instance
		if(empty(self::$_instance)){
			self::$_instance = new $className;
		}
		//Return instance
		return self::$_instance;
	}
	public function __construct(){
		 
		 
	}
	public function start() {
		$from = strtotime('2013-03-01');
		$end = strtotime('2013-03-02');
		echo $end - $from;
		die;
	
		$tags = Application_Model_DbTable_Tag::findAllTag();
		$str = array();
		foreach($tags as $index => $tag ) {
			$str[] = "MATCH(t0.`txt`) AGAINST('{$tag['tag']}') AS r$index";
		}
		$str = join(',', $str);
    	$query = "SELECT $str FROM `data_fulltext` t0,`tags` t1
WHERE t0.`ref_id`=12";
    	$db = Zend_Registry::get('connectDb');
    	$stmt = $db->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch();
        $stmt->closeCursor();
        $db->closeConnection();
        $array = array();
        foreach($row as $key => $value) {
        	$key = str_replace('r', '', $key);
        	if($value > 1)
        		$array[$key] = $value;
        }
        asort($array,SORT_NUMERIC);
        $len = count($array);
        $array = array_slice($array, $len-10,10,true);
        foreach($array as $key => $value) {
        	$str = Core_Utils_String::toUnUnicode($tags[$key]['tag'].' : '.$value);
        	echo $str.PHP_EOL;
        }
       // print_r($array);
	}
}

