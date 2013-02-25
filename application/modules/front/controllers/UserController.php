<?php

class Front_UserController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    	$this->_helper->layout->setLayout('test_layout');
    	//$this->_helper->layout->disableLayout();
    }

    public function registrationAction()
    {
    	if ($_REQUEST) {
    		echo '<p>signed_request contents:</p>';
    		$response = parse_signed_request($_REQUEST['signed_request'],
    				FACEBOOK_SECRET);
    		echo '<pre>';
    		print_r($response);
    		echo '</pre>';
    		die;
    	} else {
    		//echo '$_REQUEST is empty';
    	}
    }


}

