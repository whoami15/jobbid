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
	function viewQuanlyRaovat() {
		$this->checkAdmin(false);
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
	function mailinglist() {
		$this->checkAdmin(false);
		$this->_template->renderAdminPage(); 
	}
	function manageCaches() {
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
	function listEmail($isPre=0) {
		global $cache;
		if($isPre==1) {
			$priSenders = $cache->get("priSenders");
			if($priSenders == null)
				$priSenders = array();
			$priSenders = array_sort($priSenders,'id','asc');
			$this->set("senders",$priSenders);
		} else {
			$secSenders = $cache->get("secSenders");
			if($secSenders == null)
				$secSenders = array();
			$secSenders = array_sort($secSenders,'id','asc');
			$this->set("senders",$secSenders);
		}
		$this->set("isPre",$isPre);
		$this->_template->renderPage();
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
	function sendMailEmployer() {
		$this->checkAdmin(true);
		$i=1;
		$j=0;
		$jsonResult = "{";
		$validate = new Validate();
		while($i<=5) {
			$email = $_POST['email'.$i];
			if($email!=null) {
				//Send mail
				$result = '';
				$this->setModel('account');
				if(!$validate->check_email($email))
					$result = 'Email not valid!';
				if($result == '') {
					$strWhere = "AND username='".mysql_real_escape_string($email)."'";
					$this->account->where($strWhere);
					$account = $this->account->search('id');
					if(empty($account)==false)
						$result = 'Email has registed!';
				}
				if($result == '') {
					try {
						$result = 'Ok';
/* 						$this->account->id = null;
						$this->account->username = $email;
						$this->account->timeonline = 0;
						$this->account->role = 2;
						$this->account->active = 0;
						$account_id = $this->account->insert(true);
						$active_code = genString();
						$this->setModel('activecode');
						$this->activecode->id = null;
						$this->activecode->account_id = $account_id;
						$this->activecode->active_code = $active_code;
						$this->activecode->insert();
						//Doan nay send mail truc tiep chu ko dua vao sendmail, doan code sau chi demo sendmail
						$linkactive = BASE_PATH."/webmaster/doActive/true&account_id=$account_id&active_code=$active_code";
						$linkactive = "<a href='$linkactive'>$linkactive</a>";*/						
						global $cache;
						$content = $cache->get('mail_moinhatuyendung');
						/* $search  = array('#EMAIL#', '#LINKACTIVE#');
						$replace = array($email, $linkactive);
						$content = str_replace($search, $replace, $content); */
						$this->setModel('sendmail');
						$this->sendmail->id = null;
						$this->sendmail->to = $email;
						$this->sendmail->subject = 'Mời Bạn Đăng Tin Tuyển Dụng Miễn Phí Trên JobBid.vn!!!';
						$this->sendmail->content = $content;
						$this->sendmail->isprior = '0';
						$this->sendmail->insert();
					} catch (Exception $e) {
						$result = 'Error';
					}
				}
				$jsonResult = $jsonResult."$j:{'email':'".$email."','result':'".$result."'},";
				$j++;
			}
			$i++;
		}
		$jsonResult = substr($jsonResult,0,-1);
		$jsonResult = $jsonResult."}";
		print($jsonResult);
	}
	function sendMailFreelancer() {
		$this->checkAdmin(true);
		$this->setModel("duan");
		$this->duan->orderBy('duan.id','desc');
		$this->duan->setPage(1);
		$this->duan->setLimit(PAGINATE_LIMIT);
		$this->duan->where(" and active = 1 and nhathau_id is null and ngayketthuc>now()");
		$data = $this->duan->search('id,tenduan,alias');
		$duannew = '';
		foreach($data as $duan) {
			$duannew.='<a href="'.BASE_PATH.'/duan/view/'.$duan['duan']['id'].'/'.$duan['duan']['alias'].'">'.$duan['duan']['tenduan'].'</a><br>';
		}
		global $cache;
		$content = $cache->get('mail_moiungvien');
		$search  = array('#DUAN#');
		$replace = array($duannew);
		$content = str_replace($search, $replace, $content);
		$j=0;
		$jsonResult = "{";
		$emails = $_POST['emails'];
		$pos2 = 0;
		$pos1 = strpos($emails,";",0);
		$this->setModel('email');
		$validate = new Validate();
		while($pos1!=false) {
			$email = trim(substr($emails, $pos2, $pos1-$pos2));
			$result = '';
			try {
				if(!$validate->check_email($email))
					$result = 'Email not valid!';
				if($result=='') {
					$this->email->where(" and email='$email'");
					$data = $this->email->search();
					//print_r($data);
					if(!empty($data))
						$result = 'Had Send';
				}
				if($result=='') {
					$result = 'Ok';
					$this->email->id = null;
					$this->email->email = $email;
					$this->email->insert();

					$this->setModel('sendmail');
					$this->sendmail->id = null;
					$this->sendmail->to = $email;
					$this->sendmail->subject = 'Rất Nhiều Công Việc Bán Thời Gian Đang Chờ Bạn!!!';
					$this->sendmail->content = $content;
					$this->sendmail->isprior = '0';
					$this->sendmail->insert();
					$this->setModel('email');
				}
			} catch (Exception $e) {
				$result = 'Error';
			}
			$jsonResult = $jsonResult."$j:{'email':'".$email."','result':'".$result."'},";
			$j++;
			$pos2=$pos1+1;
			$pos1 = strpos($emails,";",$pos2);
		}
		$jsonResult = substr($jsonResult,0,-1);
		$jsonResult = $jsonResult."}";
		print($jsonResult);
	}
	function sendTest($isPre = 0) {
		$this->checkAdmin(true);
		try {
			$validate = new Validate();
			$email = '';
			$password = '';
			$smtp = '';
			$port = '';
			if($isPre==1) {
				if($validate->check_submit(1,array("primary_email","primary_password","primary_smtp","primary_port"))==false)
					die('ERROR_SYSTEM');
				$email = $_POST['primary_email'];
				$password = $_POST['primary_password'];
				$smtp = $_POST['primary_smtp'];
				$port = $_POST['primary_port'];
			} else {
				if($validate->check_submit(1,array("second_email","second_password","second_smtp","second_port"))==false)
					die('ERROR_SYSTEM');
				$email = $_POST['second_email'];
				$password = $_POST['second_password'];
				$smtp = $_POST['second_smtp'];
				$port = $_POST['second_port'];
			}
			$sender = array("email"=>$email,'password'=>$password,'smtp'=>$smtp,'port'=>$port);
			include (ROOT.DS.'library'.DS.'sendmail.php');
			$mail = new sendmail();
			$mail->send(EMAIL_TEST,'JobBid.vn - Mail Thử Nghiệm!','Xin chào bạn, chúng tôi là mạng freelancer!',$sender);
			echo 'DONE';
		} catch (Exception $e) {
			echo 'ERROR_SYSTEM';
		}
	}
	function saveEmail($isPre=0) {
		$this->checkAdmin(true);
		try {
			$validate = new Validate();
			global $cache;
			if($isPre==1) {
				if($validate->check_submit(1,array("primary_id","primary_email","primary_password","primary_smtp","primary_port"))==false)
					die('ERROR_SYSTEM');
				$primary_id = isset($_POST['primary_id'])?$_POST['primary_id']:null;
				$primary_email = $_POST['primary_email'];
				$primary_password = $_POST['primary_password'];
				$primary_smtp = $_POST['primary_smtp'];
				$primary_port = $_POST['primary_port'];
				if($validate->check_null(array($primary_email,$primary_password,$primary_smtp,$primary_port))==false)
					die('ERROR_SYSTEM');
				$priSenders = $cache->get('priSenders');
				if($priSenders == null)
					$priSenders = array();
				if($primary_id == null) { //insert new
					$i = 0;
					$len = count($priSenders);
					while($i<$len) {
						$inPreSenders = false;
						foreach($priSenders as $sender) {
							if($sender['id']==$i) {
								$inPreSenders = true;
							}
						}
						if($inPreSenders == false)
							break;
						$i++;
					}
					$newPriSender = array("id"=>$i,"email"=>$primary_email,'password'=>$primary_password,'smtp'=>$primary_smtp,'port'=>$primary_port);
					array_push($priSenders,$newPriSender);
					$cache->set('priSenders',$priSenders);
				} else { //update
					$i = 0;
					$len = count($priSenders);
					while($i<$len) {
						if($priSenders[$i]['id']==$primary_id) {
							$priSenders[$i]['email'] = $primary_email;
							$priSenders[$i]['password'] = $primary_password;
							$priSenders[$i]['smtp'] = $primary_smtp;
							$priSenders[$i]['port'] = $primary_port;
							break;
						}
						$i++;
					}
					$cache->set('priSenders',$priSenders);
				}
			} else {
				if($validate->check_submit(1,array("second_id","second_email","second_password","second_smtp","second_port"))==false)
					die('ERROR_SYSTEM');
				$second_id = $_POST['second_id'];
				$second_email = $_POST['second_email'];
				$second_password = $_POST['second_password'];
				$second_smtp = $_POST['second_smtp'];
				$second_port = $_POST['second_port'];
				if($validate->check_null(array($second_email,$second_password,$second_smtp,$second_port))==false)
					die('ERROR_SYSTEM');
				$secSenders = $cache->get('secSenders');
				if($secSenders == null)
					$secSenders = array();
				if($second_id == null) { //insert new
					$i = 0;
					$len = count($secSenders);
					while($i<$len) {
						$inSecSenders = false;
						foreach($secSenders as $sender) {
							if($sender['id']==$i) {
								$inSecSenders = true;
							}
						}
						if($inSecSenders == false)
							break;
						$i++;
					}
					$newSecSender = array("id"=>$i,"email"=>$second_email,'password'=>$second_password,'smtp'=>$second_smtp,'port'=>$second_port);
					array_push($secSenders,$newSecSender);
					$cache->set('secSenders',$secSenders);
				} else { //update
					$i = 0;
					$len = count($secSenders);
					while($i<$len) {
						if($secSenders[$i]['id']==$second_id) {
							$secSenders[$i]['email'] = $second_email;
							$secSenders[$i]['password'] = $second_password;
							$secSenders[$i]['smtp'] = $second_smtp;
							$secSenders[$i]['port'] = $second_port;
							break;
						}
						$i++;
					}
					$cache->set('secSenders',$secSenders);
				}
			}
			echo 'DONE';
		} catch (Exception $e) {
			echo 'ERROR_SYSTEM';
		}
	}
	function removeEmail($isPri=0) {
		$id = $_GET['id'];
		global $cache;
		if($isPri == 1) {
			$priSenders = $cache->get('priSenders');
			if($priSenders == null)
				$priSenders = array();
			$len = count($priSenders);
			$i=0;
			//print_r($priSenders);die();
			while($i<$len) {
				if($priSenders[$i]['id'] == $id) {
					unset($priSenders[$i]);
					break;
				}
				$i++;
			}
			$priSenders = array_values($priSenders);
			$cache->set('priSenders',$priSenders);
		} else {
			$secSenders = $cache->get('secSenders');
			if($secSenders == null)
				$secSenders = array();
			$len = count($secSenders);
			$i=0;
			while($i<$len) {
				if($secSenders[$i]['id'] == $id) {
					unset($secSenders[$i]);
					break;
				}
				$i++;
			}
			$secSenders = array_values($secSenders);
			$cache->set('secSenders',$secSenders);
		}
		echo 'DONE';
	}
	function afterAction() {

	}

}