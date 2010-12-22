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
class WidgetController extends VanillaController {
	function __construct($controller, $action) {
		global $inflect;

		$this->_controller = ucfirst($controller);
		$this->_action = $action;
		$model = "widget";
		$this->$model =& new $model;
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
	function afterAction() {

	}
	function getContentById($id=null) {	
		if($id != null && $id != 0) {
			$this->widget->id=$id;
            $tintuc=$this->widget->search();
			print_r($tintuc['widget']['content']);
		}
	}
	function layout() {
		global $cache;
		$data = $cache->get("banner");
		$this->set('banner',$data);
		$data = $cache->get("menu");
		$this->set('menu',$data);
		//$data = $cache->get("leftcol");
		//$this->set('leftcol',$data);
		$data = $cache->get("rightcol");
		$this->set('rightcol',$data);
		$data = $cache->get("footer");
		$this->set('footer',$data);
		$this->_template->renderPage();
	}
	function listWidgets($ajax=true) {
		$this->checkAdmin(true);
		$this->setModel("widget");
		$this->widget->orderBy('position','DESC');
		$lstWidgets = $this->widget->search();
		$this->set("lstWidgets",$lstWidgets);
		$this->_template->renderPage();
	}
	function cacheWidgets($isAjax=false) {
		$this->checkAdmin(true);
		global $cache;
		$this->setModel("widget");
		$this->widget->where(" AND position='banner' AND active=1");
		$this->widget->orderBy('`order`','ASC');
		$data = $this->widget->search();
		if(!empty($data))
			$cache->set("banner",$data[0]);
		$this->widget->where(" AND position='menu' AND active=1");
		$this->widget->orderBy('`order`','ASC');
		$data = $this->widget->search();
		if(!empty($data))
			$cache->set("menu",$data[0]);
		$this->widget->where(" AND position='footer' AND active=1");
		$this->widget->orderBy('`order`','ASC');
		$data = $this->widget->search();
		if(!empty($data))
			$cache->set("footer",$data[0]);
		// $this->widget->where(" AND position='leftcol' AND active=1");
		// $this->widget->orderBy('`order`','ASC');
		// $data = $this->widget->search();
		// $cache->set("leftcol",$data);
		$this->widget->where(" AND position='rightcol' AND active=1");
		$this->widget->orderBy('`order`','ASC');
		$data = $this->widget->search();
		if(!empty($data))
			$cache->set("rightcol",$data);
		if($isAjax)
			echo "DONE";
	}
	function saveWidget() {
		$this->checkAdmin(true);
		$this->setModel("widget");
		$id = $_POST["widget_id"];
		$name = $_POST["widget_name"];
		$content = $_POST["widget_content"];
		$start = strpos($content, ">")+1;
		$len  = strpos($content, "</p>") - $start;		
		$content= substr($content, $start, $len);
		$position = $_POST["widget_position"];
		$order = $_POST["widget_order"];
		$showtitle = $_POST["widget_showtitle"];
		$iscomponent = $_POST["widget_iscomponent"];
		if($id==null) { //insert
			$this->widget->id = null;
			$this->widget->name = $name;
			$this->widget->content = $content;
			$this->widget->position = $position;
			$this->widget->order = $order;
			$this->widget->iscomponent = $iscomponent;
			$this->widget->showtitle = $showtitle;
			$this->widget->active = 1;
			$this->widget->save();						
		} else { //update
			$this->widget->id = $id;
			$this->widget->name = $name;
			$this->widget->content = $content;
			$this->widget->position = $position;
			$this->widget->order = $order;
			$this->widget->showtitle = $showtitle;
			$this->widget->iscomponent = $iscomponent;
			$this->widget->save();		
		}
		$this->cacheWidgets(false);
		echo "DONE";
	}
	function activeWidget($id=0) {
		$this->checkAdmin(true);
		if($id!=0) {
			$this->setModel("widget");
			$this->widget->id = $id;
			$this->widget->active = 1;
			$this->widget->update();
			$this->cacheWidgets(false);
			echo "DONE";
		}
	}
	function unActiveWidget($id=0) {
		$this->checkAdmin(true);
		if($id!=0) {
			$this->setModel("widget");
			$this->widget->id = $id;
			$this->widget->active = 0;
			$this->widget->update();
			$this->cacheWidgets(false);
			echo "DONE";
		}
	}
	
	function saveLayout() {
		$this->checkAdmin(true);
		$arrId = $_POST["id"];
		$arrPosition = $_POST["position"];
		$arrOrder = $_POST["order"];
		$this->setModel("widget");
		for($i=0;$i<count($arrId);$i++) {
			$position = ($arrPosition[$i]==null)?"rightcol":$arrPosition[$i];
			$order = ($arrOrder[$i]==null)?10:$arrOrder[$i];
			$id = ($arrId[$i]==null)?0:$arrId[$i];			
			$this->widget->id = $id;
			$this->widget->position = $position;
			$this->widget->order = $order;
			$this->widget->save();
		}
		$this->cacheWidgets(false);
		echo "DONE";
	}
	function deleteWidget() {
		$this->checkAdmin(true);
		if(!isset($_GET["id"]))
			die("ERROR_SYSTEM");
		$id = $_GET["id"];
		$this->widget->id=$id;
		if($this->widget->delete()==-1) {
			echo "ERROR_SYSTEM";
		} else {
			$this->cacheWidgets(false);
			echo "DONE";
		}
	}
	function __destruct()
	{

	}

}

