<?php

class AdminController extends VanillaController {
	function __construct($controller, $action) {		
		global $inflect;
		$this->_controller = ucfirst($controller);
		$this->flagRedirect = false;
		$this->_action = $action;
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
	function index() {
		$this->checkAdmin(false);
		$this->_template->renderAdminPage(); 
	}
	function viewAdminMenu() {
		$this->checkAdmin(false);
		$this->_template->renderAdminPage(); 
	}
	function viewAdminPage() {
		$this->checkAdmin(false);
		$this->setModel("menu");
		$this->menu->orderBy('order','ASC');
		$lstMenus = $this->menu->search();
		$this->set("lstMenus",$lstMenus);
		$this->_template->renderAdminPage(); 
	}
	function viewAdminArticle() {
		$this->checkAdmin(false);
		$this->_template->renderAdminPage(); 
	}
	function viewAdminAccount() {
		$this->checkAdmin(false);
		$this->_template->renderAdminPage(); 
	}
	function viewQuanlyLinhvuc() {
		$this->checkAdmin(false);
		$this->_template->renderAdminPage(); 
	}
	function viewQuanlyNhathau() {
		$this->checkAdmin(false);
		$this->setModel("linhvuc");
		$data = $this->linhvuc->search();
		$this->set("lstLinhvuc",$data);
		$this->_template->renderAdminPage(); 
	}
	function viewQuanlyDuan() {
		$this->checkAdmin(false);
		$this->setModel("linhvuc");
		$data = $this->linhvuc->search();
		$this->set("lstLinhvuc",$data);
		$this->setModel("tinh");
		$data = $this->tinh->search();
		$this->set("lstTinh",$data);
		$this->_template->renderAdminPage(); 
	}
	function viewQuanlySkill() {
		$this->checkAdmin(false);
		$this->setModel("linhvuc");
		$data = $this->linhvuc->search();
		$this->set("lstLinhvuc",$data);
		$this->_template->renderAdminPage(); 
	}
	function viewQuanlyHosothau() {
		$this->checkAdmin(false);
		$this->_template->renderAdminPage(); 
	}
	function viewCongcuPR() {
		$this->checkAdmin(false);
		$this->_template->renderAdminPage(); 
	}
	function settings() {
		$this->checkAdmin(false);
		global $cache;
		$arrType = $cache->get("imageTypes");
		$imageTypes = "";
		if($arrType!=null) {
			foreach($arrType as $type) {
				$imageTypes = $imageTypes.$type.",";
			}
		}
		$this->set("imageTypes",$imageTypes);
		$arrType = $cache->get("fileTypes");
		$fileTypes = "";
		if($arrType!=null) {
			foreach($arrType as $type) {
				$fileTypes = $fileTypes.$type.",";
			}
		}
		$this->set("fileTypes",$fileTypes);
		$this->_template->renderAdminPage(); 
	}
	function saveSettings() {
		try {
			global $cache;
			$this->checkAdmin(false);
			$imageTypes = $_POST["imagetypes"];
			$fileTypes = $_POST["filetypes"];
			if(!isEmpty($imageTypes)) {
				$imageTypes = strtolower($imageTypes);
				$i=0;
				$len = strlen($imageTypes);
				$type = "";
				$arrType = array();
				while($i<$len) {
					$c = $imageTypes[$i];
					if($c==',' || $i==$len-1) {
						if($i==$len-1 && $c!=',')
							$type = $type.$c;
						$type = trim($type);
						if(strlen($type)>0)
							array_push($arrType,$type);
						$type="";
					} else {
						$type = $type.$c;
					}
					$i++;
				}
				$cache->set("imageTypes",$arrType);
			}
			if(!isEmpty($fileTypes)) {
				$fileTypes = strtolower($fileTypes);
				$i=0;
				$len = strlen($fileTypes);
				$type = "";
				$arrType = array();
				while($i<$len) {
					$c = $fileTypes[$i];
					if($c==',' || $i==$len-1) {
						if($i==$len-1 && $c!=',')
							$type = $type.$c;
						$type = trim($type);
						if(strlen($type)>0)
							array_push($arrType,$type);
						$type="";
					} else {
						$type = $type.$c;
					}
					$i++;
				}
				$cache->set("fileTypes",$arrType);
			}
			echo "DONE";
		} catch (Exception $e) {
			echo 'ERROR_SYSTEM';
		}
	}
	function login() {		
		$this->_template->renderPage();  	  
	}
	function uploadImage() {
		//header('Content-type: text/plain');
		$this->checkAdmin(true);
		global $cache;
        $ma=time();
        if($_FILES['image']['name']!=NULL) {
            $str=$_FILES['image']['tmp_name'];
            $size= $_FILES['image']['size'];

            if($size==0) {
                die("<span id='result'>ERROR_SYSTEM</span>");
            }
            else {
				$dir = ROOT . DS . 'public'. DS . 'upload' . DS . 'images' . DS;
				$filename = preg_replace("/[&' +-]/","_",$_FILES['image']['name']);				
                move_uploaded_file($_FILES['image']['tmp_name'],$dir . $filename);
				//die($filename);
                $sFileType="";
				$i = strlen($filename)-1;
				while($i>=0) {
					if($filename[$i]=='.')
						break;
					$sFileType=$filename[$i].$sFileType;
					$i--;
				}
                $str=$dir . $filename;
                $fname=$ma.'_'.$filename;
				$arrType = $cache->get("imageTypes");
                if(!in_array(strtolower($sFileType),$arrType)) {
                    unlink($str);
                    die("<span id='result'>ERROR_WRONGFORMAT</span>");
                }
                else {
                    $str2= $dir . $fname;
                    rename($str,$str2);
					$this->setModel("image");
					$this->image->id = null;
					$this->image->filename = $fname;
					$this->image->fileurl = BASE_PATH."/upload/images/".$fname;
					$this->image->save();
                }
            }
        }
        echo "<span id='result'>DONE</span>";
    }
	function getMailTemplate() {
		$this->checkAdmin(true);
		$mailtype = $_GET['mail_type'];
		if(isset($mailtype)) {
			global $cache;
			$content = $cache->get($mailtype);
			if($content!=null)
				echo $content;
		}
	}
	function saveMailTemplate() {
		$this->checkAdmin(true);
		$mailtype = $_POST['mail_type'];
		$content = $_POST['mail_content'];
		if(isset($mailtype) && isset($content)) {
			global $cache;
			$cache->set($mailtype,$content);
			echo 'DONE';
		} else
			echo 'ERROR_SYSTEM';
	}
	function afterAction() {

	}

}