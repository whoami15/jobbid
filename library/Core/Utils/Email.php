<?php
class Core_Utils_Email
{
	public static function render($template_name,$data) {
		try {
			$html = new Zend_View();
			$html->setScriptPath(APPLICATION_PATH . '/layouts/scripts/templates/email/');
			// assign valeues
			$html->assign('data', $data);
			// render view
			return $html->render($template_name);
		} catch (Exception $e) {
			die('ERROR');
		}
		
	}
     
}
?>