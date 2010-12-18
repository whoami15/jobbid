<?php

class WebmasterController extends VanillaController {
	function __construct($controller, $action) {		
		global $inflect;
		$this->_controller = ucfirst($controller);		
		$this->_action = $action;
		$this->_template =& new Template($controller,$action);
	}
	function beforeAction () {

	}
	function error() {	
		$msg = $_SESSION["msg"];
		$_SESSION["msg"] = null;
		$this->set("msg",$msg);
		$this->_template->render();  	  
	}
	function help() {	
		$this->_template->render();  	  
	}
	function afterAction() {

	}

}