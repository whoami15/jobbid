<?php
class Core_Controller_Helper_EmailUtils
{
	public static function fillDataIntoDatTiecTemplate($data,$foods) {
		try {
			$cache = zendcms_Controller_Helper_Utils::loadCache();
			if(($settings = $cache->load('settings')) == null) die('ERROR');
			if(($email_dattiec = $settings['email_dattiec']) == null) die('ERROR');
			$db = new front_Model_DbTable_EmailTemplate();
			$template = $db->findByName('dat-tiec');
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
				$template->content
			);
			$sendmail = new zendcms_Controller_Helper_SendMail();
			$sendmail->send($email_dattiec, $template->subject, $content);
		} catch (Exception $e) {
			die('ERROR');
		}
		
	}
     
}
?>