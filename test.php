<?php
	/*$summaryText='Displaying {start}-{end} of {count} result(s).';
	echo strtr($summaryText,array(
		'{start}'=>'1',
		'{end}'=>'2',
		'{count}'=>"'3'",
		'{page}'=>4,
		'{pages}'=>5,
	));*/
	/*$num = 6;
	$result = floor($num/3)*2;*/
	/* $array = array(1);
	$result = array_rand($array); */
	/* $job = "CheckPromotions";
	$worker = ucwords(basename($job));

	$workerName = "Worker_{$worker}";
	die($workerName);
	print_r($result); */
	/* $string = 'Chương trình "[Humana] Quà tặng kèm 3" (pro_gift_humana3), quà "Ly sứ (Quà tặng Humana)" có số lượng < 3 ';
	$pattern = array("a" => "á|à|ạ|ả|ã|Á|À|Ạ|Ả|Ã|ă|ắ|ằ|ặ|ẳ|ẵ|Ă|Ắ|Ằ|Ặ|Ẳ|Ẵ|â|ấ|ầ|ậ|ẩ|ẫ|Â|Ấ|Ầ|Ậ|Ẩ|Ẫ", "o" => "ó|ò|ọ|ỏ|õ|Ó|Ò|Ọ|Ỏ|Õ|ô|ố|ồ|ộ|ổ|ỗ|Ô|Ố|Ồ|Ộ|Ổ|Ỗ|ơ|ớ|ờ|ợ|ở|ỡ|Ơ|Ớ|Ờ|Ợ|Ở|Ỡ", "e" =>
    			"é|è|ẹ|ẻ|ẽ|É|È|Ẹ|Ẻ|Ẽ|ê|ế|ề|ệ|ể|ễ|Ê|Ế|Ề|Ệ|Ể|Ễ", "u" => "ú|ù|ụ|ủ|ũ|Ú|Ù|Ụ|Ủ|Ũ|ư|ứ|ừ|ự|ử|ữ|Ư|Ứ|Ừ|Ự|Ử|Ữ", "i" => "í|ì|ị|ỉ|ĩ|Í|Ì|Ị|Ỉ|Ĩ", "y" => "ý|ỳ|ỵ|ỷ|ỹ|Ý|Ỳ|Ỵ|Ỷ|Ỹ", "d" => "đ|Đ", "c" => "ç", );
	foreach($pattern as $nonUnicode=>$uni) 
		$string = preg_replace("/($uni)/i",$nonUnicode,$string);
	echo mb_detect_encoding($string);die; */
	/* function toUnUnicode($string) {
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
	$msgContent = 'Chương trình "[Humana] Quà tặng kèm 3" (pro_gift_humana3), quà "Ly sứ (Quà tặng Humana)" có số lượng < 3 ';
	$msgContent = toUnUnicode($msgContent); 
	$msgContent = toUnUnicode($msgContent); 
	echo $msgContent; */
	//$cur = time();
	/* $array = array(
		'name' => 'Long',
		'age' => 26
	);
	echo json_encode($array); */
	
	/* $str = '{"name":"Long","age":26}';
	print_r(json_decode($str)); */
	
	/* class Core_Promotion_Rule_Quantity{
		protected static $_instance = null;
		protected $data = array();
		public static function getInstance(){
			if(empty(self::$_instance)){
				self::$_instance = new Core_Promotion_Rule_Quantity();
			}
			return self::$_instance;
		}
		public function __construct(){
			echo 'init new...<br>';
		}
		public function execute() {
			echo 'Test i = '.$this->data['i'].'<br>';
		}
		public function setData($dt) {
			$this->data = $dt;
		}
	}
	
	//$obj = Core_Promotion_Rule_Quantity::getInstance();
	$i = 0;
	while(true) {
		$obj = @call_user_func(array('Core_Promotion_Rule_Quantity', 'getInstance'));
		if($obj != null) {
			$obj->setData(array('i' => $i));
			//$obj = new Core_Promotion_Rule_Quantity();
			$obj->execute();
		}
		$i++;
		if($i>3) break;
	} */
	
	//$obj->execute();
	/* $date1 = mktime(10,0,0,1,3,2013);
	//$date2 = strtotime('2013-12-31 23:59:00');
	$date2 = DateTime::createFromFormat('Y-m-d H:i:s', '2013-1-3 10:00:00')->getTimestamp();
	echo '1357182000';
	echo '<br>';
	print_r($date1);
	echo '<br>';
	print_r($date2); */
	
	/* $d=getdate(1357182000);
	$d2=getdate(1357207200);
	print_r($d);
	echo '<br>';
	print_r($d2);  */
	/* print_r($_SERVER);die;
	if(!isset($_SERVER["HTTP_ACCEPT_ENCODING"]) && !isset($_SERVER["HTTP_ACCEPT_LANGUAGE"]))
	{
		echo "You are robot";
	} else {
		echo "you are human";
	} */
define('FACEBOOK_APP_ID', '147187892112001');
define('FACEBOOK_SECRET', 'c6a00f782b52a96707ff8ec841610760');

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
if ($_REQUEST) {
  echo '<p>signed_request contents:</p>';
  $response = parse_signed_request($_REQUEST['signed_request'], 
                                   FACEBOOK_SECRET);
  echo '<pre>';
  print_r($response);
  echo '</pre>';
} else {
  //echo '$_REQUEST is empty';
}
?>
<iframe 
	src="https://www.facebook.com/plugins/registration?client_id=<?php echo FACEBOOK_APP_ID?>&redirect_uri=http://localhost/jobbid/test.php& fields=[
                { 'name':'name' },
                { 'name':'company', 'description':'Company Name', 'type':'text' },
                { 'name':'email' },
                { 'name':'phone', 'description':'Phone Number', 'type':'text' },
                { 'name':'city', 'description':'City', 'type':'text' }
                ]" 
		scrolling="auto"
        frameborder="no"
        style="border:none"
        allowTransparency="true"
        width="100%"
        height="330">
</iframe>