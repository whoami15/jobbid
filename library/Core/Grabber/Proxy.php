<?php
class Core_Grabber_Proxy
{	
	var $_proxySite = 'http://www.freeproxylists.net/';
	public static function callback($data) {
		$_tmp = $data[0];
		$_hex = $data[1];
		return chr(intval($_hex,16));
	}
	public static function decodeIp($enc_ip)
	{
		$matches = array();
		preg_match_all('/\(\"(.*?)\"\)/',$enc_ip, $matches);
		if(!isset($matches[0])) return '';
		$enc_ip = $matches[0];
		$enc_ip = preg_replace('/\+/', "\x20", $enc_ip);
		$enc_ip = preg_replace_callback(' /%([a-fA-F0-9][a-fA-F0-9])/', 'Core_Grabber_Proxy::callback', $enc_ip);
		$doc = Core_Dom_Query::newDocumentHTML($enc_ip[0]);
		return $doc->find('a')->get(0)->textContent;
	}
	
	public function updateProxy() {
		$html = Core_Dom_Query::getContent($this->_proxySite);
		$doc = Core_Dom_Query::newDocumentHTML($html);
		if($doc['.DataGrid']->count() == 0) {
			Core_Utils_Tools::error('Get proxy error',Zend_Log::EMERG);
			return;
		}
		foreach($doc['.DataGrid tr:not(.Caption)]'] as $tr) {
			$tds = pq($tr)->find('td');
			if($tds->count() < 8) continue;
			$td1 = $tds->get(0);
			$enc_ip = trim(pq($td1)->find('script')->text());
			$ip = Core_Grabber_Proxy::decodeIp($enc_ip);
			$port = trim($tds->get(1)->textContent);
			if(Core_Utils_Tools::checkConnection($ip, $port) == true) {
				Core_Utils_Tools::log('IP : '.$ip.' => Good');
				Worker_Model_Proxy::getInstance()->updateProxy($ip,$port);
			} else {
				Core_Utils_Tools::log('IP : '.$ip.' => Bad');
			}
			echo PHP_EOL;
		}
	}
	
	
}