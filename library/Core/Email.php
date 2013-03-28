<?php
class Core_Email
{
	var $senders = array(
		array(
			'email' => SENDER_EMAIL,
			'password' => SENDER_EMAIL_PASSWORD,
		),
		array(
			'email' => 'no-reply-01@jobbid.vn',
			'password' => SENDER_EMAIL_PASSWORD,
		),
		array(
			'email' => 'no-reply-02@jobbid.vn',
			'password' => SENDER_EMAIL_PASSWORD,
		),
		array(
			'email' => 'no-reply-03@jobbid.vn',
			'password' => SENDER_EMAIL_PASSWORD,
		),
		array(
			'email' => 'no-reply-04@jobbid.vn',
			'password' => SENDER_EMAIL_PASSWORD,
		)
	);
	private static $_mail;
	public function __construct() {
		if(self::$_mail == null) {
			$rand_key = array_rand($this->senders);
			$sender = $this->senders[$rand_key];
			$config = array(
		        'auth' => 'login', 
		        'username' => $sender['email'], 
		        'password' => $sender['password'],
	        	'port' => SENDER_EMAIL_PORT,
	        	'ssl' => 'ssl'
	        );
	        $transport = new Zend_Mail_Transport_Smtp(SENDER_EMAIL_SMTP, $config);
	        Zend_Mail::setDefaultTransport($transport); 
	        Zend_Mail::setDefaultFrom($sender['email'], SENDER_EMAIL_FROM);
			Zend_Mail::setDefaultReplyTo(REPLY_TO_EMAIL,SENDER_EMAIL_FROM);	
			self::$_mail = new Zend_Mail('UTF-8');	
		}
	}
	public function send ($to,$subject,$content)
    {
    	if(empty($to) || empty($content))
    		return;
    	self::$_mail->setHeaderEncoding(Zend_Mime::ENCODING_BASE64);
    	self::$_mail->setBodyHtml($content);
    	if(is_array($to)) {
    		foreach ($to as $email)
    			self::$_mail->addBcc($email);
    	} else
        	self::$_mail->addTo($to);
        self::$_mail->setSubject($subject);
        self::$_mail->send();
    }
	
}
?>