<?php

class Core_Controller_Plugin_LangSelector extends Zend_Controller_Plugin_Abstract {
	public function preDispatch (Zend_Controller_Request_Abstract $request)
    {
        $lang = $request->getParam('lang', '');
        //die('Language : '.$lang);
        //var_dump($request->getParams());
       	//die();
        if ($lang !== 'en' && $lang !== 'vi') {
            $request->setParam('lang', DEFAULT_LANG);
        }
        $lang = $request->getParam('lang');
        if ($lang == 'en') {
            $locale = 'en_US';
        } else {
            $locale = 'vi_VN';
        }
        $zl = new Zend_Locale();
        $zl->setLocale($locale);
        Zend_Registry::set('Zend_Locale', $zl);
        /*$translator = new Zend_Translate('csv', 
        APPLICATION_PATH . '/configs/lang/' . $lang . '.csv', $lang);
        Zend_Registry::set('Zend_Translate', $translator);*/
    }
}

?>