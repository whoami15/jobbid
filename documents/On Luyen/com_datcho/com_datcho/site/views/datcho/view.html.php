<?php
defined('_JEXEC') or die();
jimport('joomla.application.component.view');
class DatchoViewDatcho extends JView {
    function __construct() {
        parent::__construct();
    }
    function display($tpl = null) {
        $lang=JRequest::getVar('lang');
        if(!isset($lang))
            $lang="";
        if($lang=="en")
            $this->setLayout('default-en');
        else
            $this->setLayout('default');
        parent::display($tpl=null);
    }
    
}