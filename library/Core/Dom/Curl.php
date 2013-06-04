<?php
class Core_Dom_Curl
{
	protected static $_instance = null;
	public static function getInstance($params){
		//Check instance
		if(empty(self::$_instance)){
			self::$_instance = new Core_Dom_Curl($params);
		}
	
		//Return instance
		return self::$_instance;
	}
    private $ch;
    /**
     * Init curl session
     * 
     * $params = array('url' => '',
     *                    'host' => '',
     *                   'header' => '',
     *                   'method' => '',
     *                   'referer' => '',
     *                   'cookie' => '',
     *                   'post_fields' => '',
     *                    ['login' => '',]
     *                    ['password' => '',]      
     *                   'timeout' => 0
     *                   );
     */      
    public function  __destruct() {
    	//echo 'Core_Dom_Curl::__destruct'.PHP_EOL;
    }          
    
    public function __construct($params)
    {
    	$this->ch = Core_Utils_Tools::initCurl($params);
    }
    
    /**
     * Make curl request
     *
     * @return array  'header','body','curl_error','http_code','last_url'
     */
    public function exec($return = true)
    {
        $response = curl_exec($this->ch);
        if($return) {
	        $cookie = '';
	        preg_match('/^Set-Cookie:\s*([^;]*)/mi', $response, $m);
	        if(isset($m[1]))
	        	parse_str($m[1], $cookie);
	        $error = curl_error($this->ch);
	        $result = array( 'header' => '', 
	                         'body' => '', 
	                         'curl_error' => '', 
	                         'http_code' => '',
	                         'last_url' => '');
	        if ( $error != "" )
	        {
	            $result['curl_error'] = $error;
	            return $result;
	        }
	        
	        $header_size = curl_getinfo($this->ch,CURLINFO_HEADER_SIZE);
	        $result['header'] = substr($response, 0, $header_size);
	        $result['body'] = substr( $response, $header_size );
	        $result['http_code'] = curl_getinfo($this -> ch,CURLINFO_HTTP_CODE);
	        $result['last_url'] = curl_getinfo($this -> ch,CURLINFO_EFFECTIVE_URL);
	        $result['cookie'] = $cookie;
	        //curl_close($this->ch);
	        return $result;
        }
    }
    
    public function getContent($url) {
    	@curl_setopt( $this -> ch, CURLOPT_URL, $url);
    	/* $params = array(
    		'url' => $url,
    		'method' => 'GET',
    		'header' => $header
    	); */
    	//$cUrl->init($params);
    	$result = $this->exec();
    	if(!empty($result['curl_error'])) {
    		throw new Exception('(Curl error) Failed to get content ('.$url.'), Error => '.$result['curl_error']);
    	}
    	if ($result['http_code']!='200'){
    		throw new Exception('(Error 200) Failed to get content ('.$url.')');
    		//throw new Exception("HTTP Code = ".$result['http_code']);
    	}
    	$content = $result['body'];
    	if(mb_detect_encoding($content,'UTF-8',true) != 'UTF-8') {
    		$content = Core_Encoding::toUTF8($content);
    	}
    	return $content;
    }
    public function request($url) {
    	@curl_setopt( $this -> ch, CURLOPT_URL, $url);
    	$this->exec();
    }
    public function getImage() {
    	//@curl_setopt( $this -> ch, CURLOPT_URL, $url);
    	@curl_setopt($this -> ch, CURLOPT_RETURNTRANSFER, 1);
		@curl_setopt($this -> ch, CURLOPT_BINARYTRANSFER, 1);
		$result = $this->exec();
		curl_close($this -> ch);
		return $result['body'];;
    }
    public function setOpt($name,$value) {
    	@curl_setopt($this -> ch, $name, $value);
    }
	public function multiRequests($params,$times,$delay=1) {
	   	$curlMultiHandle = curl_multi_init();
	    $curlHandles = array();
	    $responses = array();
		$i = 0;
		while($i < $times) {
			$curlHandles[$i] = Core_Utils_Tools::initCurl($params);
	        curl_multi_add_handle($curlMultiHandle, $curlHandles[$i]);
			$i++;
		}
	
	    $running = null;
	    do {
	    	$ready=curl_multi_select($curlMultiHandle);
	        $rv=curl_multi_exec($curlMultiHandle, $running);
	        echo 'rv= '.$rv.'; ready = '.$ready.PHP_EOL;
	    } while($running > 0);
		print_r(curl_multi_info_read($curlMultiHandle));
	    foreach($curlHandles as $id => $handle) {
	        $responses[$id] = curl_multi_getcontent($handle);
	        curl_multi_remove_handle($curlMultiHandle, $handle);
	    }
	    curl_multi_close($curlMultiHandle);
	    return $responses;
	}
}
