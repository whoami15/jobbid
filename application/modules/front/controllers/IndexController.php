<?php

class Front_IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    	$this->_helper->layout->setLayout('front_layout');
    	$this->session = new Zend_Session_Namespace('session');
    	$this->session->visitor = Application_Model_DbTable_Visitor::getVisitor($this->session->logged);
    	$this->session->url = Core_Utils_Tools::getFullURL();
    }

    public function indexAction()
    {
        // action body
        $form = new Front_Form_Search();
        $this->view->form = $form;
        $cityId = $this->_request->getParam('city_id','');
        $page = $this->_request->getParam('p',1);
        $keyword = $this->_request->getParam('keyword','');
        $totalRows = 0;
        $this->view->jobs = Application_Model_DbTable_Job::findAll(array(
        	'city_id' => $cityId,
        	'keyword' => trim($keyword)
        ),$page,$totalRows);
        $this->view->page = $page;
        $this->view->totalPage = ceil($totalRows/SEARCH_PAGE_SIZE);
        $this->view->url = "/?keyword=$keyword&city_id=$cityId";
        //if($this->_request->isPost()) {
        	$form->populate($this->_request->getParams());
       // }
    }


}

