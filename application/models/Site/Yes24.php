<?php

class Application_Model_Site_Yes24
{
	protected static $_instance = null;
	var $cookie = 'Cookie: __utma=49630894.1644758357.1367258846.1367942495.1367945825.8; __utmz=49630894.1367258846.1.1.utmcsr=google|utmccn=(organic)|utmcmd=organic|utmctr=(not%20provided); LoginIdChk=1; LoginId=nclong87; skyUrl=925710%2C976558%2C972579%2C1000745%2C983962%2C851579%2C850752; skyImage=/Upload/ProductImage/YES24DTDD/925710_XS.jpg%2C/Upload/ProductImage/istyle24_FashionAcc/976558_XS.jpg%2C/Upload/ProductImage/YES24DTDD/972579_XS.jpg%2C/Upload/ProductImage/YES24DTDD/1000745_XS.jpg%2C/Upload/ProductImage/YES24DTDD/983962_XS.jpg%2C/Upload/ProductImage/YES24DTDD/851579_XS.jpg%2C/Upload/ProductImage/YES24DTDD/850752_XS.jpg; __atuvc=3%7C18%2C2%7C19; ASP.NET_SessionId=pil2lv55zudpuvv3dgbty4ah; __utmc=49630894; __utmb=49630894.10.10.1367945825; .YES24Front_AUTH=2A301C960E51ED97B64F6C61C37B541991FE6700CF5252425159C79CDC4BB4337D7A3FE7263FBAB91F939DC29B8C0CEE9BF8B7A162CE1BF74543F209EBED177D2D4D7E00AF1E9E5672E2DD558CF3D60C4CB786A00375DD12ED9A500ECD37DEC32C6A98E68F12CBEE3934C0AC790DE59CBB995E1B81DDF0ACE4D0A65ED278ADC79A66902F264669FD970179C0C47201864625CC4BE8BD57D3709F31129A01E79D9B5EDD7E97669D3C8573BEEE48D056144C511B6D8A9B58BB1B57509AE9958F971C76D437C2D9042BB5C6204AD34B95FEAAB04129C07AAC4860CFDACD6A1985205FD62A6DF24485511FEA1FECEA454C294825321A010DD98FEFA02B72D3E748CCB8FEAF79B945B8BED35388C319DD75CBCC4F0F70F3A2F2C23D39B3B7069A8721E885380E4BC6EBEC99967B39033CB572F4428E73DFB6B7C7B6EE35312B71692DD4F9CA3D00B20D14EFEB4EE9291797D24E4B59F0BEC0D47014AB0EEEA75E4BDA3B3D0AE79CA4170CB8C747B3CACC02B6377E4C3EB747247BBE196C4186CBFC3E0C6D5A4793D56065F9B92C8AFCCB97AE2BC78DCF703FB63129B8839CE4F5005F4965CD0EF01B8B70A18C55606650258E3CFE7A0962F52A6E8022FF35185DD0AFF5C338269EF99D75621B305E875BD5D171FA12BC0A305F55D7C8A443E1B17CA7CEC3E19856F671A41FD0E9C42F86059DC08E4A56B2B265C941EC07F57647B146D21870B6EAF7B1E302C8CCA80EB856ADDEC953753E27F2214854A1C430EE01967A886AEF84C2E4564B5507D5A0BC8A07D2F4BC31F6D236F8A6D14155D86A610B17E5D55A5D7F572A8A2F7B4842951B6A29B8F260D94E0E25E1F49866DF6A048C69D29A48BDFB4A944E0F23EB4967786F276E2B045BB695F39DB44E4CBC16F20E8061FC2FAF5CE3564594FBA1087828DF7544CF8F18BC47B5F4BCEB63C493572197EC638279CC3E19E7E92C357E211FEC5470C6B08193BD766D46E61FE785A3CC64AB50D428DC75A72BA27111FB85546B5F264226ABF850672331A405B392D9E0899A3A63A9E25241CACCA91F4B34CB200E5E98F751B61FA7A5639184C559DD8FD6C282E728EC3D34EEE443B056B142AEED8DF39B70010CA5AE9F35415E24155ED66FF9387273F77773BB65BD7358CC778D361D90D5036B641BB62D897B5FC41BED0672C0';
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
	public function checkOut() {
		$cUrl = new Core_Dom_Curl(array(
			'method' => 'GET',
			'cookie' => $this->cookie
		));
		$content = $cUrl->getContent('http://www.yes24.vn/Event/2013/san-hang-gio-vang-san-pham.aspx');
		$content = file_get_contents(PATH_LOG_FILES.'test.html');
		$doc = Core_Dom_Query::newDocumentHTML($content,'UTF-8');
		$links = array(
			'http://www.yes24.vn/Display/MobileProductDetail.aspx?ProductNo=851780',
			'http://www.yes24.vn/Display/MobileProductDetail.aspx?ProductNo=965746',
			'http://www.yes24.vn/Display/MobileProductDetail.aspx?ProductNo=944874',
		);
		$array = array();
		foreach ($doc['input[type=text]'] as $textbox) {
			$textbox = pq($textbox);
			$name = trim($textbox->attr("name"));
			$array[] = $name;
		}
		if(empty($array)) {
			die('Please wait');
		}
		//$action = trim($doc->find('form')->attr('action'));
		$post_data = $doc->find('form')->serializeArray();
		$post_items = array();
		$index = 0;
		foreach ($post_data as $item) {
			$value = $item['name'] . '='.$item['value'];
			if(in_array($item['name'], $array)) {
				if($index >= 3) {
					$imageCapcha = $doc->find('form img')->get(0)->getAttribute('src');
					//$imageCapcha = 'http://www.yes24.vn/Upload/ProductImage/KnKFashion/1012402_M.jpg';
					$params = parse_url($imageCapcha);
					if(empty($params['scheme'])) {
						$imageCapcha = 'http://www.yes24.vn'.$imageCapcha;
					}
					$cUrl = new Core_Dom_Curl(array(
						'method' => 'GET',
						'url' => $imageCapcha,
						'cookie' => $this->cookie,
					));
					//$capchaFile = PATH_LOG_FILES.'capcha.jpg';
					$image = $cUrl->getImage();
					$capchaFile = Core_Utils_Tools::getImageFromUrl($image, PATH_LOG_FILES, 'capcha');
					exec($capchaFile);
					echo "{$item['name']}="; // Output - prompt user
					$captcha = fgets(STDIN);
					$value = $item['name'] . '=' .$captcha;
				} else {
					$value = $item['name'] . '=' . $links[$index];
					echo $value.PHP_EOL;
					$index++;
				}
			}
			$post_items[] = $value;			
			
		}
		$post_string = implode ('&', $post_items);
		//die($post_string);
		$cUrl = new Core_Dom_Curl(array(
			'method' => 'POST',
			'post_fields' => $post_string,
			'url' => 'http://www.yes24.vn/Event/2013/san-hang-gio-vang-san-pham.aspx',
			'cookie' => $this->cookie
		));
		$result = $cUrl->exec();
		Core_Utils_Tools::openHtml($result['body'], PATH_LOG_FILES.'result.html');
	}
	
