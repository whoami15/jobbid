<?php

class IndexController extends VanillaController {
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
		performAction('webmaster', 'updateStatistics');
	}
	function setModel($model) {
		 $this->$model =& new $model;
	}
	function index() {
		//error('Test');
		//print_r(session_cache_expire());die();
		$this->setModel("duan");
		$this->duan->showHasOne(array('linhvuc'));
		$this->duan->orderBy('duan.timeupdate','desc');
		$this->duan->setPage(1);
		$this->duan->setLimit(15);
		$this->duan->where(" and active = 1 and nhathau_id is null and ngayketthuc>now()");
		$data = $this->duan->search("duan.id,tenduan,alias,linhvuc_id,tenlinhvuc,averagecost,ngaypost,prior,views,bidcount,UNIX_TIMESTAMP(ngayketthuc)-UNIX_TIMESTAMP(now()) as timeleft,duan.active");
		$this->set("lstData1",$data);
		$this->duan->showHasOne(array('nhathau','hosothau'));
		$this->duan->orderBy('timeupdate','desc');
		$this->duan->setPage(1);
		$this->duan->setLimit(7);
		$this->duan->where(" and duan.active = 1 and duan.nhathau_id is not null");
		$data = $this->duan->search("duan.id,tenduan,alias,linhvuc_id,tenlinhvuc,giathau,prior,bidcount,displayname,duan.nhathau_id,duan.active,nhathau_alias");
		$this->set("lstData2",$data);
		$this->setModel("linhvuc");
		$data = $this->linhvuc->search();
		$this->set("lstLinhvuc",$data);
		$this->_template->render();
	}
    function viewmore($page=2) {
		$this->setModel("duan");
		$this->duan->showHasOne(array('linhvuc'));
		$this->duan->orderBy('duan.timeupdate','desc');
		$this->duan->setPage($page);
		$this->duan->setLimit(15);
		$this->duan->where(" and active = 1 and nhathau_id is null and ngayketthuc>now()");
		$data = $this->duan->search("duan.id,tenduan,alias,linhvuc_id,tenlinhvuc,averagecost,ngaypost,prior,views,bidcount,UNIX_TIMESTAMP(ngayketthuc)-UNIX_TIMESTAMP(now()) as timeleft,duan.active");
		$jsonResult = "{";
		$i=0;
		$len = count($data);
		while($i<$len) {
			$linkduan = BASE_PATH."/duan/view/".$data[$i]["duan"]["id"]."/".$data[$i]["duan"]["alias"];
			$linkduan = mysql_real_escape_string($linkduan);
			$tenduan = mysql_real_escape_string($data[$i]['duan']['tenduan']);
			$tenlinhvuc = mysql_real_escape_string($data[$i]['linhvuc']['tenlinhvuc']);
			$averagecost = formatMoney($data[$i]['duan']['averagecost']);
			$views = $data[$i]['duan']['views'];
			$bidcount = $data[$i]['duan']['bidcount'];
			$lefttime = getDaysFromSecond($data[$i]["duan"]["active"]==1?$data[$i][""]["timeleft"]:0);
			$jsonResult = $jsonResult."$i:{'views':$views,'bidcount':$bidcount,'linkduan':'$linkduan','tenduan':'$tenduan','tenlinhvuc':'$tenlinhvuc','averagecost':'$averagecost','lefttime':'$lefttime'},";
			$i++;
		}
		$jsonResult = substr($jsonResult,0,-1);
		$jsonResult = $jsonResult."}";
		print($jsonResult);
		//$this->set("lstData1",$data);
	}
	function afterAction() {

	}

}