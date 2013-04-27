<?php

class Application_Model_Worker_Register
{
	protected static $_instance = null;
	var $_header;
	var $_cUrl;
	var $_formFw = '';
	public static function getInstance($className=__CLASS__){
		//Check instance
		if(empty(self::$_instance)){
			self::$_instance = new $className;
		}
		//Return instance
		return self::$_instance;
	}
	public function __construct(){
		/*$this->_cUrl = new Core_Dom_Curl(array(
			'method' => 'GET',
			'cookie' => 'Cookie: cprelogin=no; cpsession=bamboode%3avXE5mTVeFQdlsl2WG6o6XlR8owCLtnpgWIfr13XvEiew5l91VMWwAmFewgci38B_; langedit=; lang=; webmailsession=center%40bamboodev.us%3aHiTH9yjSvMJSWlUDxGXiErCdKKPraHyQKKzXIaPFF6iuVgOf3sK1TuI__mNEODPF; webmailrelogin=no; roundcube_sessauth=S612075c9da1c428b8c0bb0610fdbc4cc9ef69189'
		));*/
		 
	}
	public function start() {
		/*echo "Enter your name\n"; // Output - prompt user
		$name = fgets(STDIN);     // Read the input
		echo "Hello $name";       // Output - Some text   
		exit(0);*/ 
		//$domain = 'bamboodev.us';
		$domain = 'somuahang.com';
		$arrayUsername = array('oyanav','leminhluan90','tanvanchuyen','suoinguonenvironmental','ngocmy95','vphuc36','thongnguyen730','tubepankhanggiare','yukanjin1990','abcef','rongthan40','rongthan39','rongthan38','rongthan37','duhi295','tubep2014','nhha2013','nguyenthanhlong8287','congviec.online76','chayviec.vn','doquocket','vnpaybt','tuyendungdaotaons','tienphuong23','nguyenluyenhoakx','emily12345tran','anhnoi.oto','thoconrungxanh','chienspb','thaobk74','mrthanhhbu','thinhvuonglienket','ngocbich221093','suijin9x');
		$arrayPhone = array('0908951346','0908443146','0937709491','0908707253','0908127955','0937091714','0908099047','0908285548','0908097951','0908696441','0908096605','0937809247','0908542553','0908723060','0908940595','0908656260','0934768535','0908704467','0908092915','0908580937','0908058774','0937440930','0933533167','0908276343','0934756131','0908490438','0908560937','0908081907','0916359139','0916384099','0916359239','0915782877','0916359078','0916359177');
		foreach ($arrayUsername as $index => $username) {
			$phone = $arrayPhone[$index];          
			//echo $phone;
			$cUrl = new Core_Dom_Curl(array(
				'method' => 'GET',
				'cookie' => 'Cookie: __utma=259897482.1689604994.1351605073.1367038609.1367052043.72; __utmz=259897482.1366824283.66.8.utmcsr=newsletter|utmccn=kich-hoat-mo-qua-trung-lon_23.04|utmcmd=email; __utmv=259897482.|1=User%20ID=toannb=1; __atuvc=0%7C13%2C0%7C14%2C0%7C15%2C36%7C16%2C104%7C17; __utmx=259897482.YNCbXckDSTOh7MhnaRUGCQ$54197633-8:1; __utmxx=259897482.YNCbXckDSTOh7MhnaRUGCQ$54197633-8:1358337355:15552000; s3=1360132972; banner_footer_count=62; __atssc=facebook%3B1; zingid=1366731815_773; PHPSESSID=gdgccqtrn1dgo80hq4nhta1hj6; __utmc=259897482; lastlogin=toannb; __utmb=259897482.8.10.1367052043'
			));
			$content = $cUrl->getContent('http://123.vn/promotion-gateway/register?source=2&ref=mytrang6789');
			//Core_Utils_Log::write($content);die;
			$doc = Core_Dom_Query::newDocumentHTML($content,'UTF-8');
			$seckey = $doc->find('#seckey')->val();
			//echo $seckey.PHP_EOL;
			echo "Enter captcha : "; // Output - prompt user
			$captcha = fgets(STDIN);
			$post_data = $doc->find('#frmRegsiter')->serializeArray();
			//print_r($post_data);die;
			$array = array(
				'gender' => 'male',
				'lastname' => 'Bamboo',
				'firstname' => 'Dev',
				'username' => 'bbd'.$username,
				'email' => $username.'@'.$domain,
				'confirmEmail' => $username.'@'.$domain,
				'password' => '74198788',
				'passwordConfirm' => '74198788',
				'phone' => $phone,
				'captcha' => $captcha,
				'seckey' => $seckey,
				'shippingCity' => '1',
				'shippingDist' => '48',
				'yearOfBirth' => '1981'
			);
			$post_items = array();
			foreach ($post_data as $item) {
				if(isset($array[$item['name']])) {
					$post_items[] = $item['name'] . '=' . $array[$item['name']];
				} else {
					$post_items[] = $item['name'] . '=' . $item['value'];
				}
				
			}
			$post_string = implode ('&', $post_items);
			//echo $post_string.PHP_EOL;
			//Core_Utils_Log::write($content);die;
			$cUrl = new Core_Dom_Curl(array(
				'method' => 'POST',
				'post_fields' => $post_string,
				'url' => 'http://123.vn/promotion-gateway/register?source=2',
				'cookie' => 'Cookie: __utma=259897482.1689604994.1351605073.1367038609.1367052043.72; __utmz=259897482.1366824283.66.8.utmcsr=newsletter|utmccn=kich-hoat-mo-qua-trung-lon_23.04|utmcmd=email; __utmv=259897482.|1=User%20ID=toannb=1; __atuvc=0%7C13%2C0%7C14%2C0%7C15%2C36%7C16%2C104%7C17; __utmx=259897482.YNCbXckDSTOh7MhnaRUGCQ$54197633-8:1; __utmxx=259897482.YNCbXckDSTOh7MhnaRUGCQ$54197633-8:1358337355:15552000; s3=1360132972; banner_footer_count=62; __atssc=facebook%3B1; zingid=1366731815_773; PHPSESSID=gdgccqtrn1dgo80hq4nhta1hj6; __utmc=259897482; lastlogin=toannb; __utmb=259897482.8.10.1367052043'
			));
			$result = $cUrl->exec();
			$content = $result['body'];
			$doc = Core_Dom_Query::newDocumentHTML($content,'UTF-8');
			$error = trim($doc->find('ul.error')->get(0)->textContent);
			echo 'Create user '.$username.':'.PHP_EOL;
			if(empty($error)) {
				echo 'SUCCESS';
			} else {
				echo 'FAILED : '.$error;
			}
			echo  PHP_EOL;
		}
		//echo 'Fw email '.$email.', result ='.$result['http_code'].PHP_EOL;
		
		die('OK');
	}
}

