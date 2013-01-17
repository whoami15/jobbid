<?php
class zendcms_Controller_Helper_SendMail
{
	private $_mail;
	public function __construct() {
		$cache = zendcms_Controller_Helper_Utils::loadCache();
		if(($settings = $cache->load('settings')) == null) die('ERROR');
		if(($sender = $settings['sender']) == null) die('ERROR');
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
		$this->_mail = new Zend_Mail('UTF-8');	
	}
	public function send ($to,$subject,$content)
    {
    	if(empty($to) || empty($content))
    		return;
    	$this->_mail->setHeaderEncoding(Zend_Mime::ENCODING_BASE64);
    	$this->_mail->setBodyHtml($content);
    	if(is_array($to)) {
    		foreach ($to as $email)
    			$this->_mail->addBcc($email);
    	} else
        	$this->_mail->addTo($to);
        $this->_mail->setSubject($subject);
        $this->_mail->send();
    }
	public function sendDatTiecEmail($data,$foods) {
		try {
			$cache = zendcms_Controller_Helper_Utils::loadCache();
			if(($settings = $cache->load('settings')) == null) die('ERROR');
			if(($email_dattiec = $settings['email_dattiec']) == null) die('ERROR');
			$template = $cache->load('mail_temp_2');
			if($template == null) die('ERROR');
			$html = new Zend_View();
			$html->setScriptPath(APPLICATION_PATH . '/layouts/scripts/templates/');
			
			// assign valeues
			$html->assign('foods', $foods);
			
			// render view
			$data['foods'] = $html->render('list-food.phtml');
			
			Zend_Registry::set('rep', $data);
			$content = preg_replace_callback(
				'/\[\[(.*?)\]\]/', 
				array('zendcms_Controller_Helper_Utils','preg_replace_callback'),
				$template['content']
			);
			$this->send($email_dattiec, $template['subject'], $content);
		} catch (Exception $e) {
			die('ERROR');
		}
	}
	public function sendVerifyEmail($email,$data) {
		try {
			$cache = zendcms_Controller_Helper_Utils::loadCache();
			if(($settings = $cache->load('settings')) == null) die('ERROR');
			$template = $cache->load('mail_temp_2');
			if($template == null) die('ERROR');
			Zend_Registry::set('rep', $data);
			$content = preg_replace_callback(
				'/\[\[(.*?)\]\]/', 
				array('zendcms_Controller_Helper_Utils','preg_replace_callback'),
				$template['content']
			);
			$this->send($email, $template['subject'], $content);
		} catch (Exception $e) {
			die($e->getMessage());
		}
	}
	public function sendEmailByTemplate($email,$data,$template_id) {
		try {
			$cache = zendcms_Controller_Helper_Utils::loadCache();
			if(($settings = $cache->load('settings')) == null) die('ERROR');
			$template = $cache->load('mail_temp_'.$template_id);
			if($template == null) die('ERROR');
			Zend_Registry::set('rep', $data);
			$content = preg_replace_callback(
				'/\[\[(.*?)\]\]/', 
				array('zendcms_Controller_Helper_Utils','preg_replace_callback'),
				$template['content']
			);
			$this->send($email, $template['subject'], $content);
		} catch (Exception $e) {
			die($e->getMessage());
		}
	}
	
}
?>