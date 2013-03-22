<?php

class Front_MessageController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    	$this->_helper->layout->setLayout('front_layout');
    }

    public function successAction()
    {
        // action body
        try {
	        $type = $this->_request->getParam('type','');
	        switch ($type) {
	        	case 'post-job':
	        		$email = $this->_request->getParam('email','');
	        		if(empty($email)) throw new Core_Exception('LINK_ERROR');
	        		$this->view->email = $email;
	        		$this->renderScript('/message/success-post-job.phtml');
	        	break;
	        	case 'cancel-job':
	        		$this->renderScript('/message/success-cancel-job.phtml');
	        	break;
	        	default:
	        		;
	        	break;
	        }
        } catch (Exception $e) {
        	$this->view->error_msg = Core_Exception::getErrorMessage($e);
        	$this->_forward('error','message','front');
        }
        
    	
    }
	public function errorAction()
    {
        $this->_helper->layout->setLayout('front_layout');
    }

}

