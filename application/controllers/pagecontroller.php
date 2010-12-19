<?php

class PageController extends VanillaController {
	function __construct($controller, $action) {		
		global $inflect;
		$this->_controller = ucfirst($controller);		
		$this->_action = $action;
		$model = "page";
		$this->$model =& new $model;
		$this->_template =& new Template($controller,$action);
	}
	function beforeAction () {

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
	function setModel($model) {
		 $this->$model =& new $model;
	}
	function view($id=null) {
		if($id != null && $id != 0) {
			$this->page->id=$id;
            $page=$this->page->search();
			$this->set("page",$page);
		}
		$this->_template->render();
	}
	function getContentById($id=null) {	
		if($id != null && $id != 0) {
			$this->page->id=$id;
            $page=$this->page->search();
			print_r($page['page']['content']);
		}
	}
    function listPages($ajax) {
		$this->checkAdmin(true);
		$query = "SELECT id,alias,title,datemodified,usermodified,menu_id,active FROM `pages` as `page` WHERE '1'='1' ORDER BY `page`.`id` DESC";		
		$lstPages = $this->page->custom($query);
		$this->set("lstPages",$lstPages);
		$this->_template->renderPage();
	}
	function activePage($id=0) {
		$this->checkAdmin(true);
		if($id!=0) {
			$this->page->id = $id;
			$this->page->active = 1;
			$this->page->save();
			echo "DONE";
		}
	}
	function unActivePage($id=0) {
		$this->checkAdmin(true);
		if($id!=0) {
			$this->page->id = $id;
			$this->page->active = 0;
			$this->page->save();
			echo "DONE";
		}
	}
	function savePage() {
		//die("ERROR_NOTLOGIN");
		$this->checkAdmin(true);
		try {
			$id = $_POST["page_id"];
			$title = $_POST["page_title"];
			$alias = $_POST["page_alias"];
			$menu_id = $_POST["page_menu"];
			$content = $_POST["page_content"];
			if($id==null) { //insert
				$this->page->id = null;
				$this->page->title = $title;
				$this->page->alias = $alias;
				$this->page->content = $content;
				$this->page->datemodified = GetDateSQL();
				$this->page->usermodified = $_SESSION["account"]["username"];
				$this->page->menu_id = $menu_id;
				$this->page->active = 1;
			} else { //update
				$this->page->id = $id;
				$this->page->title = $title;
				$this->page->alias = $alias;
				$this->page->content = $content;
				$this->page->datemodified = GetDateSQL();
				$this->page->usermodified = $_SESSION["account"]["username"];
				$this->page->menu_id = $menu_id;
			}
			$html = new HTML;
			$value = "{'datemodified':'".$html->format_date($this->page->datemodified,'d/m/Y H:i:s')."','usermodified':'".$this->page->usermodified."'}";
			$id = $this->page->save();	
			if(isEmpty($menu_id)==false) {
				$this->setModel("menu");
				$this->menu->id = $menu_id;
				$this->menu->url = BASE_PATH."/page/view/".$id."/".$alias;
				$this->menu->save();
				global $cache;
				$this->menu->where('AND active=1');
				$this->menu->orderBy('order','ASC');
				$data = $this->menu->search();
				$cache->set("menuList",$data);
			}
			print($value);
		} catch (Exception $e) {
			echo 'ERROR_SYSTEM';
		}
		
	}    
	function deletePage() {
		$this->checkAdmin(true);
		if(!isset($_GET["id"]))
			die("ERROR_SYSTEM");
		$id = $_GET["id"];
		$this->page->id=$id;
		if($this->page->delete()==-1) {
			echo "ERROR_SYSTEM";
		} else {
			echo "DONE";
		}
	}
	function afterAction() {

	}

}