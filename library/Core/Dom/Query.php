<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Brand
 *
 * @author qunguyen
 */
require_once 'Core/Dom/phpQuery.php';
class Core_Dom_Query extends phpQuery {
    //put your code here
    public static function getDom($url,$proxy = null,$opts = null) {
    	$context = null;
    	if($opts == null) {
    		$opts = array(
    				'http' => array(
    						'method'=>"GET",
    						'header'=>implode("\r\n",
    								array(
    										'Content-Type : text/html; charset=utf-8',
    										'Accept: text/html, */*; q=0.01',
    										'Accept-Encoding: gzip, deflate',
    										'Accept-Language: en-US,en;q=0.5',
    										'Connection: keep-alive',
    										'Content-Type: application/x-www-form-urlencoded',
    										'From: googlebot(at)googlebot.com',
    										'DNT: 1',
    										'User-Agent: Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)',
    										'X-Requested-With: 	XMLHttpRequest'
    								)
    						)
    				)
    		);
    	}
    	if($proxy!=null) {
    		$opts = array(
    			'http' => array(
    				'proxy' => "tcp://{$proxy['ip']}:{$proxy['port']}",
    				'request_fulluri' => true,
    				'method'=>"GET",
    				'header'=>implode("\r\n",
    						array(
    								'Content-Type : text/html; charset=utf-8',
    								'Accept: text/html, */*; q=0.01',
    								'Accept-Encoding: gzip, deflate',
    								'Accept-Language: en-US,en;q=0.5',
    								'Connection: keep-alive',
    								'Content-Type: application/x-www-form-urlencoded',
    								'From: googlebot(at)googlebot.com',
    								'DNT: 1',
    								'User-Agent: Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)',
    								'X-Requested-With: 	XMLHttpRequest'
    						)
    				)
    			),
    		);
    	}
    	$context = stream_context_create($opts);
    	return self::newDocumentFileHTML($url,'UTF-8',$context);
    }
    
    public static function getContent($url,$proxy = null) {
    	$context = null;
    	$opts = array(
    			'http' => array(
    					'method'=>"GET",
    					'header'=>implode("\r\n",
    							array(
    									'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
    									'Accept-Encoding: gzip, deflate',
    									'Accept-Language: en-US,en;q=0.5',
    									'Connection: keep-alive',
    									'DNT: 1',
    									'Cookie: hl=en; pv=15; userno=20130118-010942; from=google; refdomain=www.google.com.vn; __utma=251962462.1446837795.1358476791.1359008289.1359082924.4; __utmz=251962462.1358476791.1.1.utmcsr=google|utmccn=(organic)|utmcmd=organic|utmctr=(not%20provided); __atuvc=6%7C3%2C6%7C4; __utmv=251962462.Vietnam; key=key; __utmb=251962462.10.10.1359082924; __utmc=251962462',
    									'User-Agent: Mozilla/5.0 (Windows NT 6.1; WOW64; rv:18.0) Gecko/20100101 Firefox/18.0'
    							)
    					)
    			)
    	);
    	if($proxy!=null) {
    		$opts = array(
    			'http' => array(
    				'proxy' => "tcp://{$proxy['ip']}:{$proxy['port']}",
    				'request_fulluri' => true,
    				'method'=>"GET",
    				'header'=>implode("\r\n",
    						array(
    								'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
    								'Accept-Encoding: gzip, deflate',
    								'Accept-Language: en-US,en;q=0.5',
    								'Connection: keep-alive',
    								'DNT: 1',
    								'Cookie: hl=en; pv=15; userno=20130118-010942; from=google; refdomain=www.google.com.vn; __utma=251962462.1446837795.1358476791.1359008289.1359082924.4; __utmz=251962462.1358476791.1.1.utmcsr=google|utmccn=(organic)|utmcmd=organic|utmctr=(not%20provided); __atuvc=6%7C3%2C6%7C4; __utmv=251962462.Vietnam; key=key; __utmb=251962462.10.10.1359082924; __utmc=251962462',
    								'User-Agent: Mozilla/5.0 (Windows NT 6.1; WOW64; rv:18.0) Gecko/20100101 Firefox/18.0'
    						)
    				)
    			),
    		);
    	}
    	$context = stream_context_create($opts);
    	$html = file_get_contents($url,False,$context);
    	$len = strlen($html);
    	if ($len < 18 || strcmp(substr($html,0,2),"\x1f\x8b")) {
    	} else {
    		$html = Core_Utils_Tools::gzdecode($html);
    	}
    	return $html;
    }
}

?>
