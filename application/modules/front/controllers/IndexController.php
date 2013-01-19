<?php

class Front_IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    	$this->_helper->layout->setLayout('front_layout');
    }

    public function indexAction()
    {
        // action body
        $form = new Front_Form_Search();
        $this->view->form = $form;
        $cityId = $this->_request->getParam('city_id','');
        $keyword = $this->_request->getParam('keyword','');
        $this->view->jobs = Application_Model_DbTable_Job::findAll(array(
        	'city_id' => $cityId,
        	'keyword' => trim($keyword)
        ),1);
        //if($this->_request->isPost()) {
        	$form->populate($this->_request->getParams());
       // }
    }


}

