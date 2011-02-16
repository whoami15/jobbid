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
		performAction('webmaster', 'updateStatistics');
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
	
	//Functions User
	function index() {
		$id = $_GET['skill_id'];
		if($id!=null) {
			$this->setModel('duanskill');
			$this->duanskill->showHasOne();
			$id = mysql_real_escape_string($id);
			$_SESSION['redirect_url'] = getUrl();
			$this->duanskill->where(" and skill_id=$id and duan.active=1 and nhathau_id is null and ngayketthuc>now()");
			$this->duanskill->orderBy('duan.id','desc');
			$this->duanskill->setPage(1);
			$this->duanskill->setLimit(PAGINATE_LIMIT);
			$lstDuan = $this->duanskill->search('duan.id,tenduan,alias,duan.account_id,averagecost,ngaypost,prior,views,bidcount,UNIX_TIMESTAMP(ngayketthuc)-UNIX_TIMESTAMP(now()) as timeleft,skillname');
			$totalPages = $this->duanskill->totalPages();
			$ipagesbefore = 1 - INT_PAGE_SUPPORT;
			if ($ipagesbefore < 1)
				$ipagesbefore = 1;
			$ipagesnext = 1 + INT_PAGE_SUPPORT;
			if ($ipagesnext > $totalPages)
				$ipagesnext = $totalPages;
			//print_r($lstDuan);die();
			$this->set("lstDuan",$lstDuan);
			if(isset($lstDuan[0]))
				$this->set("skillname",$lstDuan[0]['skill']['skillname']);
			else {
				$this->setModel('skill');
				$this->skill->id = $id;
				$data = $this->skill->search('skillname');
				$this->set("skillname",$data['skill']['skillname']);
			}
			$this->set('skill_id',$id);
			$this->set('pagesindex',1);
			$this->set('pagesbefore',$ipagesbefore);
			$this->set('pagesnext',$ipagesnext);
			$this->set('pageend',$totalPages);
			$this->set('title','Danh sách dự án theo kỹ năng : '.$lstDuan[0]['skill']['skillname']);
			$this->_template->render();
		}
	}
	function lstDuanBySkill($ipageindex) {
		$id = $_GET['skill_id'];
		if($id!=null) {
			$this->setModel('duanskill');
			$this->duanskill->showHasOne();
			$id = mysql_real_escape_string($id);
			$_SESSION['redirect_url'] = getUrl();
			$this->duanskill->where(" and skill_id=$id and duan.active=1 and nhathau_id is null and ngayketthuc>now()");
			$this->duanskill->orderBy('duan.id','desc');
			$this->duanskill->setPage($ipageindex);
			$this->duanskill->setLimit(PAGINATE_LIMIT);
			$lstDuan = $this->duanskill->search('duan.id,tenduan,alias,duan.account_id,averagecost,ngaypost,prior,views,bidcount,UNIX_TIMESTAMP(ngayketthuc)-UNIX_TIMESTAMP(now()) as timeleft,skillname');
			$totalPages = $this->duanskill->totalPages();
			$ipagesbefore = $ipageindex - INT_PAGE_SUPPORT;
			if ($ipagesbefore < 1)
				$ipagesbefore = 1;
			$ipagesnext = $ipageindex + INT_PAGE_SUPPORT;
			if ($ipagesnext > $totalPages)
				$ipagesnext = $totalPages;
			//print_r($lstDuan);die();
			$this->set("lstDuan",$lstDuan);
			$this->set('pagesindex',$ipageindex);
			$this->set('pagesbefore',$ipagesbefore);
			$this->set('pagesnext',$ipagesnext);
			$this->set('pageend',$totalPages);
			$this->_template->renderPage();
		}
	}
	function getSkillsByLinhvuc() {
		$this->checkLogin(true);
		$linhvuc_id = $_GET["linhvuc_id"];
		if($linhvuc_id==null)
			die("ERROR_SYSTEM");
		$data = $this->skill->custom("select * from skills as skill where linhvuc_id='$linhvuc_id' order by skillname");
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