<?php
defined('_JEXEC') or die();
require_once(JPATH_COMPONENT.DS.'controller.php');
$controllerName = JRequest::getCmd('action');
if( $controller = JRequest::getVar('controller') ) {
    require_once (JPATH_COMPONENT.DS.'controllers'.DS.$controller.'.php');
}

switch ($controllerName) {
    case 'dmdiemxuatphat':
        $classname = 'TourdulichController'.$controller;
        break;
    case 'dmdiemden':
        $classname = 'TourdulichController'.$controller;
        break;
	case 'nhomtour':
        $classname = 'TourdulichController'.$controller;
        break;	
    default:
        $classname = 'TourdulichController'.$controller;
}
$controller = new $classname();
$controller->execute( JRequest::getVar('task'));
$controller->redirect();
?>