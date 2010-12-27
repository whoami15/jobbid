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
		//$this->test->query("select InsertPage() as newid");
		echo(ROOT . DS . 'config' . DS ."dataprovider.php");
		//$conn=new DataProvider();
		//$conn->test('nguyen chi long');
		//$conn->close();
		//die("done");
	
	}
    function restart() {
		session_destroy();
		echo "DONE";
	}	
	function afterAction() {

	}

}