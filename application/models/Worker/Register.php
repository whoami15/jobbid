<?php

class Application_Model_Worker_Register
{
	protected static $_instance = null;
	var $_header;
	var $_cUrl;
	var $_formFw = '';
	var $_proxy = array('124.195.52.21:3128','24.91.214.254:10379','113.53.232.46:3128','199.167.228.36:80','120.203.215.4:9090','113.28.244.195:3128','159.226.71.138:1170','110.77.233.164:3128','212.220.105.122:3128','66.35.68.145:8089','91.193.128.124:8080','88.204.187.90:3128','221.10.102.203:81','173.213.96.229:3128','173.213.96.229:8089','2.133.93.82:9090','59.49.79.121:9527','223.4.179.152:3128','202.146.237.79:808','112.5.183.235:80','89.28.117.176:54321');
	var $cookie = 'Cookie: PHPSESSID=qo7joq9grvi0nvgppfifofmei6; __utma=259897482.1952231106.1370364470.1370364470.1370364470.1; __utmb=259897482.1.10.1370364470; __utmc=259897482; __utmz=259897482.1370364470.1.1.utmcsr=(direct)|utmccn=(direct)|utmcmd=(none)';
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
		$domain = 'noithatchauhong.com';
		$arrayUsername = array('ngoc_giau664','congchua_ngaytho272');
		$arrayPhone = array('0908914473','0906672857');
		foreach ($arrayUsername as $index => $username) {
			$proxy = '';
			/*while (!empty($this->_proxy)) {
				if(!empty($proxy)) break;
				try {
					$rand = array_rand($this->_proxy);
					$proxy = $this->_proxy[$rand];
					$cUrl = new Core_Dom_Curl(array(
						'method' => 'GET',
						'cookie' => $this->cookie,
						'proxy' => $proxy
					));
				} catch (Exception $e) {
					echo 'Remove proxy '.$proxy.PHP_EOL;
					$proxy = '';
					unset($this->_proxy[$rand]);
				}
			}
			
			if(empty($proxy)) die('No Prxy');
			echo 'Use proxy '.$proxy.PHP_EOL;*/
			$phone = $arrayPhone[$index];          
			//echo $phone;
			$cUrl = new Core_Dom_Curl(array(
				'method' => 'GET',
				'cookie' => $this->cookie
			));
			$content = $cUrl->getContent('http://123.vn/promotion-gateway/register?source=1');
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
				'lastname' => 'duong',
				'firstname' => 'khanh',
				'username' => $username.'88',
				'email' => $username.'@'.$domain,
				'confirmEmail' => $username.'@'.$domain,
				'password' => '74198788',
				'passwordConfirm' => '74198788',
				'phone' => $phone,
				'captcha' => $captcha,
				'seckey' => $seckey,
				'shippingCity' => '1',
				'shippingDist' => '48',
				'yearOfBirth' => '1989'
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
				'url' => 'http://123.vn/promotion-gateway/register?source=1',
				'cookie' => $this->cookie,
				'proxy' => $proxy
			));
			$result = $cUrl->exec();
			$content = $result['body'];
			$doc = Core_Dom_Query::newDocumentHTML($content,'UTF-8');
			$error = trim($doc->find('ul.error')->get(0)->textContent);
			echo 'Create user '.$username.':'.PHP_EOL;
			if(empty($error)) {
				echo 'SUCCESS'.PHP_EOL;
				echo "Enter verify url : "; // Output - prompt user
				$url = fgets(STDIN);
				$cUrl = new Core_Dom_Curl(array(
					'method' => 'GET',
					'cookie' => $this->cookie,
					'proxy' => $proxy
				));
				$cUrl->request($url);
				echo 'DONE'.PHP_EOL;
			} else {
				echo 'FAILED : '.$error;
			}
			echo  PHP_EOL;
		}
		//echo 'Fw email '.$email.', result ='.$result['http_code'].PHP_EOL;
		
		die('OK');
	}
}

