<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of admincontroller
 *
 * @author nclong
 */
class MenuController extends VanillaController {
	function __construct($controller, $action) {
		global $inflect;

		$this->_controller = ucfirst($controller);
		$this->_action = $action;
		$model = "menu";
		$this->$model =& new $model;
		$this->_template =& new Template($controller,$action);

	}
	function checkLogin($isAjax=false) {
		if($isAjax==false)
			$_SESSION['redirect_url'] = getUrl();
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
	function afterAction() {

	}
	function listMenus($ajax) {
		$this->checkAdmin(true);
		$this->menu->orderBy('`order`','ASC');
		$lstMenus = $this->menu->search();
		$this->set("lstMenus",$lstMenus);
		$this->_template->renderPage();
	}
	function activeMenu($id=null) {
		$this->checkAdmin(true);
		if($id!=null) {
			$this->menu->id = $id;
			$this->menu->active = 1;
			$this->menu->save();
			$this->cacheMenus();
			echo "DONE";
		}
	}
	function unActiveMenu($id=null) {
		$this->checkAdmin(true);
		if($id!=null) {
			$this->menu->id = $id;
			$this->menu->active = 0;
			$this->menu->save();
			$this->cacheMenus();
			echo "DONE";
		}
	}
	function saveMenu() {
		
		$this->checkAdmin(true);
		$id = $_POST["menu_id"];
		$name = $_POST["menu_name"];
		$url = $_POST["menu_url"];
		$order = $_POST["menu_order"];
		if($id==null) { //insert
			die("ERROR_SYSTEM");						
		} 
		$this->menu->id = $id;
		$menu = $this->menu->search();
		$this->menu->id = $id;
		$this->menu->name = $name;
		$this->menu->url = $url;
		$this->menu->order = $order;
		if(empty($menu)==false) { //update
			$this->menu->active = $menu["menu"]["active"];
			$this->menu->update();
		} else {
			$this->menu->active = 1;
			$this->menu->insert();
		}
		$this->cacheMenus();
		echo "DONE";
	}
	function cacheMenus() {
		$this->checkAdmin(true);
		global $cache;
		$this->menu->where('AND active=1');
		$this->menu->orderBy('`order`','ASC');
		$data = $this->menu->search();
		$cache->set("menuList",$data);
	}
	function exist($id=null){
		$this->checkAdmin(true);
		if($id==null)
			die("ERROR_SYSTEM");
		$this->menu->id = $id;
		$menu = $this->menu->search();
		if(empty($menu)) {
			echo "0";
		} else {
			echo "1";
		}
	}
	function deleteMenu() {
		$this->checkAdmin(true);
		if(!isset($_GET["id"]))
			die("ERROR_SYSTEM");
		$id = $_GET["id"];
		$this->menu->id=$id;
		if($this->menu->delete()==-1) {
			echo "ERROR_SYSTEM";
		} else {
			$this->cacheMenus();
			echo "DONE";
		}
	}
	function __destruct()
	{

	}

}

