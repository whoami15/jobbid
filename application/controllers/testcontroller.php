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
		//sendMail("nclong87@gmail.com", "Xin chao", "Xin chào <b>Nguyễn Chí Long</b>");
		//die("done");
		//$cache_expire = session_cache_expire();
		//echo "The cached session pages expire after $cache_expire minutes"; 
		/* include (ROOT.DS.'library'.DS.'dataprovider.php');
		$conn=new DataProvider();
		$data = $conn->getListSendmail();
		
		$arr = array();
		foreach($data as $e) {
			try {
				sendMail("nclong87@gmail.com", "Xin chao", "Xin chào <b>Nguyễn Chí Long</b>");
				array_push($arr,$e->id);
			} catch (Exception $e) {
			}
		}
		$conn->hadSend($arr);
		$conn->close(); */
		include (ROOT.DS.'library'.DS.'sendmail.php');
		$mail = new sendmail();
		$mail->send(' ',' ',' ');
		echo '<br>DONE';
		
	}
	function rmvsession($session) {
		$_SESSION[$session] = null;
		echo 'DONE';
	}
	function stop() {
		$_SESSION['flag'] = true;
	}
	function start() {
		$i=0;
		$_SESSION['flag'] = false;
		while($i<10) {
			if($_SESSION['flag']==true)
				break;
			$i++;
			sleep(1);
		}
		echo $i;
	}
	function process() {
		if(!isset($_SESSION['process']))
			$_SESSION['process'] = 0;
		$_SESSION['process'] = $_SESSION['process'] + 1;
		//Process
		sleep(10);
		//$_SESSION['process'] = $_SESSION['process'] - 1;
		echo 'DONE';
		
	}
	function pagetest() {
		$totalProcess = 0;
		if(isset($_SESSION['process']))
			$totalProcess = $_SESSION['process'];
		$this->set('totalProcess',$totalProcess);
		$this->_template->renderPage();
	}
    function restart() {
		session_destroy();
		echo "DONE";
	}	
	function afterAction() {

	}

}