	public function start() {
		/*$content = file_get_contents(PATH_LOG_FILES.'test.html');
		$doc = Core_Dom_Query::newDocumentHTML($content,'UTF-8');
		$links = array(
			'link1',
			'link2',
			'link3'
		);
		$array = array();
		foreach ($doc['input[type=text]'] as $textbox) {
			$textbox = pq($textbox);
			$name = trim($textbox->attr("name"));
			$array[] = $name;
		}
		if(empty($array)) {
			die('Please wait');
		}
		$post_data = $doc->find('#form1')->serializeArray();
		$post_items = array();
		$index = 0;
		foreach ($post_data as $item) {
			$value = $item['name'] . '='.$item['value'];
			if(in_array($item['name'], $array)) {
				if($index >= 3) {
					$imageCapcha = $doc->find('#form1 img')->get(0)->getAttribute('src');
					//$imageCapcha = 'http://www.yes24.vn/Upload/ProductImage/KnKFashion/1012402_M.jpg';
					$params = parse_url($imageCapcha);
					if(empty($params['scheme'])) {
						$imageCapcha = 'http://www.yes24.vn'.$imageCapcha;
					}
					$cUrl = new Core_Dom_Curl(array(
						'method' => 'GET',
						'url' => $imageCapcha,
						'cookie' => $this->cookie,
					));
					//$capchaFile = PATH_LOG_FILES.'capcha.jpg';
					$image = $cUrl->getImage();
					$capchaFile = Core_Utils_Tools::getImageFromUrl($image, PATH_LOG_FILES, 'capcha');
					exec($capchaFile);
					echo "{$item['name']}="; // Output - prompt user
					$captcha = fgets(STDIN);
					$value = $item['name'] . '=' .$captcha;
					$index = 0;
				} else {
					$value = $item['name'] . '=' . $links[$index];
					echo $value.PHP_EOL;
					$index++;
				}
			}
			$post_items[] = $value;			
			
		}
		print_r($post_items);
		die;*/
		$this->checkOut();
	}
}

