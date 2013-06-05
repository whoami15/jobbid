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
		$this->_cUrl = new Core_Dom_Curl(array(
				'method' => 'GET',
				'header' => array(
						'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
						'Accept-Encoding: gzip, deflate',
						'Accept-Language: en-US,en;q=0.5',
						'Connection: keep-alive',
						'DNT: 1',
						'User-Agent: Mozilla/5.0 (Windows NT 6.1; WOW64; rv:19.0) Gecko/20100101 Firefox/19.0',
						'X-Requested-With: 	XMLHttpRequest',
						'Cookie: __utma=259897482.1689604994.1351605073.1366299993.1366340806.53; __utmz=259897482.1366198743.50.6.utmcsr=facebookad|utmccn=pro_tangtientrieu_thang04|utmcmd=PromoP|utmctr=Fans_Friend_123vn|utmcct=tang-tien-trieu; __utmv=259897482.|1=User%20ID=thanhphuong7486=1; __atuvc=0%7C12%2C0%7C13%2C0%7C14%2C0%7C15%2C16%7C16; __utmx=259897482.YNCbXckDSTOh7MhnaRUGCQ$54197633-8:1; __utmxx=259897482.YNCbXckDSTOh7MhnaRUGCQ$54197633-8:1358337355:15552000; s3=1360132972; banner_footer_count=19; zingid=1366125523_128; __atssc=facebook%3B1; PHPSESSID=uu95rnj0ic5782lcf5hn0l5363; __utmb=259897482.17.9.1366341461284; __utmc=259897482; uin=213504237; acn=thanhphuong7486; vngauth=AAEMWdq0cFHt0LkMAAAAAGGgMHA%3D; s1=1366341418; s2=11a4511a49a0d221ea07d7a460c49371'
				)
		));
		 
	}
	public function start() {
		$site = new Application_Model_Site_123Vn();
		$array = array(306);
		$site->test($array);
		//print_r($rs);
		exit;
		$array = array('khanhduong745','camthi_mc','bangvy2008','vutruongmedia','ngocvo177','trannam_sieucoi','hdao19','tamkem1506','hongthanh081189','trancongphuoc2007','loilam_lauxanh','minhlongan28','congsang202','nscnminhhung.vn','trannghia8389','nguyenquoccuong1910','dao_hoang1992','hang_tw.vn','anhlthb','lovely_moon165','giangntm.it','muadongbuon2012.vn','ngoc_giau664','vanthi_tv','ngoclong0805','kimquyen281284','congchua_ngaytho272','nghe_o_19032003','thuyanh.design','loibk09','yolly.pig','msnhi88');
		foreach ($array as $zingid) {
			$data = array('zingid' => $zingid);
			Core_Utils_DB::insert('zing', $data);
		}
		exit;
		$length = count($str);
		$str = substr($str, $length-3);
		echo $str;exit;
		$ips = array('82.160.137.162','202.146.237.79','2.133.93.82','89.28.117.176','88.204.187.90','221.210.40.150','210.56.8.80','113.53.232.46','58.242.249.31','120.203.215.4','186.3.71.155','113.28.244.195','201.218.13.110','188.75.81.20','212.220.105.122','200.195.167.235','216.208.156.69','110.77.233.164','201.211.25.172','199.167.228.36','223.4.179.152','173.213.96.229','218.108.169.2','189.59.17.206','112.5.183.235','79.175.187.2','2.133.92.244','66.35.68.145','2.133.92.245','113.94.96.63','159.226.71.138','190.151.122.38','142.54.188.180','124.195.52.21','178.23.227.47','91.193.128.124','86.96.229.123','59.49.79.121','91.151.176.95','199.30.136.116','24.91.214.254','119.36.87.32','173.213.96.229','221.10.102.203','119.187.148.81','200.84.130.87','177.130.128.8','78.9.164.162');
		$ports = array('443','808','9090','54321','3128','8080','808','3128','18080','9090','8080','3128','8080','3128','3128','6666','3128','3128','8080','80','3128','8089','82','3128','80','8080','8081','8089','8081','6668','1170','8080','8080','3128','8080','8080','8088','9527','8080','3128','10379','81','3128','81','9000','8080','8080');
		foreach ($ips as $i => $ip) {
			if(!isset($ports[$i])) break;
			$port = $ports[$i];
			$t1 = time();
			$flag = true;
			try {
				$fp = fsockopen($ip,$port,$errno, $errstr, 10);
			} catch (Exception $e) {
				$flag = false;
			}
			$t2 = time();
			if($flag) {
				$data = array(
					'id' => NULL,
					'ip_addr' => $ip.':'.$port,
					'time' => $t2 - $t1,
					'create_time' => Core_Utils_Date::getCurrentDateSQL()
				);
				Core_Utils_DB::insert('proxy', $data);
				if($fp != null) fclose($fp);
			}
		}
		echo 'DONE';exit;
		$zingid ='hongson_bbd';
		if(Core_Utils_String::contains($zingid, 'bbd') == false) {
			$zingid = 'bbd'.$zingid;
		}
		echo $zingid;
		exit;
		//$array = array('phuoc103','goodjob','thunga198872','dautomclub','nguyenhienxt07','smile279','giathu279','tieuminh2003','lanchiln','khoidoan488848','kimphung0105','myngoc1601','thanhcong28081978','tuonglai7','huongnguyen','datnguyen789413','bepxinhtb','thao72ctxhk4','toiladoanhnhantd','iwilltakeit2012','inmaugtvt','dethuong1015','becachua','phuongthuystyle1194','gosoitb','kimngoc142','nhanlucanphat','falljng','hailuu654321','tt77v1','nguyendat2023c','kiemtiendelamgiau','chubevotu','quocdao011','ngoctien','tuyendungnhansu2','trangnha','kbdepxinh','finance2005','datnguyen789414','datnguyen789411','phambon102','davidmohk1','longlinh8287','haibui123','nguyendangvinh411','heathbell22','quocdao09','phuongqt2309','dongphucnew','ketnoiviet24h','thuyhang7291','phantronggiap','nhokkute','saobangkhoc02111993','loveforever','baongan17','pktbcl','nguyenvanhai','hoangnguyen1266','danghoangdong79','anhkientruc04','phungtranson','oriflame','badboyhd1993','hailuu123456','minhvan','minhngoc36.dealer','tuonglai0','quachtuandh','duyennguyenou','timviecnhanh94','ladopha250','hieunguyenbui','huynhphan46','phandong46','nguyenphuong.dt789','ganhoibong','nguyenthianhtuyetnt','quanlikinhdoanh.no1','lientran042','hjpsu72','th.binh2013','nguyenthang250','deenguyenlamgiau','linhphong0','hunglinh.122','nguyentrunghuy13','nguyentrunghuy','phamvantuan.2007','thaohiem270592','gmtranyen','nguyenphuonghoangthuy','cobedongdanh281292','nhnt2301','tuananhcmag','thhuong1989','excitergp01','create01237080','anhngocmanager2013','ngochuyen.zt','quocdao07','htnngoc55','duytu1910','hoangbinh.tdt','mimiyeuconco','kieuoanh271','shiki010','vanminh.dir','ntquy1990','vietsm2013','daotiendung1983','thinkbig0902','kantaeyoung','anvinh1510','mrtai.online24gio.com','luongthingoc.hy','dichvuvesinhhanoi123','vn.golmart','thanhduyenntc','quynhmai.kgshn','nguyendai.kgshn','minhtrangnguyen3590','phuongvu.vddp','oyanav','leminhluan90','tanvanchuyen','suoinguonenvironmental','ngocmy95','vphuc36','thongnguyen730','tubepankhanggiare','yukanjin1990','abcef','rongthan40','rongthan39','rongthan38','rongthan37','duhi295','tubep2014','nhha2013','nguyenthanhlong8287','congviec.online76','chayviec.vn','doquocket','vnpaybt','tuyendungdaotaons','tienphuong23','nguyenluyenhoakx','emily12345tran','anhnoi.oto','thoconrungxanh','chienspb','thaobk74','mrthanhhbu','thinhvuonglienket','ngocbich221093','suijin9x');
		$array = Core_Utils_DB::query('select * from zing');
		$star = 200;
		foreach ($array as $item) {
			for ($i = 1; $i <= 5;$i++){
				$star++;
				echo 'Assign number '.$star.' to '.$item['zingid'].PHP_EOL;
				Core_Utils_DB::insert('bbd_guest', array(
					'zing_id' => $item['id'],
					'number' => $star
				));
			}
		}
		exit;
		$db = Zend_Registry::get('connectDb');
    	$stmt = $db->prepare('INSERT INTO `zing`(`zingid`) VALUES(?)');
		foreach ($array as $zingid) {
			echo 'Inser zingid '.$zingid.PHP_EOL;
			$stmt->execute(array($zingid));
		}
		$stmt->closeCursor();
    	$db->closeConnection();
    	exit;
		Application_Model_Site_Yes24::getInstance()->start();
		$date = new Zend_Date(1366390800);
		echo $date->toString('dd/MM/Y HH:mm:ss');die;
		//echo Core_Utils_String::getSlug('Hà Nội');die;
		$url = 'http://123.vn/tang-tien-trieu.html';
		//$content = $this->_cUrl->getContent($url);
		//Core_Utils_Log::write($content);die;
		//$url = 'http://localhost/jobbid/test/test';
		$i = 0;
		$flag = false;
		Core_Dom_Query::cleanup();
		$content = $this->_cUrl->getContent($url);
		//Core_Utils_Log::write($content);die('OK');
		$doc = Core_Dom_Query::newDocumentHTML($content,'UTF-8');
		$post_data = $doc->find('#frm_lucky')->serializeArray();
		$post_items = array();
		foreach ($post_data as $item) {
			$post_items[] = $item['name'] . '=' . $item['value'];
		}
		print_r($post_items);
		if(empty($post_items)) {
			die('Not 12h');
		}
		/*print_r($post_data);die;
		//$doc->find("#frm_lucky #btSubmit")->click();
		foreach ( $post_data as $key => $value) {
		    $post_items[] = $key . '=' . $value;
		}*/
		$post_string = implode ('&', $post_items);
		//Core_Utils_Log::log($post_string);die;
		//create cURL connection
		$curl_connection = 
		  curl_init($url);
		 
		//set options
		curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
		curl_setopt($curl_connection, CURLOPT_USERAGENT, 
		  "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)");
		curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl_connection, CURLOPT_FOLLOWLOCATION, 1);
		 
		//set data to be posted
		curl_setopt($curl_connection, CURLOPT_POSTFIELDS, $post_string);
		 
		//perform our request
		$i = 0;
		while($i < 1000) {
			curl_exec($curl_connection);
			$i++;
		}
		
		 
		//show information regarding the request
		/*print_r(curl_getinfo($curl_connection));
		echo curl_errno($curl_connection) . '-' . 
		                curl_error($curl_connection);*/
		 
		//close the connection
		curl_close($curl_connection);
		die('OK');
	}
}

