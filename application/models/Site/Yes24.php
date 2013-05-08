<?php

class Application_Model_Site_Yes24
{
	protected static $_instance = null;
	var $cookie = 'Cookie: 	__utma=49630894.93694764.1358998575.1359960953.1367980807.17; __utmz=49630894.1358998575.1.1.utmcsr=(direct)|utmccn=(direct)|utmcmd=(none); __atuvc=3%7C4%2C7%7C5; __utmb=49630894.15.10.1367980807; LoginIdChk=1; LoginId=nclong87; ASP.NET_SessionId=eb5vylzmxecu2t2v05civobh; __utmc=49630894; .YES24Front_AUTH=CF980250221B2A6E3ED2964E515E5AC0CC7D1CE225624784FC499AC8E622AF2FAE287FF72C8EC2A94CC0BA9E0335707C0ED3C8D52FC9090C9CB7FB8D45C23DE3085DD51E2A468F2BA10547586AEA8AC7E30A091BE3B75246E4D7EFFFBB91EC7E021EA0BC2CF85FA7EC19FD22991F074C76248C0623F9CDAE79FA844E261DC46242D626E6FD35BA9E3AB7FA8AAF262CCFDC1665169595D7ECB507CD6377952B9A564554CF6CBBA49F1D4A4460CD8E79A37B2497B2841303E64E40E2C51BD2B1ADABB57D5A2A431987600E12E82B11C678EF5DD8A3643A39C1B12524BBF1DF8C268C465B53FE3AF39686FE7D3FD5B6BD1074CF50A194C6DDE7181664DC398C6AD9C59D0BC911B153535771DFDEB80816D1271AD4AE3DED4116FF46686E94D3AD6C5DB832635A888CAA49CEDC26DCCCFB596810EA1F8100626094360E2A24A9F4A901CC824F1C5965F88843003D9C0DA1C7FAF935FE2CBAB3187AC83EFC6AEDD07AC8D30D1BB3C4827A40A4177F64AABB71AB2A62375AA5DD4D913E7FF4CB051688CF68256A3795052187BC123F9F4706A07E21C400102890D1482A11C67BE10F5100988871905F9BD230542314AD25D78871D9B01B964F7B8D72105908C37BAD643F9FB071DD325E34FB8B3693888E134A2E724B27520D78EA06886680003BBCA228767C4E6AE8860C782B90B52263EE4B0B7FCDF8B5E6131909B4D957D23B97EEAB192DBC30B6853E2B5863149F0442BAE28A745FF7D79459580815988587BB2FC1C033D2818CB5D68FFC5D86E76C5C1E0F315971EB34A3B825EC2DBDFB2C83CD8BE5A16DF3E1B85AE3D902852BD321D78B7EF3ABD845C759EA66E933574D847BD061E4C951A25B1232ED589639AD3C307A0170A76C80E72676759A9B63DBF3ED43836A5C74D72BCDCE88714519FD90660D73EADA0DBC005CF232FC0D0418B6DD4C0D2EB7557C8310C3D9F02ED456C70C96DD0C987EF8B17F50A93E8BE48E61D6799910676C645EF23378FFB7C88C86E70D29880C8D2C68938F63CEE0809DE97EEA37259EE9BA7A725F9327416691708D9568015964F5C88C18F70EBAF0352EAC25195AF98A062DD6B32568B44BB43E2B1D547C1AF28E54A7F60A9F61531D192FDC0BB81B5D1AFF07708A9ECC1CB2F87D3969D2E5D2722E8662927A9BC90751AEC2C1B03B';
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
		//$content = file_get_contents(PATH_LOG_FILES.'test.html');
		//Core_Utils_Log::write($content);die;
		
		$doc = Core_Dom_Query::newDocumentHTML($content,'UTF-8');
		
		$links = array(
			'http://www.yes24.vn/Display/MobileProductDetail.aspx?ProductNo=851780',
			'http://www.yes24.vn/Display/MobileProductDetail.aspx?ProductNo=965746',
			'http://www.yes24.vn/Display/MobileProductDetail.aspx?ProductNo=944874',
		);
		foreach ($doc['input[type=text]'] as $textbox) {
			$textbox = pq($textbox);
			$name = trim($textbox->attr("name"));
			$array[] = $name;
		}
		if(empty($array)) {
			die('Please wait');
		}
		$array = array(
				'txtProductCode1' => 'http://www.yes24.vn/Display/MobileProductDetail.aspx?ProductNo=851780',
				'txtProductCode2' => 'http://www.yes24.vn/Display/MobileProductDetail.aspx?ProductNo=965746',
				'txtProductCode3' => 'http://www.yes24.vn/Display/MobileProductDetail.aspx?ProductNo=944874',
		);
		//$action = trim($doc->find('form')->attr('action'));
		$post_data = $doc->find('form')->serializeArray();
		$post_items = array();
		$index = 0;
		$cUrl = new Core_Dom_Curl(array(
				'method' => 'GET',
				'cookie' => $this->cookie,
		));
		foreach ($post_data as $item) {
			if(isset($array[$item['name']])) {
				$post_items[] = $item['name'] . '=' . $array[$item['name']];
				$result = $cUrl->getContent('http://www.yes24.vn/Event/2013/san-hang-gio-vang-data.aspx?Product='.$array[$item['name']].'&ProductType=M&_='.time());
				echo $result;
			} else {
				$post_items[] = $item['name'] . '=' . $item['value'];
			}
			/* $value = $item['name'] . '='.$item['value'];
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
			$post_items[] = $value;	 */		
			
		}
		$post_string = implode ('&', $post_items);
		//die($post_string);
		$cUrl = new Core_Dom_Curl(array(
			'method' => 'POST',
			'post_fields' => 'Contentdata=<table border="0" cellpadding="0" cellspacing="0">        <tbody><tr>        <td>            <ul style="width:628px;">            <li class="draggable1"><img style="cursor: move; position: relative;" src="http://www.yes24.vn/Upload/ProductImage/YES24DTDD/851780_M.jpg" class="drag-image ui-draggable" id="draggable1"></li>            <li class="draggable2"><img style="cursor: move; position: relative;" src="http://www.yes24.vn/Upload/ProductImage/YES24DTDD/965746_M.jpg" class="drag-image ui-draggable" id="draggable2"></li>            <li class="draggable3"><img style="cursor: move; position: relative;" src="http://www.yes24.vn/Upload/ProductImage/YES24DTDD/944874_M.jpg" class="drag-image ui-draggable" id="draggable3"></li>        </ul>        </td>                </tr>        </tbody></table>',
			'url' => 'http://www.yes24.vn/Event/2013/san-hang-gio-vang-data.aspx?act=submit&hdPro1=851780&hdPro2=965746&hdPro3=944874',
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

