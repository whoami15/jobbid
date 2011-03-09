<?php
defined('_JEXEC') or die();
jimport('joomla.application.component.view');
class TourdulichViewTourdulich extends JView {
    function __construct() {
        parent::__construct();
    }
    function display($tpl = null) {
        $model=$this->getModel();
        $data=&$model->getList();
        $this->assignRef('data', $data);
        $lang=JRequest::getVar('lang');
        if(!isset($lang))
            $lang="";
        if($lang=="en")
            $this->setLayout('default-en');
        else
            $this->setLayout('default');
        parent::display($tpl=null);
    }
    function tourlist($nhomtour_id=null,$tpl = null) {
        $model=$this->getModel();
        $data=&$model->getTourList($nhomtour_id);
        $this->assignRef('data', $data);
        $data2=&$model->getNhomTour($nhomtour_id);
        $tmp=&$model->getDiemxuatphat($data2->diemxuatphat);
        $loaitour=&$model->getLoaiTour($tmp->loaitour);
        $this->assignRef('tourlistname', $data2->tennhomtour);
        $this->assignRef('loaitour', $loaitour);
        $lang=JRequest::getVar('lang');
        if(!isset($lang))
            $lang="";
        if($lang=="en")
            $this->setLayout('tourlist-en');
        else
            $this->setLayout('tourlist');
        parent::display($tpl=null);
    }
    function loaitour($loaitour_id=null,$tpl = null) {
        $model=$this->getModel();
        $data=&$model->getTourListByLoaiTour($loaitour_id);
        $data2=$model->getLoaiTour($loaitour_id);
        $this->assignRef('data', $data);
        $this->assignRef('loaitour', $data2);
        $lang=JRequest::getVar('lang');
        if(!isset($lang))
            $lang="";
        if($lang=="en")
            $this->setLayout('loaitour-en');
        else
            $this->setLayout('loaitour');
        parent::display($tpl=null);
    }
    function tourdetail($id=null,$tpl = null) {
        $model=$this->getModel();
        $data=&$model->getTour($id);
        $this->assignRef('data', $data);
        $data2=&$model->getContent($id);
        $this->assignRef('lstContent', $data2);
        $lang=JRequest::getVar('lang');
        if(!isset($lang))
            $lang="";
        if($lang=="en")
            $this->setLayout('tourdetail-en');
        else
            $this->setLayout('tourdetail');
        
        parent::display($tpl=null);
    }
}