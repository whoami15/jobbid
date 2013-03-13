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
        $this->ch = curl_init();
        @curl_setopt ( $this -> ch , CURLOPT_RETURNTRANSFER , 1 );
        $user_agent = 'Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)';
        if(!isset($params['header']) || empty($params['header'])) {
        	$header = array(
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
    		);
        } else {
        	$header = $params['header'];
        }
        if (isset($params['host']) && $params['host'])      $header[]="Host: ".$params['host'];
        
        //@curl_setopt ( $this -> ch , CURLOPT_VERBOSE , 1 );
        @curl_setopt ( $this -> ch , CURLOPT_HEADER , 1 );
        if(isset($params['proxy'])) {
        	curl_setopt($this -> ch, CURLOPT_PROXY, $params['proxy']);
        }
        if ($params['method'] == "HEAD") @curl_setopt($this -> ch,CURLOPT_NOBODY,1);
        @curl_setopt ( $this -> ch, CURLOPT_FOLLOWLOCATION, 1);
        @curl_setopt ( $this -> ch , CURLOPT_HTTPHEADER, $header );
        if (isset($params['referer']))    @curl_setopt ($this -> ch , CURLOPT_REFERER, $params['referer'] );
        @curl_setopt ( $this -> ch , CURLOPT_USERAGENT, $user_agent);
        if (! file_exists(PATH_COOKIE) || ! is_writable(PATH_COOKIE))
        {
        	echo 'Create cookie file...';
        	$ourFileHandle = fopen(PATH_COOKIE, 'w') or die("can't open file");
        	fclose($ourFileHandle);
        }
        @curl_setopt($this -> ch, CURLOPT_COOKIEFILE, PATH_COOKIE);
        @curl_setopt($this -> ch, CURLOPT_COOKIEJAR, PATH_COOKIE);

        if ( $params['method'] == "POST" )
        {
            curl_setopt( $this -> ch, CURLOPT_POST, true );
            curl_setopt( $this -> ch, CURLOPT_POSTFIELDS, $params['post_fields'] );
        }
        @curl_setopt ( $this -> ch , CURLOPT_SSL_VERIFYPEER, 0 );
        @curl_setopt ( $this -> ch , CURLOPT_SSL_VERIFYHOST, 0 );
        @curl_setopt($this -> ch,CURLOPT_ENCODING , "gzip");
        if (isset($params['login']) & isset($params['password']))
            @curl_setopt($this -> ch , CURLOPT_USERPWD,$params['login'].':'.$params['password']);
        @curl_setopt ( $this -> ch , CURLOPT_TIMEOUT, TIME_OUT);
    }
    
    /**
     * Make curl request
     *
     * @return array  'header','body','curl_error','http_code','last_url'
     */
    public function exec()
    {
        $response = curl_exec($this->ch);
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
        //curl_close($this->ch);
        return $result;
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
}
