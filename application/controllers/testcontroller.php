<?php

class TestController extends VanillaController {
	function __construct($controller, $action) {		
		global $inflect;
		$this->_controller = ucfirst($controller);
		$this->_action = $action;
		$model = "test";
		$this->$model =& new $model;
		$this->_template =& new Template($controller,$action);

	}
	function beforeAction () {

	}
	function setModel($model) {
		 $this->$model =& new $model;
	}
	function index() {
		$this->test->query("select InsertPage() as newid");
		die("done");
	
	}
       
	function afterAction() {

	}

}