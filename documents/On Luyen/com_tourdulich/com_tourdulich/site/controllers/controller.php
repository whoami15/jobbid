<?php
defined('_JEXEC')or die('Restricted Access'); 
jimport('joomla.application.component.controller');
class TourdulichControllerTourdulich extends JController {
    function __construct() {
        parent::__construct();
    }
    function display() {
        $view =   $this->getView('tourdulich', 'html');
        $model =   $this->getModel('tourdulich');
        $view->setModel($model, true);
        $view->display();
    }
    function loaitour()
    {
        $loaitour_id=JRequest::getVar('loaitour_id');
        $view =   $this->getView('tourdulich', 'html');
        $model =   $this->getModel('tourdulich');
        $view->setModel($model, true);
        $view->loaitour($loaitour_id);
    }
    function tourlist()
    {
        $nhomtour_id=JRequest::getVar('nhomtour_id');
        $view =   $this->getView('tourdulich', 'html');
        $model =   $this->getModel('tourdulich');
        $view->setModel($model, true);
        $view->tourlist($nhomtour_id);
    }
    function tourdetail()
    {
        $id=JRequest::getVar('id');
        $view =   $this->getView('tourdulich', 'html');
        $model =   $this->getModel('tourdulich');
        $view->setModel($model, true);
        $view->tourdetail($id);
    }
}
?>