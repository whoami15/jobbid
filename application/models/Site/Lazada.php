<?php

class Application_Model_Site_Lazada
{
	protected static $_instance = null;
	var $cookie = '';
	public static function getInstance($className=__CLASS__){
		//Check instance
		if(empty(self::$_instance)){
			self::$_instance = new $className;
		}
		//Return instance
		return self::$_instance;
	}
	public function __construct($cookie){
		if(empty($cookie)) die('cookie empty');
		$this->cookie = 'Cookie: '.$cookie; 
		 
	}
	public function getContent($url) {
		if(empty($url)) $url='http://www.lazada.vn';
		$url = trim($url);
		$cUrl = new Core_Dom_Curl(array(
			'method' => 'GET',
			'cookie' => $this->cookie
		));
		return $cUrl->getContent($url);
	}
	public function checkOut() {
		$cUrl = new Core_Dom_Curl(array(
			'method' => 'GET',
			'cookie' => $this->cookie
		));
		$content = $cUrl->getContent('https://www.lazada.vn/checkout/finish');
		//Core_Utils_Log::write($content);die;
		$doc = Core_Dom_Query::newDocumentHTML($content,'UTF-8');
		if($doc->find('#removevoucher')->length == 0) {
			$post_data = $doc->find('form')->serializeArray();
			$post_data[] = array(
				'name' => 'selectTranslation',
				'value' => 1
			);
			//print_r($post_data);die;
			$array = array(
				'couponcode' => '1SUBS71TC3It',
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
			$cUrl = new Core_Dom_Curl(array(
				'header' => array(
					'Accept: application/json, text/javascript, */*; q=0.01',
					'Accept-Encoding: gzip, deflate',
					'Accept-Language: en-US,en;q=0.5',
					//'Content-Length: 750',
					'Content-Type: application/x-www-form-urlencoded; charset=UTF-8',
					'Host: www.lazada.vn',
					'Referer: https://www.lazada.vn/checkout/finish/',
					'User-Agent: Mozilla/5.0 (Windows NT 6.1; rv:20.0) Gecko/20100101 Firefox/20.0',
					'X-Requested-With: XMLHttpRequest',
					$this->cookie
				),
				'method' => 'POST',
				'post_fields' => $post_string,
				'url' => 'https://www.lazada.vn/checkout/finishajax/processlocations/',
				'cookie' => $this->cookie
			));
			$result = $cUrl->exec();
			$result = json_decode($result['body'],true);
			$doc->find('#checkout-payment')->html($result['payments']);
			$doc->find('#checkoutGrandTotal')->html($result['cart']);
		}
		if($doc->find('#removevoucher')->length > 0) { //su dung coupon thanh cong
			$post_data = $doc->find('form')->serializeArray();	
			$array = array(
				'send' => 1,
				'YII_CSRF_TOKEN' => 'XXX',
				'loggedInCustomer' => 1,
				'billingAddressId' => 'XXX',
				'shippingAddressDifferent' => 1,
				'PaymentMethod[empty]' => 1,
				'PaymentMethodForm[payment_method]' => 'CashOnDelivery',
				'PaymentMethodForm[parameter][cc_type]' => '',
				'PaymentMethodForm[parameter][cc_holder]' => '',
				'PaymentMethodForm[parameter][cc_number]' => '',
				'PaymentMethodForm[parameter][cc_security_code]' => '',
				'PaymentMethodForm[parameter][session_id]' => 'XXX',
				'PaymentMethodForm[parameter][ic_number]' => '',
				'PaymentMethodForm[parameter][mi_cc_holder_mobile]' => '',
				'PaymentMethodForm[parameter][mi_cc_holder_name]' => '',
				'PaymentMethodForm[parameter][mi_cc_number_partial]' => '',
				'PaymentMethodForm[parameter][manualinstallmentscc]' => 1,
				'PaymentMethodForm[parameter][mi_cc_bank]' => 0,
				'PaymentMethodForm[parameter][mi_cc_type]' => '',
				'PaymentMethodForm[parameter][mi_cc_holder]' => '',
				'PaymentMethodForm[parameter][mi_cc_number]' => '',
				'PaymentMethodForm[parameter][mi_cc_security_code]' => '',
				'PaymentMethodForm[parameter][mi_terms_conditions]' => 0,
				'PaymentMethodForm[parameter][mi_terms_conditions]' => 1,
				'TaxInfoForm[tax_name]' => '',
				'TaxInfoForm[tax_address]' => '',
				'TaxInfoForm[tax_code]' => '',
				'applyInstallments[]' => 1
			);
			foreach ($post_data as $item) {
				if(isset($array[$item['name']]) && $array[$item['name']] == 'XXX') {
					$array[$item['name']] = $item['value'];
				} 
			}
			$post_items = array();
			foreach ($array as $name=>$value) {
				$post_items[] = $name.'='.$value;
			}
			$cUrl = new Core_Dom_Curl(array(
				'method' => 'POST',
				'post_fields' => implode ('&', $post_items),
				'url' => 'https://www.lazada.vn/checkout/finish/',
				'cookie' => $this->cookie
			));
			$result = $cUrl->exec();
			return $result['http_code'];
		}
		return false;
		//print_r($result);die;
		//echo $result['body'];
		//print_r($post_data);die;
		//Core_Utils_Log::write($result['body']);
		//die('OK');
	}
	
	public function start() {
		return $this->checkOut();
	}
}

