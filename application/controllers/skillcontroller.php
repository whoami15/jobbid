<?php

class SkillController extends VanillaController {
	function __construct($controller, $action) {		
		global $inflect;
		$this->_controller = ucfirst($controller);		
		$this->_action = $action;
		$model = "skill";
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
	function index() {
	}
	function listSkills($ipageindex) {
		//die("ERROR_NOTLOGIN");
		$this->checkAdmin(true);
		$this->skill->showHasOne();
		$this->skill->orderBy('skill.id','desc');
		$this->skill->setPage($ipageindex);
		$this->skill->setLimit(PAGINATE_LIMIT);
		$lstskills = $this->skill->search("skill.id,skillname,linhvuc_id,tenlinhvuc");
		$totalPages = $this->skill->totalPages();
		$ipagesbefore = $ipageindex - INT_PAGE_SUPPORT;
		if ($ipagesbefore < 1)
			$ipagesbefore = 1;
		$ipagesnext = $ipageindex + INT_PAGE_SUPPORT;
		if ($ipagesnext > $totalPages)
			$ipagesnext = $totalPages;
		$this->set("lstSkills",$lstskills);
		$this->set('pagesindex',$ipageindex);
		$this->set('pagesbefore',$ipagesbefore);
		$this->set('pagesnext',$ipagesnext);
		$this->set('pageend',$totalPages);
		$this->_template->renderPage();
	}
	
	function saveSkill() {
		try {
			$this->checkAdmin(true);
			$id = $_POST["skill_id"];
			$skillname = $_POST["skill_skillname"];
			$linhvuc_id = $_POST["skill_linhvuc_id"];
			if($id==null) { //insert
				$this->skill->id = null;
				$this->skill->skillname = $skillname;
				$this->skill->linhvuc_id = $linhvuc_id;
				$this->skill->save();						
			} else { //update
				$this->skill->id = $id;
				$this->skill->skillname = $skillname;
				$this->skill->linhvuc_id = $linhvuc_id;
				$this->skill->save();		
			}
			echo "DONE";
		} catch (Exception $e) {
			echo 'ERROR_SYSTEM';
		}
	} 
	function deleteSkill() {
		try {
			$this->checkAdmin(true);
			$id = $_GET["skill_id"];
			if($id==null) { //insert
				die("ERROR_SYSTEM");						
			} else { //update
				$this->skill->id = $id;
				$this->skill->delete();
			}
			echo "DONE";
		} catch (Exception $e) {
			echo 'ERROR_SYSTEM';
		}
	}
	function getSkillsByLinhvuc() {
		$this->checkLogin(true);
		$linhvuc_id = $_GET["linhvuc_id"];
		if($linhvuc_id==null)
			die("ERROR_SYSTEM");
		$data = $this->skill->custom("select * from skills as skill where linhvuc_id='$linhvuc_id'");
		$jsonResult = "{";
		$i=0;
		$len = count($data);
		while($i<$len) {
			$skill = $data[$i];
			$jsonResult = $jsonResult."$i:{'id':".$skill["skill"]["id"].",'skillname':'".$skill["skill"]["skillname"]."'}";
			if($i < $len-1)
				$jsonResult = $jsonResult.",";
			$i++;
		}
		$jsonResult = $jsonResult."}";
		print($jsonResult);
	}
	function getSkillsByDuan() {
		//$this->checkLogin(true);
		$duan_id = $_GET["duan_id"];
		if($duan_id==null)
			die("ERROR_SYSTEM");
		$this->setModel("duanskill");
		$this->duanskill->showHasOne();
		$this->duanskill->where(" and duan_id=$duan_id ");
		$data = $this->duanskill->search("skill.id,skillname");
		$jsonResult = "{";
		$i=0;
		$len = count($data);
		while($i<$len) {
			$skill = $data[$i];
			$jsonResult = $jsonResult."$i:{'id':".$skill["skill"]["id"].",'skillname':'".$skill["skill"]["skillname"]."'}";
			if($i < $len-1)
				$jsonResult = $jsonResult.",";
			$i++;
		}
		$jsonResult = $jsonResult."}";
		print($jsonResult);
	}
	function afterAction() {

	}

}