<?php

class UtilController extends VanillaController {
	function __construct($controller, $action) {		
		global $inflect;
		$this->_controller = ucfirst($controller);
		
		$this->_action = $action;
		$this->_template =& new Template($controller,$action);

	}
	function checkLogin($isAjax=false) {
		if(!isset($_SESSION['account'])) {
			if($isAjax == true) {
				die("ERROR_NOTLOGIN");
			} else {
				redirect(BASE_PATH.'/account/login');
				die();
			}
		}
	}
	function checkAdmin($isAjax=false) {
		if($isAjax==false)
			$_SESSION['redirect_url'] = getUrl();
		if(!isset($_SESSION['account']) || $_SESSION["account"]["role"]>1) {
			if($isAjax == true) {
				die("ERROR_NOTLOGIN");
			} else {
				redirect(BASE_PATH.'/admin/login&reason=admin');
				die();
			}
		}
	}
	function beforeAction () {

	}
	function setModel($model) {
		 $this->$model =& new $model;
	}
	function index() {
	
	}
	function setArrayType() {
		$this->checkAdmin(false);
		global $cache;
		$arrType = array("jpg","png","bmp","jpeg","gif","JPG","PNG","BMP","JPEG","GIF");
		$cache->set("uploadtype",$arrType);
	}
	function test() {
		$this->setModel("data");
		$this->data->where(" and data like '%Xây%'");
		$data = $this->data->search("*",true);
		print_r($data);
	}
	function resetCache() {
		$this->checkAdmin(true);
		global $cache;
		$this->setModel("widget");
		$strWhere = "AND position='banner' ";
		$strWhere .= "AND active=1 ";
		$this->widget->where($strWhere);
		$this->widget->orderBy('order','ASC');
		$data = $this->widget->search();
		$cache->set("banner",$data[0]);
		$strWhere = "AND position='menu' ";
		$strWhere .= "AND active=1 ";
		$this->widget->where($strWhere);
		$this->widget->orderBy('order','ASC');
		$data = $this->widget->search();
		$cache->set("menu",$data[0]);
		$strWhere = "AND position='footer' ";
		$strWhere .= "AND active=1 ";
		$this->widget->where($strWhere);
		$this->widget->orderBy('order','ASC');
		$data = $this->widget->search();
		$cache->set("footer",$data[0]);
		$strWhere = "AND position='leftcol' ";
		$strWhere .= "AND active=1 ";
		$this->widget->where($strWhere);
		$this->widget->orderBy('order','ASC');
		$data = $this->widget->search();
		$cache->set("leftcol",$data);
		$strWhere = "AND position='rightcol' ";
		$strWhere .= "AND active=1 ";
		$this->widget->where($strWhere);
		$this->widget->orderBy('order','ASC');
		$data = $this->widget->search();
		$cache->set("rightcol",$data);
		$this->setModel("menu");
		$this->menu->where('AND active=1');
		$this->menu->orderBy('order','ASC');
		$data = $this->menu->search();
		$cache->set("menuList",$data);
	}
	
	function captcha() {
		//die("a");
		$width = isset($_GET['width']) ? $_GET['width'] : '120';
		$height = isset($_GET['height']) ? $_GET['height'] : '40';
		$characters = isset($_GET['characters']) && $_GET['characters'] > 1 ? $_GET['characters'] : '6';
		$captcha = new Captcha($width,$height,$characters);
	}
	function rmvsession() {
		session_destroy();
		echo "DONE";
	}
	function afterAction() {

	}

}