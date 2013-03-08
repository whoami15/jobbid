<?php

class Core_Controller_Plugin_Selector extends Zend_Controller_Plugin_Abstract {
	public function preDispatch (Zend_Controller_Request_Abstract $request)
    {
       $params = $request->getParams();
       if($params['controller'] == 'duan' && $params['action'] == 'view') {
       		header('job/view-job/vng-tuyen-marketing-online-executive?id=8');
       		/* $request->setDispatched(true);
       		//$this->_response->s
       		$request->setParams(array(
       			'controller' => 'job',
       			'action' => 'view-job',
       			'id' => 8		
       		)); */
       		//$this->_response->setRedirect('job/view-job/vng-tuyen-marketing-online-executive?id=8')->sendResponse();
       }
        //die('Language : '.$lang);
       /* if ($lang !== 'en' && $lang !== 'vi') {
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
        Zend_Registry::set('Zend_Locale', $zl);*/
        /*$translator = new Zend_Translate('csv', 
        APPLICATION_PATH . '/configs/lang/' . $lang . '.csv', $lang);
        Zend_Registry::set('Zend_Translate', $translator);*/
    }
}

?>