<?php
defined('_JEXEC')or die('Restricted Access'); 
jimport('joomla.application.component.controller');
class DatchoControllerDatcho extends JController {
    function __construct() {
        parent::__construct();
    }
    function display() {
        $view =   $this->getView('datcho', 'html');
        $model =   $this->getModel('datcho');
        $view->setModel($model, true);
        $view->display();
    }
    
}
?>